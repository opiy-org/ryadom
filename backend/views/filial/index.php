<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Filials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filial-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Filial',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uuid',
            'organization_id',
            'city_id',
            'title',
            // 'alias',
            // 'body:ntext',
            // 'image',
            // 'map_lat',
            // 'map_lon',
            // 'map_zoom',
            // 'email:email',
            // 'site',
            // 'flamp',
            // 'phone',
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
