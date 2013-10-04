<?php
/* @var $this MealController */
/* @var $model Meal */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'meal-add-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
)); 
?>

<div class="form-group row">
	<div class="col-md-12">
		<?php echo $form->errorSummary($model); ?>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-12">
		<?php echo $form->labelEx($model,'name'); ?>
	</div>
	<div class="col-md-12">
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-12">
		<?php echo $form->labelEx($model,'description'); ?>
	</div>
	<div class="col-md-12">
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
</div>
<div class="row buttons">
	<div class="col-md-12">
		<?php echo CHtml::submitButton($language['save']); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

<?php include('addIngredient.php') ?>
<?php include('addNewIngredient.php') ?>
