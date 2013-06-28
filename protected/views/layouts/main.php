<?php /* @var $this Controller */ ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="Stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jHtmlArea.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>


	<style type="text/css">
			/* body { background: #ccc;} */
		div.jHtmlArea .ToolBar ul li a.custom_disk_button
		{
			background: url(images/disk.png) no-repeat;
			background-position: 0 0;
		}

		div.jHtmlArea { border: solid 1px #ccc; }
	</style>

</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Articles', 'url'=>array('/article/admin')),
				array('label'=>'Blogs', 'url'=>array('/blog/admin')),
				array('label'=>'Blog Authors', 'url'=>array('/blogAuthor/admin')),
				array('label'=>'Categories', 'url'=>array('/category/admin')),
				array('label'=>'Category Groups', 'url'=>array('/categoryGroup/admin')),
				array('label'=>'Files', 'url'=>array('/file/admin')),
				array('label'=>'Users', 'url'=>array('/user/admin')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">

        <?php Yii::app()->clientScript->registerScriptFile('/js/jHtmlArea-0.7.5.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile('/js/admin.js'); ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                $("textarea.wysiwig").htmlarea();
            });
        </script>
		Copyright &copy; <?php echo date('Y'); ?> by HNN.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>

	</div><!-- footer -->

</div><!-- page -->

</body>
</html>


