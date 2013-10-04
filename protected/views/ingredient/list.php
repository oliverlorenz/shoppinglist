<h1>Zutaten</h1>

<?php 
$counter = 0;
foreach($data as $id => $dataset) { 
	$counter++;
?>
<div>
	<div><?php echo $counter; ?></div>
	<div><?php echo $dataset['namePlural']; ?></div>
	<div><a class="btn btn-primary glyphicon glyphicon-edit" href="/ingredient/edit/<?php echo $id; ?>"></a></div>
	<div><a class="btn btn-primary glyphicon glyphicon-remove" href="/ingredient/delete/<?php echo $id; ?>">löschen</a></div>
</div>
<?php } ?>
<div>
	<div><a href="/ingredient/add">Neue Zutat</a></div>
</div>
