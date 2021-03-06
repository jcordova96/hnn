<?php
/* @var $this BlogController */
/* @var $model Blog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'uid'); ?>
        <?php if($model->isNewRecord): ?>
            <?php echo $form->textField($model,'uid', array('value' => $user->id, 'disabled' => true)); ?>
        <?php else: ?>
            <?php echo $form->textField($model,'uid', array('disabled' => true)); ?>
        <?php endif; ?>
        <?php echo $form->error($model,'uid'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
        <?php echo $form->dropDownList($model,'author_id', $blog_authors, array('size' => 3)); ?>
		<?php echo $form->error($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'body'); ?>
        <?php echo $form->textArea($model,'body',array('rows'=>30, 'cols'=>125, 'class'=>'wysiwig')); ?>
        <?php echo $form->error($model,'body'); ?>
    </div>
    <br />

    <div class="row">
        <?php echo $form->labelEx($model,'teaser'); ?>
        <?php echo $form->textArea($model,'teaser',array('rows'=>20, 'cols'=>125, 'class'=>'wysiwig')); ?>
        <?php echo $form->error($model,'teaser'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'created'); ?>
        <?php if($model->isNewRecord): ?>
            <?php echo $form->textField($model,'created', array('value' => strtotime('now'))); ?>
        <?php else: ?>
            <?php echo $form->textField($model,'created'); ?>
        <?php endif; ?>
        <?php echo $form->error($model,'created'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->