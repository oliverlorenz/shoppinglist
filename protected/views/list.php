<?php include('content_header.php') ?>
<table class="table table-condensed">

<?php 
$counter = 0;
foreach($model as $id => $dataset) { 
	$counter++;
?>
	<tr>
		<td>
			<?php echo $counter; ?>
		</td>
		<td>
			<div>
				<?php echo $dataset['name']; ?>
			</div>
			<div>
				<a class="btn btn-primary glyphicon glyphicon-edit" href="<?php echo $this->_getEditLink($dataset['id']); ?>"></a>
				<a class="btn btn-primary glyphicon glyphicon-remove" href="<?php echo $this->_getDeleteLink($dataset['id']); ?>"></a>
			</div>
		</td>
	</tr>
<?php } ?>
</table>
<a href="<?php echo $this->_getLinkBase(); ?>">
	<?php echo $language['back']; ?>
</a>

