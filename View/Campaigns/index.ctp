<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Game Master'); ?></th>
				<th><?php echo __('Last Modify'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $item): ?>
			<tr>
				<td>
					<?php 
						echo $this->Html->link(
							__('View'),
							array('action' => 'view', $item['Campaign']['id']),
							array('class' => 'btn btn-primary btn-xs', 'role' => 'button')
						); 
					?>
				</td>
				<td><?php echo h($item['Campaign']['name']); ?></td>
				<td><?php echo h($item['GameMaster']['name']); ?></td>
				<td><?php echo h($item['Campaign']['modified']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
		echo $this->Form->postLink(
			__('Create New Campaign'),
			array('action' => 'add'),
			array('class' => 'btn btn-primary', 'role' => 'button'),
			__('Are you sure to create new campaign?')
		);
	?>
</div>
