<?php include('protected/views/content_header.php');  ?>
<div class="row">
	<table class="table table-condensed">
<?php 
$counter = 0;
foreach($model as $id => $dataset) { 
	$counter++;
?>

<tr>
	<td class="column1">
		<span class="hidden-print"><?php echo $counter; ?></span>
		<span class="visible-print"><?php echo $this->_getQrImage($dataset['id']); ?></span>
	</td>
	<td class="column2">
		<div class="name">
			<?php echo $dataset['name']; ?>
		</div>
		<div class="hidden-print">
			<a class="btn btn-primary glyphicon glyphicon-edit" href="<?php echo $this->_getEditLink($dataset['id']); ?>"></a>
			<a class="btn btn-primary glyphicon glyphicon-remove" href="<?php echo $this->_getDeleteLink($dataset['id']); ?>"></a>
			<a class="btn btn-primary glyphicon glyphicon-plus"href="<?php echo $this->_getAddToListLink($dataset['id']); ?>">
			</a>
		</div>
	</td>
</tr>
<?php } ?>
</table>
<div class="bottomnav hidden-print">
	<a href="<?php echo $this->_getLinkBase(); ?>">
		<?php echo $language['back']; ?>
	</a>
</div>

