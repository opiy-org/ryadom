<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Filial;

/**
 * FilialSearch represents the model behind the search form about `common\models\base\Filial`.
 */
class FilialSearch extends Filial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'organization_id', 'city_id', 'map_zoom', 'created_by', 'updated_by', 'status', 'lock'], 'integer'],
            [['uuid', 'title', 'alias', 'body', 'image', 'map_lat', 'map_lon', 'email', 'site', 'flamp', 'phone', 'settings', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Filial::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'city_id' => $this->city_id,
            'map_zoom' => $this->map_zoom,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'lock' => $this->lock,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'map_lat', $this->map_lat])
            ->andFilterWhere(['like', 'map_lon', $this->map_lon])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'flamp', $this->flamp])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'settings', $this->settings]);

        return $dataProvider;
    }
}
