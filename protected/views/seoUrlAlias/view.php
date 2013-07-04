<?php
/* @var $this SeoUrlAliasController */
/* @var $model SeoUrlAlias */

$this->breadcrumbs=array(
	'Seo Url Aliases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SeoUrlAlias', 'url'=>array('index')),
	array('label'=>'Create SeoUrlAlias', 'url'=>array('create')),
	array('label'=>'Update SeoUrlAlias', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SeoUrlAlias', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SeoUrlAlias', 'url'=>array('admin')),
);
?>

<h1>View SeoUrlAlias #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'alias',
		'path',
	),
)); ?>
