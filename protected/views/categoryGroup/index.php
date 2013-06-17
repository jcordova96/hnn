<?php
/* @var $this CategoryGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Category Groups',
);

$this->menu=array(
	array('label'=>'Create CategoryGroup', 'url'=>array('create')),
	array('label'=>'Manage CategoryGroup', 'url'=>array('admin')),
);
?>

<h1>Category Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
