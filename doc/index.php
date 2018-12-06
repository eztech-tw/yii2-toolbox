<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $Content string */
/* @var $Path string */

$this->title = $Path;
$this->params['breadcrumbs'][] = 'docs';
foreach (explode('/',$Path) as $P){
    $this->params['breadcrumbs'][] = $P;
}
?>
<div class="doc-index">
    <?= $Content ?>
</div>
