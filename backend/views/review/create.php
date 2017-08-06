<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Review */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Review',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
