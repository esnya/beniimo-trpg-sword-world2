<style>
	body {
			padding-top: 50px;
	}
</style>
<?php echo $this->InlineForm->create($data, 'Campaign', ['readonly' => !$is_owned]); ?>
<div class="jumbotron">
	<div class="container">
		<h1>
			<?php echo $this->InlineForm->control('name'); ?>
		</h1>

		<?php echo $this->InlineForm->control('description', ['multiline' => true]); ?>

		<dl>
			<dt><?php echo __('Experience Points'); ?></dt>
			<dd><?php echo $this->InlineForm->control('experience_points', ['readonly' => true]); ?></dd>
			<dt><?php echo __('Growth Count'); ?></dt>
			<dd><?php echo $this->InlineForm->control('growth_count', ['readonly' => true]); ?></dd>
			<dt><?php echo __('Honors'); ?></dt>
			<dd><?php echo $this->InlineForm->control('honors', ['readonly' => true]); ?></dd>
		</dl>
	</div> <!--container-->
</div> <!--jumbotron-->

<div class="container">
	<div class="table-responsive">
		<?php
			echo $this->InlineForm->createTable('SwordWorldSession', [
			'name',
			'description' => ['multiline' => true],
			'base_experience_points' => ['type' => 'number'],
			'additional_experience_points' => ['type' => 'number'],
			'growth_count' => ['type' => 'number'],
			'honors' => ['type' => 'number'],
			'start_date' => ['type' => 'date'],
			'end_date' => ['type' => 'date'],
			], ['class' => 'table']);
		?>
		<thead><?php echo $this->InlineForm->thead(); ?></thead>
		<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
		<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
		<?php echo $this->InlineForm->endTable(); ?>
	</div>
	<div class="table-responsive">
		<table class="tabe">
			<thead></thead>
			<tbody></tbody>
		</table>
	</div>
</div> <!--contaoner-->
<?php echo $this->InlineForm->end(); ?>
