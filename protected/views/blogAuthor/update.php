<?php
/* @var $this BlogAuthorController */
/* @var $model BlogAuthor */

$this->breadcrumbs=array(
	'Blog Authors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BlogAuthor', 'url'=>array('index')),
	array('label'=>'Create BlogAuthor', 'url'=>array('create')),
	array('label'=>'View BlogAuthor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BlogAuthor', 'url'=>array('admin')),
);
?>

<h1>Update BlogAuthor <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>