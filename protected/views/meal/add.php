<?php
/* @var $this MealController */
/* @var $model Meal */
/* @var $form CActiveForm */
?>

<div class="row">
	<div class="col-md-11">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'meal-add-form',
			'enableAjaxValidation'=>false,
		)); 
		?>
		<div class="form-group">
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textField($model,'description'); ?>
			<?php echo $form->error($model,'description'); ?>
			<?php echo CHtml::submitButton('Gericht speichern'); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div>	
</div>