<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

if ($this->action->id == 'update')
{
    $auth = Yii::app()->authManager;
    $aRole = $auth->getRoles();
    $aUserRoleInfo = $auth->getAuthAssignMents($model->mail);
    $aUserRole = array();

    foreach ($aUserRoleInfo as $sUserRole => $oCAuthItem)
        $aUserRole[] = $sUserRole;
}
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($this->action->id == 'create'): ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'pass'); ?>
            <?php echo $form->passwordField($model, 'pass', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo $form->error($model, 'pass'); ?>
        </div>

    <?php elseif ($this->action->id == 'update'): ?>

        <div class="row">
            <?php echo CHtml::label('New Password', 'newPassword'); ?>
            <?php echo CHtml::textField('User[newPassword]', '', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo $form->error($model, 'pass'); ?>
        </div>

    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'mail'); ?>
        <?php echo $form->textField($model, 'mail', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'mail'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'middle_name'); ?>
        <?php echo $form->textField($model, 'middle_name', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'middle_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>

    <?php if ($this->action->id == 'create'): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'created'); ?>
            <?php if ($model->isNewRecord): ?>
                <?php echo $form->textField($model, 'created', array('value' => strtotime('now'))); ?>
            <?php else: ?>
                <?php echo $form->textField($model, 'created'); ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'created'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $form->textField($model, 'login'); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->textField($model, 'status'); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

    <?php elseif ($this->action->id == 'update'): ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'created'); ?>
            <?php echo $model->created; ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $model->login; ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $model->status; ?>
        </div>

        <?php if (!empty($aRole)): ?>

            <div class="row">
                <h2>User Role Assignment </h2>

                <?php foreach ($aRole as $sRoleName => $oCAuthItem): ?>

                    <?php echo CHtml::label($sRoleName, 'roles[' . $sRoleName . ']'); ?>
                    <?php echo CHtml::checkBox('roles[' . $sRoleName . ']', (in_array($sRoleName, $aUserRole))); /* See if current role in user role array to see if should be checked */ ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->