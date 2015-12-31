<div class="container">
<table class="table table-bordered">
	<tbody>
<?php
	foreach ($maps as $map):
?>
<tr>
	<td><?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $map['MistCastleBlockMap']['id']], ['class' => 'btn btn-primary', 'escape' => false]);?></td>
	<td><?php echo h($map['MistCastleBlockMap']['name']); ?></td>
	<td><?php echo h($map['User']['name']); ?></td>
</tr>
<?
endforeach;
?>
	</tbody>
</table>

<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]); ?>
</div>
