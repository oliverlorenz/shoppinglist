<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'meal-ingredient-addNewIngredient-form',
			'enableAjaxValidation'=>false,
		)); ?>
<label>Zutat Singlar</label>
<?php echo $form->textField($newIngredient,'name'); ?>
<label>Zutat Plural</label>
<?php echo $form->textField($newIngredient,'namePlural'); ?>
<label>Einheit</label>
<?php echo $form->textField($newIngredient,'unit'); ?>
<?php echo CHtml::submitButton('anlegen'); ?>
<?php $this->endWidget(); ?>