<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Goods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Good',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uuid',
            'filial_id',
            'title',
            'body:ntext',
            // 'image',
            // 'qnt',
            // 'price',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'lock',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
