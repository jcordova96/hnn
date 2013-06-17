<?php
/* @var $this CategoryGroupController */
/* @var $model CategoryGroup */

$this->breadcrumbs=array(
	'Category Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryGroup', 'url'=>array('index')),
	array('label'=>'Manage CategoryGroup', 'url'=>array('admin')),
);
?>

<h1>Create CategoryGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>