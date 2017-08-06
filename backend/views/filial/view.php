<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\base\Filial */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Filials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filial-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uuid',
            'organization_id',
            'city_id',
            'title',
            'alias',
            'body:ntext',
            'image',
            'map_lat',
            'map_lon',
            'map_zoom',
            'email:email',
            'site',
            'flamp',
            'phone',
            'settings:ntext',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'status',
            'lock',
        ],
    ]) ?>

</div>
