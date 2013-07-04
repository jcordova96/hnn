<?php
/* @var $this SeoUrlAliasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seo Url Aliases',
);

$this->menu=array(
	array('label'=>'Create SeoUrlAlias', 'url'=>array('create')),
	array('label'=>'Manage SeoUrlAlias', 'url'=>array('admin')),
);
?>

<h1>Seo Url Aliases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
