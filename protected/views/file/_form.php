<?php
/* @var $this FileController */
/* @var $model File */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nid'); ?>
		<?php echo $form->textField($model,'nid',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'nid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filepath'); ?>
		<?php echo $form->textField($model,'filepath',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'filepath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filemime'); ?>
		<?php echo $form->textField($model,'filemime',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'filemime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filesize'); ?>
		<?php echo $form->textField($model,'filesize',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'filesize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->