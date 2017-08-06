<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Organizations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Organization',
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
            // 'inn',
            // 'kpp',
            // 'ogrn',
            // 'email:email',
            // 'site',
            // 'phone',
            // 'bank_props:ntext',
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
