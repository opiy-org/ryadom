<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\City */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'City',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
