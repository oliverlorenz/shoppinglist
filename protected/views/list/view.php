<h1>Einkaufsliste</h1>
<?php 
	$meals = array();
	$mealLinks = '';
	foreach ($list as $ingredient) { 
		if(!in_array($ingredient['mealName'], $meals)) {
			$meals[] = $ingredient['mealName'];
			$mealLinks[] = '<a class="glyphicon glyphicon-remove" href="' . $this->_getRemoveMealLink($listId, $ingredient['mealId']) . '">' . $ingredient['mealName'] . '</a>';
		}
	}
?>
<h5>für die Gerichte: <?php echo implode(', ', $mealLinks); ?></h5>
<table class="table table-condensed">
	<?php 
	$counter = 0;
	foreach ($list as $ingredient) { 
		$counter++;
		?>
	<tr>
		<td>
			<?php echo $counter; ?>
		</td>
		<td>
			<?php echo $ingredient['amount']; ?> <?php echo $ingredient['unit']; ?>
		</td>
		<td>
			<?php echo $ingredient['name']; ?>
		</td>
	</tr>
<?php } ?>
</table>
<a href="<?php echo $this->_getLinkBase(); ?>">
	<?php echo $language['back']; ?>
</a>
