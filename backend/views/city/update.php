<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\City */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'City',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="city-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
