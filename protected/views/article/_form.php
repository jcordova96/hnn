<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>


<style>

    #article-form select {
        width: 200px;
    }

</style>

<div class='form'>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class='note'>Fields with <span class='required'>*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class='row'>
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id', $categories, array('size' => 3)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'source_url'); ?>
		<?php echo $form->textField($model,'source_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'source_url'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'source_date'); ?>
		<?php echo $form->textField($model,'source_date',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'source_date'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'source_bio'); ?>
		<?php echo $form->textArea($model,'source_bio',array('rows'=>15, 'cols'=>125, 'class'=>'wysiwig')); ?>
		<?php echo $form->error($model,'source_bio'); ?>
	</div>

    <div class='row'>
        <?php echo $form->labelEx($model,'body'); ?>
        <?php echo $form->textArea($model,'body',array('rows'=>30, 'cols'=>125, 'class'=>'wysiwig')); ?>
        <?php echo $form->error($model,'body'); ?>
    </div>
    <br />

    <div class='row'>
        <?php echo $form->labelEx($model,'teaser'); ?>
        <?php echo $form->textArea($model,'teaser',array('rows'=>20, 'cols'=>125, 'class'=>'wysiwig')); ?>
        <?php echo $form->error($model,'teaser'); ?>
    </div>

    <div class='row'>
        <?php echo $form->labelEx($model,'uid'); ?>
        <?php if($model->isNewRecord): ?>
            <?php echo $form->textField($model,'uid', array('value' => $user->id, 'disabled' => true)); ?>
        <?php else: ?>
            <?php echo $form->textField($model,'uid', array('disabled' => true)); ?>
        <?php endif; ?>
        <?php echo $form->error($model,'uid'); ?>
    </div>

    <div class='row'>
        <label for='Article_images'>Images</label>

        <div class='image-inputs'>
            <input name='Article[file][]' type='file' /><br />
        </div>
        <button type="button" class='more-uploads-button'>More uploads +</button>
        <button type="button" class='more-remote-images-button'>More remote images +</button>

        <?php if(!$model->isNewRecord): ?>
            <div id='Article_images'>
                <?php $images = File::getImages($model->id, 'article'); ?>
                <?php if(!empty($images)): ?>
                    <?php foreach($images as $i => $filepath): ?>
                        <span>Filepath: /<?php echo $filepath; ?></span>
                        <span>
                            - <b>Delete Image</b>
                            <input type='checkbox' name='delete_files[]'  value='<?php echo $filepath; ?>' />
                        </span>
                        <br />
                        <img src='/<?php echo $filepath; ?>' />
                        <br /><br />
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class='row'>
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->textField($model,'status'); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class='row'>
        <?php echo $form->labelEx($model,'created'); ?>
        <?php if($model->isNewRecord): ?>
            <?php echo $form->textField($model,'created', array('value' => strtotime('now'))); ?>
        <?php else: ?>
            <?php echo $form->textField($model,'created'); ?>
        <?php endif; ?>
        <?php echo $form->error($model,'created'); ?>
    </div>

	<div class='row buttons'>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->
