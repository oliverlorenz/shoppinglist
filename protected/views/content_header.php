<h1><?php echo $language['headline']; ?>&nbsp;
<?php
if(preg_match('/list/', $this->action->id)) { ?>
<a class="label label-default hidden-print glyphicon glyphicon-plus" href="<?php echo $this->_getAddLink(); ?>"> </a>
<?php } ?>
</h1>

