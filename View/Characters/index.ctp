<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('User'); ?></th>
				<th><?php echo __('Race'); ?></th>
				<th><?php echo __('Nationality'); ?></th>
				<th><?php echo __('Adventurer Level'); ?></th>
				<th><?php echo __('Last Modify'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($characters as $character): ?>
			<tr>
				<td>
					<div class="btn-group">
						<?php 
							echo $this->Html->link(
								__('View'),
								array('action' => 'view', $character['Character']['id']),
								array('class' => 'btn btn-primary btn-xs', 'role' => 'button')
							); 
							echo $this->Html->link(
								__('Old Version'),
								array('action' => 'view_old', $character['Character']['id']),
								array('class' => 'btn btn-warning btn-xs', 'role' => 'button')
							); 
						?>
					</div>
				</td>
				<td><?php echo h($character['Character']['name']); ?></td>
				<td><?php echo h($character['User']['name']); ?></td>
				<td><?php echo h($character['Race']['name']); ?></td>
				<td><?php echo h($character['Character']['nationality']); ?></td>
				<td><?php echo h($character['Character']['adventurer_level']); ?></td>
				<td><?php echo h($character['Character']['modified']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
		echo $this->Form->postLink(
			__('Create New Character'),
			array('action' => 'add'),
			array('class' => 'btn btn-primary', 'role' => 'button'),
			__('Are you sure to create new character?')
		);
	?>
	<?php
		echo $this->Html->link(
			__('Import Sample Character'),
			array('action' => 'sample'),
			array('class' => 'btn btn-info', 'role' => 'button')
		);
	?>

</div>
