<?php
/* @var $this CategoryGroupController */
/* @var $model CategoryGroup */

$this->breadcrumbs=array(
	'Category Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CategoryGroup', 'url'=>array('index')),
	array('label'=>'Create CategoryGroup', 'url'=>array('create')),
	array('label'=>'View CategoryGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CategoryGroup', 'url'=>array('admin')),
);
?>

<h1>Update CategoryGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>