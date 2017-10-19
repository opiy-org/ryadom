<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.08.2017
 * Time: 8:25
 */

namespace console\controllers;

use common\commands\AddToTimelineCommand;
use common\helpers\CacheHelper;
use common\helpers\FileHelper;
use common\helpers\YmapsHelper;
use common\models\base\City;
use common\models\base\Filial;
use common\models\base\Organization;
use common\models\base\Review;
use Exception;
use phpQuery;
use yii\base\Module;
use yii\console\Controller;
use yii\httpclient\Client;


/**
 * Class FlampParseController
 * @package console\controllers
 */
class FlampParseController extends Controller
{

    /**
     * @var $city_alias
     */
    public $city_alias;


    /**
     * @var $city City
     */
    private $city;
    /**
     * @var array Organizations
     */
    private $organizations = [];
    /**
     * @var array Filials
     */
    private $filials = [];

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return ['city_alias'];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return ['c' => 'city_alias'];
    }


    /**
     * FlampParseController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $orgs = Organization::find()->all();
        /** @var Organization $org */
        foreach ($orgs as $org) {
            $this->organizations[$org->id] = $org->title;
        }

        $fils = Filial::find()->all();
        /** @var Filial $fil */
        foreach ($fils as $fil) {
            $this->filials[$fil->id] = $fil->title;
        }

    }


    /**
     * @throws \yii\console\Exception
     */
    public function actionIndex()
    {

        $this->city = City::find()->where(['alias' => trim($this->city_alias)])->one();
        if (!$this->city) {
            throw new \yii\console\Exception('City ' . $this->city_alias . ' not found', 1);
        }
        $url = $this->city->flamp;

        $client = new Client();

        $next_url = $url;
        while ($next_url) {
            echo '--->' . $next_url . "\n";
            $next_url = trim($next_url);
            $content = $this->getDataFromUrl($next_url, $client);
            if (!$content) {
                echo 'Get content from ' . $url . ' error :(' . "\n";
                continue;
            }
            $pQuery_nu = phpQuery::newDocumentHTML($content);
            $filials_data_nu = $pQuery_nu->find('section.page ul.list-cards > li.list-cards__item--card');
            $this->createFilials($filials_data_nu);

            $next_url = $pQuery_nu->find('section.page div.page__block div.pagination li.pagination__item:last a')->attr('href');
        }


    }


    /**
     * @param $filials_data
     */
    protected function createFilials($filials_data)
    {

        foreach ($filials_data as $f) {
            $filial_data = pq($f);
            $title = $filial_data->find('.card__info .card__title > .card__link')->text();
            $title = trim($title);
            $link = $filial_data->find('.card__info .card__title > .card__link')->attr('href');
            $link = $this->addHttpToUrl($link);

            echo "\n\n";
            echo $title . "\n";

            if (!strlen($title) > 0) continue;

            if (in_array($link, $this->filials)) {
                echo 'already saved... skipping' . "\n";
                continue;
            }

            if (in_array($title, $this->organizations)) {
                $orgid = array_search($title, $this->organizations);
                echo '>>>> ' . $orgid . "\n";
            } else {
                echo 'new org!' . "\n";
                $orgid = $this->createOrganization($title, $link);
                echo '.... ' . $orgid . "\n";
            }

            if (!$orgid > 0) {
                echo 'Org #' . $orgid . ' . ' . $title . ' not found =\ ' . "\n";
                continue;
            } else {
                echo 'Org #' . $orgid . ' . ' . $title . ' found =) ' . "\n";
            }

            $addr_data = trim($filial_data->find('.card__info .card__info-bottom .card__footer-item:eq(1)')->text());


            if (substr_count($addr_data, ' — ') > 0) {
                list($addr_data, $addr_extra) = explode(' — ', $addr_data);
            }


            $zpt_cnt = substr_count($addr_data, ',');
            $satellite_city = '';
            if ($zpt_cnt > 1) {
                $satellite_city = substr($addr_data, 0, strpos($addr_data, ','));
                $addr_data = str_replace($satellite_city . ',', '', $addr_data);
            }

            list($street, $bld) = explode(',', $addr_data);


            /** @var Filial $filial */
            $filial = new Filial();
            $filial->title = $title;

            $filial->flamp = $link;
            $filial->street = trim($satellite_city . ' ' . $street);
            $filial->bld = trim($bld);
            $filial->addr_extra = trim($addr_extra);

            $filial->city_id = $this->city->id;
            $filial->organization_id = $orgid;


            $filial->status = Filial::STATUS_ENABLED;

            if (!$filial->save()) {
                print_r($filial->getErrors());
                echo 'Cant save filial ' . $title . " \n";
                continue;
            }
            $filial_id = $filial->id;
            $this->filials[$filial_id] = $link;

            $this->setFilialExtraData($filial, $link);


        }

    }


    /**
     * @param Filial $filial
     * @param string $url
     * @return bool
     */
    protected function setFilialExtraData(Filial $filial, string $url)
    {
        $filial_data = $this->getDataFromUrl($url);
        if (!$filial_data) {
            return false;
        }
        $pQuery_filial = phpQuery::newDocumentHTML($filial_data);
        $site = $pQuery_filial->find('.filial-web__site a')->text();
        $phone = str_replace('tel:', '', $pQuery_filial->find('.filial-phones__phone a')->attr('href'));


        $body_data_check = count($pQuery_filial->find('.filial-info-row__content'));

        $body_data = $pQuery_filial->find('.filial-info-row__content:eq(0) li');
        $body = '';
        foreach ($body_data as $b) {
            $body .= ' ' . trim(pq($b)->text());
        }
        $format = null;
        if ($body_data_check > 2) {
            $format = trim($pQuery_filial->find('.filial-info-row__content:eq(1)')->text());
            $payments_elem_id = '2';
        } else {
            $payments_elem_id = '1';
        }


        $timetable_data = $pQuery_filial->find('.filial-workhours__timetable .filial-timetable .filial-timetable__days > div');
        $timetable = [];
        foreach ($timetable_data as $t) {
            list($time_start, $time_end) = explode('<br>', trim(pq($t)->find('.filial-timetable__day-period')->html()));
            $timetable[trim(pq($t)->find('.filial-timetable__day-name')->text())] = [
                'time_start' => $time_start,
                'time_end' => $time_end,
            ];
        }

        $payments_data = $pQuery_filial->find('.filial-info-row__content:eq(' . $payments_elem_id . ') ul li');
        $payments = [];
        foreach ($payments_data as $p) {
            $payments[] = trim(pq($p)->text());
        }

        $filial->site = trim($site);
        $filial->phone = trim($phone);
        $filial->body = trim($body);
        $filial->settings = json_encode([
            'format' => $format,
            'payments' => $payments,
            'timetable' => $timetable,
        ]);


        $fil_image=false;
        $img_url = $pQuery_filial->find('cat-brand-avatar')->attr('image');
        if ($img_url && !strpos($img_url,'default')) {
            $fil_image = FileHelper::uploadFromUrl($img_url);
        }

        if (!$fil_image) {
            $img_url = $pQuery_filial->find('.photos-block__slider > li > img')->attr('src');

            if ($img_url) {
                $fil_image = FileHelper::uploadFromUrl($img_url);
            }
        }


        if ($fil_image) {
           $filial->thumbnail=$fil_image;
        }

        $coords = YmapsHelper::getCoords($this->city->title . ', ' . $filial->street . ', ' . $filial->bld);
        if ($coords) {
            $filial->map_lat = $coords['lat'];
            $filial->map_lon = $coords['lon'];
            $filial->map_zoom = 15;
        }

        $filial->save();

        $reviewsData = $pQuery_filial->find('#reviews ul.list > li');
        foreach ($reviewsData as $r) {
            $this->createReview($filial->id, $r);
        }

    }

    /**
     * @param int $filial_id
     * @param $data
     */
    protected function createReview(int $filial_id, $data)
    {
        $review_data = pq($data);

        $review = new Review();

        $review->filial_id = $filial_id;
        $review->user_name = trim($review_data->find('.ugc-item__author .author__content a.name')->text());

        $body = trim($review_data->find('.l-inner .ugc-item__text--full')->html());
        $body = strip_tags($body);
        $review->title = substr($body, 0, 64);
        $review->body = trim($body);
        $review->rating = (int)$review_data->find('meta[itemprop="ratingValue"]')->attr('content');

        $review->save();
    }

    /**
     * @param $title
     * @param $url
     * @return bool|mixed
     */
    protected function createOrganization(string $title, string $url)
    {
        $org_data = $this->getDataFromUrl($url);
        if (!$org_data) {
            return false;
        }

        $pQuery_org = phpQuery::newDocumentHTML($org_data);

        $site = $pQuery_org->find('.filial-web__site a')->text();
        $phone = str_replace('tel:', '', $pQuery_org->find('.filial-phones__phone a')->attr('href'));
        $body = $pQuery_org->find('.filial-info-row__content')->text();

        /** @var Organization $org */
        $org = new Organization();
        $org->title = $title;
        $org->phone = trim($phone);

        $org->site = trim($site);
        $org->body = trim($body);
        $org->status = Organization::STATUS_ENABLED;

        $img_url = $pQuery_org->find('cat-brand-avatar')->attr('image');
        $org->thumbnail = FileHelper::uploadFromUrl($img_url);


        if ($org->save()) {
            $org_id = $org->id;
            $this->organizations[$org_id] = $title;
            echo $org_id;
            \Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'organization',
                'event' => 'create',
                'data' => [
                    'title' => $title,
                    'organization_id' => $org_id,
                    'created_at' => $org->created_at
                ]
            ]));

            return $org_id;
        }

        return false;
    }


    /**
     * @param $url
     * @return string
     */
    protected function addHttpToUrl($url)
    {
        $url = trim($url);
        $url = ltrim($url, '\s//');

        if (strpos($url, 'http') !== 0) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    /**
     * @param $url
     * @param null $client
     * @return mixed
     */
    protected function getDataFromUrl(string $url, &$client = null)
    {

        $url = $this->addHttpToUrl($url);

        return CacheHelper::doit('httpg_' . $url,
            function () use ($url, $client) {

                try {
                    if (!$client) {
                        $client = new Client();
                    }

                    $headers = $this->getHeaders();

                    $response = $client->createRequest()
                        ->setMethod('get')
                        ->setHeaders($headers)
                        ->setUrl($url)
                        ->send();

                } catch (Exception $e) {
                    //print_r($e);
                    return false;
                }

                if (!$response->isOk) {
                    return false;
                }

                $content = $response->getContent();

                return $content;
            },
            null, 3600);
    }


    /**
     * @return array
     */
    protected function getHeaders()
    {
        $headers = [
            'User - Agent: Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.9.2.12) Gecko / 20101026 Firefox / 3.6.12',
            'Accept: text / html,application / xhtml + xml,application / xml;q = 0.9,*/*;q=0.8',
            'Accept-Language: en-us,en;q=0.5',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
//            'Keep-Alive: 115',
//            'Connection: keep-alive',
        ];

        return $headers;
    }


}