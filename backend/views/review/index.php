<?php

use common\models\base\Review;
use kartik\editable\Editable;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;


$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);


$gridColumn = [
    //    ['class' => 'yii\grid\SerialColumn'],
    // 'image',
    ['attribute' => 'id', 'visible' => false],
    [
        'class' => '\kartik\grid\CheckboxColumn'
    ],
    [
        'attribute' => 'image',
        'format' => 'raw',
        'value' => function ($data) {
            return Html::img($data->imgLnk, ['width' => '66px']);
        },
        'headerOptions' => [
            'style' => 'width:70px'
        ],

    ],
    'title',

    [
        'attribute' => 'filial_id',
        'label' => Yii::t('backend', 'Filial'),
        'value' => function ($model) {
            return $model->filial->title;
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \yii\helpers\ArrayHelper::map(\common\models\base\Filial::find()->asArray()->all(), 'id', 'title'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => Yii::t('backend', 'Filial'), 'id' => 'grid-room-search-filial_id']
    ],
    'rating',

    ['attribute' => 'lock', 'visible' => false],

    ['class' => 'yii\grid\ActionColumn'],
];
?>
<div class="review-index">

    <div class="search-form" style="display:none">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-review']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => false,
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('backend', 'Create'), ['create'],
                    ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => Yii::t('backend', 'Create')]) . ' ' .
                Html::a(Yii::t('backend', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']),
        ],

        'panelFooterTemplate' => '<div class="row"><div class="col-md-8">{pager}</div><div class="col-md-4 tsummary">{summary}</div></div> <div class="tuplink"><i class="fa fa-arrow-up"></i> </div>{footer}<div class="clearfix"></div>',
        'toolbar' => [
            //'{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => Yii::t('backend', 'Full'),
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">' . Yii::t('backend', 'Export All Data') . '</li>',
                    ],
                ],
            ]),
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('backend', 'Reset Grid')])
        ],

    ]); ?>

</div>
