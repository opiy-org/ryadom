<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Organization */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Organization',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Organizations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
