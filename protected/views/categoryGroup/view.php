<?php
/* @var $this CategoryGroupController */
/* @var $model CategoryGroup */

$this->breadcrumbs=array(
	'Category Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CategoryGroup', 'url'=>array('index')),
	array('label'=>'Create CategoryGroup', 'url'=>array('create')),
	array('label'=>'Update CategoryGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CategoryGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryGroup', 'url'=>array('admin')),
);
?>

<h1>View CategoryGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
