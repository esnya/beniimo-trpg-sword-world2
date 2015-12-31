<style>
	.col-xs-2 {
			padding: 0;
	}
	.panel {
			margin-bottom: 0;
	}
	.panel-body {
			white-space: nowrap;
			overflow: hidden;
	}
</style>
<?php
	echo $this->InlineForm2->create($map, 'MistCastleBlockMap', ['class' =>  $is_owned ? '' : 'readonly',], ['readonly' => !$is_owned]);
?>
<!-- .jumbotron -->
<div class="jumbotron">
	<!-- .container -->
	<div class="container">
		<h1>
			<?php echo $this->InlineForm2->control('name'); ?>
		</h1>
	</div>
	<!-- /.container -->
</div>
<!-- /.jumbotron -->
<!-- .container -->
<div class="container">
	<?php for ($y = 1; $y <= 7; ++$y): ?>
	<!-- .row -->
	<div class="row">
		<?php foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $x): ?>
		<!-- .col-xs-6 -->
		<div class="col-xs-2">
			<?php if ($x == 'a' && $y == 4): ?>
			<!-- .panel panel-default -->
			<div class="panel panel-info">
				<!-- .panel-heading -->
				<div class="panel-heading text-center">
					<?php echo __('Fixed 1'); ?>
				</div>
				<!-- /.panel-heading -->
				<!-- .panel-body -->
				<div class="panel-body text-center">
					<?php echo __('Port'); ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel panel-default -->
			<?php elseif ($x == 'a' && $y == 5): ?>
			<?php echo __('Shess Lake'); ?>
			<?php elseif ($x == 'a' && $y >= 6): ?>
			&nbsp;
			<?php elseif ($x == 'd' && $y == 4): ?>
			<!-- .panel panel-default -->
			<div class="panel panel-info">
				<!-- .panel-heading -->
				<div class="panel-heading text-center">
					<?php echo __('Fixed 2'); ?>
				</div>
				<!-- /.panel-heading -->
				<!-- .panel-body -->
				<div class="panel-body text-center">
					<?php echo __('Tower of Feicui'); ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel panel-default -->
			<?php elseif ($x == 'f' && $y == 4): ?>
			<!-- .panel panel-default -->
			<div class="panel panel-info">
				<!-- .panel-heading -->
				<div class="panel-heading text-center">
					<?php echo __('Fixed 3'); ?>
				</div>
				<!-- /.panel-heading -->
				<!-- .panel-body -->
				<div class="panel-body text-center">
					<?php echo __('Gate fo Cry'); ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel panel-default -->
			<?php else: ?>
			<!-- .panel panel-default -->
			<div class="panel panel-default">
				<!-- .panel-heading -->
				<div class="panel-heading">
					<!-- .row -->
					<div class="row">
					<!-- .col-xs-6 -->
					<div class="col-xs-6">
						<?php echo strtoupper($x); ?>
						-
						<?php echo $y; ?>
					</div>
					<!-- /.col-xs-6 -->
					<!-- .col-xs-6 -->
					<div class="col-xs-6 text-center">
						<?php echo $this->InlineForm2->control("number_$x$y"); ?>
					</div>
					<!-- /.col-xs-6 -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.panel-heading -->
				<!-- .panel-body -->
				<div class="panel-body text-center">
					<?php echo $this->InlineForm2->control("name_$x$y"); ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel panel-default -->
			<?php endif; ?>
		</div>
		<!-- /.col-xs-6 -->
		<?php endforeach; ?>
	</div>
	<!-- /.row -->
	<?php endfor; ?>
</div>
<!-- /.container -->

<?php echo $this->InlineForm2->end(); ?>
