<?php
/* @var $this BlogAuthorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blog Authors',
);

$this->menu=array(
	array('label'=>'Create BlogAuthor', 'url'=>array('create')),
	array('label'=>'Manage BlogAuthor', 'url'=>array('admin')),
);
?>

<h1>Blog Authors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
