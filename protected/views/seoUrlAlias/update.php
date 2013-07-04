<?php
/* @var $this SeoUrlAliasController */
/* @var $model SeoUrlAlias */

$this->breadcrumbs=array(
	'Seo Url Aliases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeoUrlAlias', 'url'=>array('index')),
	array('label'=>'Create SeoUrlAlias', 'url'=>array('create')),
	array('label'=>'View SeoUrlAlias', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SeoUrlAlias', 'url'=>array('admin')),
);
?>

<h1>Update SeoUrlAlias <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>