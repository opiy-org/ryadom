<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Good */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Good',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Goods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
