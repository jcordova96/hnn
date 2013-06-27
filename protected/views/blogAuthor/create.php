<?php
/* @var $this BlogAuthorController */
/* @var $model BlogAuthor */

$this->breadcrumbs=array(
	'Blog Authors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BlogAuthor', 'url'=>array('index')),
	array('label'=>'Manage BlogAuthor', 'url'=>array('admin')),
);
?>

<h1>Create BlogAuthor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>