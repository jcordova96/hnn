<?php
/* @var $this SeoUrlAliasController */
/* @var $model SeoUrlAlias */

$this->breadcrumbs=array(
	'Seo Url Aliases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeoUrlAlias', 'url'=>array('index')),
	array('label'=>'Manage SeoUrlAlias', 'url'=>array('admin')),
);
?>

<h1>Create SeoUrlAlias</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>