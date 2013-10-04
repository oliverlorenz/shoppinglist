<?php
/* @var $this MealIngredientController */
/* @var $model MealIngredient */
/* @var $form CActiveForm */
?>
<h2>Zutaten</h2>
<div class="row">
	<div class="col-md-12">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'meal-ingredient-addIngredient-form',
			'enableAjaxValidation'=>false,
		)); ?>
		<table class="table table-condensed">
		
			<?php 
			$counter = 0;
			foreach($ingredients as $dataset) { 
				$counter++;
				$data = $ingredientData[$dataset['ingredientId']];

			?>
			<tr>
				<td><?php echo $counter; ?></td>
				<td><?php echo htmlentities($data['name']); ?></td>
				<td><?php echo $dataset['amount']; ?> <?php echo htmlentities($data['unit']); ?></td>
				<td>
					<a href="<?php echo $this->_getIngredientDeleteLink($dataset['mealId'], $dataset['ingredientId']); ?>">
						<?php echo $language['delete']; ?>
					</a>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td></td>
				<td>
					<?php echo $form->dropDownList($modelIngredient,'ingredientId', $ingredientsAll); ?>
				</td>
				<td>
					<?php echo $form->textField($modelIngredient,'amount'); ?>
				</td>
				<td>
					<?php echo CHtml::submitButton($language['add']); ?>
					<?php echo $form->hiddenField($modelIngredient,'mealId', array('value' => $model->id)); ?>
				</td>
			</tr>
		</table>
		<?php $this->endWidget(); ?>
		<?php echo $form->errorSummary($modelIngredient); ?>
	</div>
</div>