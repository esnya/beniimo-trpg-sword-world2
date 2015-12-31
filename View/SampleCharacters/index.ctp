<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Race'); ?></th>
				<th><?php echo __('Adventurer Level'); ?></th>
				<th><?php echo __('Nationality'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sample_characters as $sample_character): ?>
			<tr>
				<td><?php echo $this->Html->link(__('View'), ['action' => 'view', $sample_character['SampleCharacter']['id']], ['class' => 'btn btn-xs btn-primary']); ?></td>
				<td><?php echo h($sample_character['SampleCharacter']['name']); ?></td>
				<td><?php echo h($sample_character['Race']['name']); ?></td>
				<td><?php echo h($sample_character['SampleCharacter']['adventurer_level']); ?></td>
				<td><?php echo h($sample_character['SampleCharacter']['nationality']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $this->Html->link(__('Add New Sample Character'), ['action' => 'add'], ['class' => 'btn btn-primary']); ?>
</div>
