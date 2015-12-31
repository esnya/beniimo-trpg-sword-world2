<style>
	body { padding-top: 50px; }
	.name { white-space: no-wrap; overflow: hidden; }
</style>
	
<div class="jumbotron">
	<div class="container">
		<h1><?php echo $title_for_layout; ?></h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<?php foreach ($sample_characters as $character): ?>
		<div class="col-md-4">
			<h1 class="name">
				<?php echo $character['SampleCharacter']['name']; ?>
				<?php echo $this->Html->link(__('Import'), [$character['SampleCharacter']['id']], ['class' => 'btn btn-sm btn-primary pull-right', 'role' => 'button']); ?>
			</h1>
			<span>
				<?php echo __('Adventurer Level'); ?>
				<?php echo $character['SampleCharacter']['adventurer_level']; ?>
			</span>
			/
			<span><?php echo $character['Race']['name']; ?></span>
			/
			<span><?php echo $character['SampleCharacter']['nationality']; ?></span>
		</div>
		<?php endforeach; ?>
	</div>
</div>
