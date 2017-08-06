<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'City',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uuid',
            'title',
            'alias',
            'body:ntext',
            // 'image',
            // 'map_lat',
            // 'map_lon',
            // 'map_zoom',
            // 'timezone',
            // 'settings:ntext',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'lock',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
