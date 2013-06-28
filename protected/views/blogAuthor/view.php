<?php
/* @var $this BlogAuthorController */
/* @var $model BlogAuthor */

$this->breadcrumbs=array(
	'Blog Authors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BlogAuthor', 'url'=>array('index')),
	array('label'=>'Create BlogAuthor', 'url'=>array('create')),
	array('label'=>'Update BlogAuthor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BlogAuthor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BlogAuthor', 'url'=>array('admin')),
);
?>

<h1>View BlogAuthor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'uid',
		'author',
		'description',
	),
)); ?>
