<?php echo $this->Html->css('SwordWorld2.character_view'); ?>
<?php echo $this->Html->css('SwordWorld2.swicons'); ?>
<?php echo $this->Html->script('SwordWorld2.fixedtitle', ['inline' => false]); ?>
<?php echo $this->Html->scriptBlock('$(function() { var ability = $("#AbilityTable"); var size = Math.min(ability.width(), ability.height()) - 25; $("#AbilityRaderCanvas").attr("width", size).attr("height", size); });', ['inline' => false]); ?>
<?php echo $this->Html->script('SwordWorld2.rader', ['inline' => false]); ?>

<?php
	echo $this->InlineForm2->create($character, 'Character', 
		['class' =>  $is_owned ? '' : 'readonly',],
		[
			'readonly' => !$is_owned,
			'true' => '<span class="glyphicon glyphicon-check"></span>',
			'false' => '<span class="glyphicon glyphicon-unchecked"></span>',
		],
		[],
		['class' => 'form-control',]
	);
?>
<div class="jumbotron">
	<div class="container">
		<?php
			echo $this->AjaxImage->img($character, 'Character.image', $this->Html->url(['action' => 'image', $character['Character']['id']]), ['id' => 'Portrait', 'class' => '']);
		?>
	</div><!-- .container -->
</div><!-- .jumbotron -->

<div id="Name" class="fixed-title text-center" data-offset="50">
	<div class="container">
		<h1>
			<?php echo $this->InlineForm2->control('name'); ?>
		</h1>
	</div>
</div>

<div class="container">
	<div class="text-center">
		<?php echo $this->InlineForm2->control('User.name', ['readonly' => true]); ?>
	</div>
</div>

<div class="container">
	<div id="BasicInformation" class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6 col-md-3">
					<dl class="dl-horizontal dl-centered dl-compact dl-bordered">
						<dt><?php echo __('Race'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('race_id', ['options' => $races]); ?></dd>
						<dd style="margin-left: 5px;"><?php echo $this->InlineForm2->control('Race.abilities', ['readonly' => true]); ?></dd>
					</dl>
				</div><!-- /.col -->

				<div class="col-sm-6 col-md-3">
					<dl class="dl-horizontal dl-centered dl-compact dl-bordered">
						<dt><?php echo __('Level'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('adventurer_level', ['readonly' => true]); ?></dd>
						<dt><?php echo __('Belongs'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('campaign_id', ['options' => $campaigns, 'empty' => true]); ?></dd>
					</dl>
				</div><!-- /.col -->

				<div class="col-sm-4 col-md-2">
					<dl class="dl-horizontal dl-centered dl-compact dl-bordered">
						<dt><?php echo __('Age'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('age'); ?></dd>
						<dt><?php echo __('Sex'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('sex_id', ['options' => [__('Male'), __('Female')], 'empty' => true]); ?></dd>
					</dl>
				</div><!-- /.col -->

				<div class="col-sm-4 col-md-2">
					<dl class="dl-horizontal dl-centered dl-compact dl-bordered">
						<dt><?php echo __('Experience Points'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('experience_points', ['type' => 'number']); ?></dd>
						<dt><?php echo __('Fumbles'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('fumbles', ['type' => 'number']); ?></dd>
					</dl>
				</div><!-- /.col -->

				<div class="col-sm-4 col-md-2">
					<dl class="dl-horizontal dl-centered dl-compact dl-bordered">
						<dt><?php echo __('Number of Growth'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('number_of_growth', ['readonly' => true]); ?></dd>
						<dt><?php echo __('Is Private'); ?></dt>
						<dd><?php echo $this->InlineForm2->control('is_private', ['type' => 'checkbox']); ?></dd>
					</dl>
				</div><!-- /.col -->

			</div><!-- /.row -->
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->
	<div class="row">
		<div class="col-md-6" id="Ability">
			<div class="panel panel-default">
				<div class="tab-content">
					<div id="AbilityTable" class="tab-pane active">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th colspan="2" class="hidden-xs"><?php echo $this->InlineForm2->control('nationality'); ?></th>
									<th class="visible-xs"><?php echo $this->InlineForm2->control('nationality'); ?></th>
									<th class="hidden-xs" colspan="2"><?php echo __('Base Value'); ?></th>
									<th class=""><?php echo __('Growth'); ?></th>
									<th class=""><?php echo __('Ability Points'); ?></th>
									<th class=""><?php echo __('Bonus'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$base_value_names = [__('Ability Skill'), __('Ability Body'), __('Ability Mind')];
									$base_value_fields = ['ability_skill', 'ability_body', 'ability_mind'];
									$ability_names= [__('Dexterity'), __('Agility'), __('Strength'), __('Vitality'), __('Intelligence'), __('Spirit')];
									$ability_fields = ['dexterity', 'agility', 'strength', 'vitality', 'intelligence', 'spirit'];
									$ability_alphas = ['a', 'b', 'c', 'd', 'e', 'f'];

									for ($i = 0; $i < 6; $i++) {
									?>
									<tr>
										<?php if ($i % 2 == 0): ?>
										<th class="hidden-xs" rowspan="2"><?php echo $base_value_names[floor($i / 2)]; ?></th>
										<?php endif; ?>
										<th class=""><?php echo $ability_names[$i]; ?></th>
										<?php if ($i % 2 == 0): ?>
										<td class="hidden-xs" rowspan="2"><?php echo $this->InlineForm2->control($base_value_fields[floor($i / 2)]); ?></td>
										<?php endif; ?>
										<td class="prefix prefix-plus hidden-xs"><?php echo $this->InlineForm2->control('ability_' . $ability_alphas[$i]); ?></td>
										<td class="prefix prefix-plus"><?php echo $this->InlineForm2->control('growth_' . $ability_alphas[$i]); ?></td>
										<td class="prefix prefix-equal"><?php echo $this->InlineForm2->control($ability_fields[$i], ['readonly' => true]); ?></td>
										<td class="prefix prefix-plus"><?php echo $this->InlineForm2->control($ability_fields[$i] . '_bonus', ['readonly' => true]); ?></td>
									</tr>
									<?php
									}
								?>
							</tbody>
						</table>
					</div> <!-- /.tab-pane -->
					<div id="AbilityRader" class="tab-pane">
						<canvas id="AbilityRaderCanvas" class="rader" data-header="#AbilityTable tbody tr:nth-child(odd) th:nth-child(2), #AbilityTable tbody tr:nth-child(even) th:first-child" data-target="#AbilityTable tbody tr td:nth-last-child(2) .if-value" width="256" height="256">
						</canvas>
					</div>
				</div><!-- /.tab-content -->
			</div><!-- /.panel -->
			<ul class="nav nav-tabs nav-stacked nav-tabs-right" role="tablist">
				<li class="active"><a href="#AbilityTable" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span></a></li>
				<li><a href="#AbilityRader" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-screenshot"></span></a></li>
			</ul>
		</div><!-- /.col -->

		<div class="col-md-6" id="Skill">
			<div class="panel panel-default">
				<table class="table">
					<thead>
						<tr>
							<th class="hidden-readonly column-0"></th>
							<th><?php echo __('Skill'); ?></th>
							<th class="text-center"><?php echo __('Level'); ?></th>
							<th class="text-center"><?php echo __('Magic Power'); ?></th>
							<th class="text-center"><?php echo __('Next'); ?></th>
							<th class="text-center"><?php echo __('Total'); ?></th>
						</tr>
					</thead>
					<?php echo $this->InlineForm2->createHasManyChild('CharacterSkill', ['tag' => 'tbody']); ?>
					<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
					<td class="text-center hidden-readonly column-0">
						<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
					</td>
					<td><?php echo $this->InlineForm2->control('skill_id', ['options' => $skills]); ?></td>
					<td class="text-center"><?php echo $this->InlineForm2->control('level'); ?></td>
					<td class="text-center"><?php echo $this->InlineForm2->control('magic_power', ['readonly' => true]); ?></td>
					<td class="text-center"><?php echo $this->InlineForm2->control('next_experience_points', ['readonly' => true]); ?></td>
					<td class="text-center"><?php echo $this->InlineForm2->control('total_experience_points', ['readonly' => true]); ?></td>
					<?php echo $this->InlineForm2->endTemplate(); ?>
					<?php echo $this->InlineForm2->endHasManyChild(); ?>
				</table>

				<?php
					echo $this->InlineForm2->addButton(
						'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
						[
							'model' => 'CharacterSkill',
							'tag' => 'a',
							'href' => '#',
							'onclick' => 'return false'
						]
					);
				?>
			</div><!-- /.panel -->
		</div><!-- /.col -->
	</div><!-- /.row -->

	<div class="panel panel-default" id="StandardValue">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<dl class="dl-horizontal dl-bordered">
						<dt><?php echo __('HP'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('hp', ['readonly' => true]); ?></dd>
						<dt><?php echo __('MP'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('mp', ['readonly' => true]); ?></dd>
					</dl>
				</div>
				<div class="col-xs-6 col-md-3">
					<dl class="dl-horizontal dl-bordered">
						<dt><?php echo __('Fortitude'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('fortitude', ['readonly' => true]); ?></dd>
						<dt><?php echo __('Willpower'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('willpower', ['readonly' => true]); ?></dd>
					</dl>
				</div>
				<div class="col-xs-6 col-md-3">
					<dl class="dl-horizontal dl-bordered">
						<dt><?php echo __('Monster Lore'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('monster_lore', ['readonly' => true]); ?></dd>
						<dt><?php echo __('Initiative'); ?></dt>
						<dd class="text-center">&nbsp;<?php echo $this->InlineForm2->control('initiative', ['readonly' => true]); ?></dd>
					</dl>
				</div>
				<div class="col-xs-6 col-md-3">
					<dl class="dl-horizontal dl-bordered">
						<dt><?php echo __('Speed'); ?></dt>
						<dd class="text-center"><div class="suffix suffix-m">&nbsp;<?php echo $this->InlineForm2->control('speed', ['readonly' => true]); ?></div></dd>
						<dt><?php echo __('Maximum Speed'); ?></dt>
						<dd class="text-center"><div class="suffix suffix-m">&nbsp;<?php echo $this->InlineForm2->control('maximum_speed', ['readonly' => true]); ?></div></dd>
					</dl>
				</div>
			</div><!-- /.row -->
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->

	<div id="Waepon">
		<?php echo $this->InlineForm2->createHasManyChild('CharacterWaepon', ['tag' => 'ul', 'class' => 'nav nav-tabs nav-tabs-left nav-stacked text-center']); ?>
		<?php $first = true; ?>
		<?php
			echo $this->InlineForm2->startTemplate(['tag' => 'li', 'callback' => function (&$options, $data) use(&$first) {
				if ($first) {
					$first = false;
					$options['class'][] = 'active';
				}
			}]);
		?>
		<?php
			echo $this->InlineForm2->control('name', ['readonly' => true, 'tag' => 'a', 'role' => 'tab', 'data-toggle' => 'tab', 'callback' => function (&$options, &$data) {
				$options['href'] = "#Waepon{$data['CharacterWaepon']['id']}";
			}]);
		?>
		<?php echo $this->InlineForm2->endTemplate(); ?>
		<li><?php echo $this->InlineForm2->addButton('<span class="glyphicon glyphicon-plus"></span>', ['tag' => 'a', 'class' => 'hidden-readonly', 'href' => '#', 'onclick' => 'return false']); ?></li>
		<?php echo $this->InlineForm2->endHasManyChild(); ?>
		<?php echo $this->InlineForm2->createHasManyChild('CharacterWaepon', ['class' => 'tab-content']); ?>
		<?php $first = true; ?>
		<?php
			echo $this->InlineForm2->startTemplate([
				'class' => 'tab-pane waepon panel panel-default',
				'callback' => function (&$options, &$data) use(&$first) {
					if ($first) {
						$first = false;
						$options['class'][] = 'active';
					}

					$options['id'] = "Waepon{$data['CharacterWaepon']['id']}";
				}
			]);
		?>
		<div class="panel-body">
			<dl class="dl-horizontal dl-bordered">
				<dt><?php echo __('Waepon Name'); ?></dt>
				<dd><?php echo $this->InlineForm2->control('name'); ?></dd>
				<dt><?php echo __('Using Skill'); ?></dt>
				<dd><?php echo $this->InlineForm2->control('skill_id', ['empty' => true, 'options' => $combat_skills]); ?></dd>
			</dl>

			<div class="row">
				<div class="col-sm-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered">
								<dt><?php echo __('Strength Require'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('strength_require'); ?></dd>
								<dt><?php echo __('To Hold'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('to_hold'); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->

				<div class="col-sm-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered">
								<dt><?php echo __('Accuracy Correction'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('accuracy_correction'); ?></dd>
								<dt><?php echo __('Accuracy'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('accuracy', ['readonly' => true]); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->

				<div class="col-sm-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered">
								<dt><?php echo __('I-Table'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('impact_table'); ?></dd>
								<dt><?php echo __('Base Crit'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('base_critical'); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->

			</div><!-- /.row -->
			<div class="row">
				<div class="col-sm-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered">
								<dt><?php echo __('Damage Correction'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('extra_damage_correction'); ?></dd>
								<dt><?php echo __('Extra Damage'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('extra_damage', ['readonly' => true]); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->

				<div class="col-sm-8">
					<div class="panel panel-default">
						<div class="panel-body">
							<?php echo $this->InlineForm2->control('memo', ['multiline' => true]); ?>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->
			</div><!-- /.row -->

			<div class="panel panel-default">
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th class="text-center">&#9313;</th>
							<th class="text-center">&#9314;</th>
							<th class="text-center">&#9315;</th>
							<th class="text-center">&#9316;</th>
							<th class="text-center">&#9317;</th>
							<th class="text-center">&#9318;</th>
							<th class="text-center">&#9319;</th>
							<th class="text-center">&#9320;</th>
							<th class="text-center">&#9321;</th>
							<th class="text-center">&#9322;</th>
							<th class="text-center">&#9323;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>*</td>
							<td><?php echo $this->InlineForm2->control('impact_3'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_4'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_5'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_6'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_7'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_8'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_9'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_10'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_11'); ?></td>
							<td><?php echo $this->InlineForm2->control('impact_12'); ?></td>
						</tr>
					</tbody>
				</table>
			</div><!-- /.panel -->
			<div class="text-right">
				<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
			</div>
		</div><!-- /.panel-body -->
		<?php echo $this->InlineForm2->endTemplate(); ?>
		<?php echo $this->InlineForm2->endHasManyChild(); ?>
	</div><!-- /#Waepon -->

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div id="Armor" class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered dl-centered dl-compact">
								<dt><?php echo __('Armor'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('armor_name'); ?></dd>
								<dt><?php echo __('Strength Require'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('armor_strength_require'); ?></dd>
								<dt><?php echo __('Protection Point'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('armor_protection_point'); ?></dd>
								<dt><?php echo __('Evasion'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('armor_evasion'); ?></dd>
								<dt><?php echo __('Memo'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('armor_memo'); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->
				<div id="Shield" class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered dl-centered dl-compact">
								<dt><?php echo __('Shield'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('shield_name'); ?></dd>
								<dt><?php echo __('Strength Require'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('shield_strength_require'); ?></dd>
								<dt><?php echo __('Protection Point'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('shield_protection_point'); ?></dd>
								<dt><?php echo __('Evasion'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('shield_evasion'); ?></dd>
								<dt><?php echo __('Memo'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('shield_memo'); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.col -->
			</div><!-- /.row -->
			<div id="EvasionAndProtectionPoint">
				<dl class="dl-horizontal dl-bordered dl-centered">
					<dt><?php echo __('Evasion Skill'); ?></dt>
					<dd><?php echo $this->InlineForm2->control('evasion_skill_id', ['empty' => true, 'options'=> $combat_skills]); ?></dd>
					<dt><?php echo __('Protection Point'); ?></dt>
					<dd><?php echo $this->InlineForm2->control('protection_point', ['readonly' => true]); ?></dd>
					<dt><?php echo __('Evasion'); ?></dt>
					<dd><?php echo $this->InlineForm2->control('evasion', ['readonly' => true]); ?></dd>
				</dl>
			</div>
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->

	<div class="row">
		<div class="col-md-6">
			<ul class="nav nav-tabs nav-tabs-top" role="tablist">
				<li class="active"><a href="#Note" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-book"></span></a></li>
				<li><a href="#Inventory" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-briefcase"></span></a></li>
				<li><a href="#Ornament" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-user"></span></a></li>
				<li><a href="#Supply" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span></a></li>
				<li><a href="#Money" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-usd"></span></a></li>
				<li><a href="#CombatFeat" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-star"></span></a></li>
				<li><a href="#Language" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span></a></li>
				<li><a href="#HonorableItem" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-gift"></span></a></li>
			</ul>
			<div class="tab-content">
				<div id="Note" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo __('Backgrounds / Notes'); ?>
						</div>
						<div class="panel-body">
							<?php echo $this->InlineForm2->control('backgrounds_notes'); ?>
						</div>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="Inventory" class="tab-pane">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo __('Inventory'); ?>
						</div>
						<div class="panel-body">
							<?php echo $this->InlineForm2->control('inventory'); ?>
						</div>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="Supply" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Consumable Supplies'); ?></th>
									<th><?php echo __('Count'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterItem', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('count'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterItem',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="Money" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
							    <tr>
									<th><?php echo __('Money on Hands'); ?></th>
									<th><?php echo __('Deposit'); ?></th>
									<th><?php echo __('Debt'); ?></th>
							    </tr>
							</thead>
							<tbody>
							    <tr>
									<td class="suffix suffix-G"><?php echo $this->InlineForm2->control('money_on_hand'); ?></td>
									<td class="suffix suffix-G"><?php echo $this->InlineForm2->control('money_deposit'); ?></td>
									<td class="suffix suffix-G"><?php echo $this->InlineForm2->control('money_debt'); ?></td>
							    </tr>
							</tbody>
						</table>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="Ornament" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
								<tr>
									<th><?php echo __('Area'); ?></th>
									<th><?php echo __('Ornament'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$ornament_areas = array(
										'head' => __('Head'),
										'face' => __('Face'),
										'ears' => __('Ears'),
										'neck' => __('Neck'),
										'back' => __('Back'),
										'right_hand' => __('Right Hand'),
										'left_hand' => __('Left Hand'),
										'waist' => __('Waist'),
										'feet' => __('Feet'),
										'other' => __('Other'),
									);

									foreach ($ornament_areas as $path => $name) :
								?>
								<tr>
									<th><?php echo $name; ?></th>
									<td><?php echo $this->InlineForm2->control("ornament_{$path}_name"); ?></td>
									<td><?php echo $this->InlineForm2->control("ornament_{$path}_effect", ['multiline' => true]); ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="CombatFeat" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Combat Feat'); ?></th>
									<th><?php echo __('Auto Acquire'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CombatFeat', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('auto_acquire', ['type' => 'checkbox']); ?></td>
							<td><?php echo $this->InlineForm2->control('effects'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CombatFeat',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="Language" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Language'); ?></th>
									<th><?php echo __('Talk'); ?></th>
									<th><?php echo __('Write'); ?></th>
								</tr>
								<tr>
									<td></td>
									<td><?php echo __('Common Trade Language'); ?></td>
									<td><span class="text-primary glyphicon glyphicon-comment"></span></td>
									<td><span class="text-primary glyphicon glyphicon-pencil"></span></td>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterLanguage', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('talk', ['type' => 'checkbox', 'true' => '<span class="text-primary glyphicon glyphicon-comment"></span>', 'false' => '<span class="text-muted glyphicon glyphicon-comment"></span>']); ?></td>
							<td><?php echo $this->InlineForm2->control('write', ['type' => 'checkbox', 'true' => '<span class="text-primary glyphicon glyphicon-pencil"></span>', 'false' => '<span class="text-muted glyphicon glyphicon-pencil"></span>']); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterLanguage',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->

				<div id="HonorableItem" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered table-centered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Honorable Item'); ?></th>
									<th><?php echo __('Honors'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterHonorableItem', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('honors'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
							<tfoot>
								<tr>
									<th><?php echo __('Honors in Hand'); ?></th>
									<td><?php echo $this->InlineForm2->control('honors', ['type' => 'number']); ?></td>
								</tr>
								<tr>
									<th><?php echo __('Total Honors'); ?></th>
									<td><?php echo $this->InlineForm2->control('total_honors', ['readonly' => true]); ?></td>
								</tr>
							</tfoot>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterHonorableItem',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tab-pane -->


			</div><!-- /.tab-content-->
		</div><!-- /.col -->

		<div class="col-md-6">
			<ul class="nav nav-tabs nav-tabs-top" role="tablist">
				<li class="active"><a href="#Enhancer" role="tab" data-toggle="tab"><span class="glyphicon swicon-enhance"></span></a></li>
				<li><a href="#Bard" role="tab" data-toggle="tab"><span class="glyphicon swicon-bard"></span></a></li>
				<li><a href="#Rider" role="tab" data-toggle="tab"><span class="glyphicon swicon-rider"></span></a></li>
				<li><a href="#Alchemist" role="tab" data-toggle="tab"><span class="glyphicon swicon-alchemist"></span></a></li>
				<li><a href="#WarLeader" role="tab" data-toggle="tab"><span class="glyphicon swicon-warleader"></span></a></li>
				<li><a href="#Mistic" role="tab" data-toggle="tab"><span class="glyphicon swicon-mystic"></span></a></li>
			</ul>
			<div class="tab-content">
				<div id="Enhancer" class="tab-pane active">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Enhancer Ability'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterEnhancerAbility', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('effects'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterEnhancerAbility',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->

				<div id="Bard" class="tab-pane">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered dl-centered">
								<dt><?php echo __('Standard Value'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('bard_standard_value', ['readonly' => true]); ?></dd>
								<dt><?php echo __('Effective Range'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('bard_range', ['readonly' => true, 'class' => 'suffix suffix-m']); ?></dd>
								<dt><?php echo __('Instrument'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('bard_instrument'); ?></dd>
								<dt><?php echo __('Pet'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('bard_pet'); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Bard Ability'); ?></th>
									<th><?php echo __('Introduction'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterBardAbility', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('introduction'); ?></td>
							<td><?php echo $this->InlineForm2->control('effects'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterBardAbility',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->

				<div id="Rider" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Rider Ability'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterRiderAbility', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('effects'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterRiderAbility',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->

				<div id="Alchemist" class="tab-pane">
					<div class="panel panel-default">
						<div class="panel-body">
							<dl class="dl-horizontal dl-bordered dl-centered">
								<dt><?php echo __('Standard Value'); ?></dt>
								<dd><?php echo $this->InlineForm2->control('alchemist_standard_value', ['readonly' => true]); ?></dd>
							</dl>
						</div><!-- /.panel-body -->
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Alchemist Ability'); ?></th>
									<th><?php echo __('Card'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
							<?php echo $this->InlineForm2->createHasManyChild('CharacterAlchemistAbility', ['tag' => 'tbody']); ?>
							<?php echo $this->InlineForm2->startTemplate(['tag' => 'tr']); ?>
							<td class="text-center hidden-readonly column-0">
								<?php echo $this->InlineForm2->deleteButton('<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-xs btn-default']); ?>
							</td>
							<td><?php echo $this->InlineForm2->control('name'); ?></td>
							<td><?php echo $this->InlineForm2->control('using_cards'); ?></td>
							<td><?php echo $this->InlineForm2->control('effects'); ?></td>
							<?php echo $this->InlineForm2->endTemplate(); ?>
							<?php echo $this->InlineForm2->endHasManyChild(); ?>
						</table>
						<?php
							echo $this->InlineForm2->addButton(
								'<div class="panel-footer hidden-readonly text-center"><span class="glyphicon glyphicon-plus"></span></div>',
								[
								'model' => 'CharacterAlchemistAbility',
								'tag' => 'a',
								'href' => '#',
								'onclick' => 'return false'
								]
							);
						?>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->

				<div id="WarLeader" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('War Leader Ability'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
						</table>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->

				<div id="Mistic" class="tab-pane">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="hidden-readonly column-0"></th>
									<th><?php echo __('Mistic Ability'); ?></th>
									<th><?php echo __('Effects'); ?></th>
								</tr>
							</thead>
						</table>
					</div><!-- /.panel -->
				</div><!-- /.tabpane -->
			</div><!-- /.tab-content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
<?= $this->Html->link(__('Copy this link to use the character in the beniimo onnline chat'), ['action' => 'summary', Hash::get($character, 'Character.id') . '.json']) ?>
<div>
<input class=form-control type=text value="<?= 'http://' . Hash::get($_SERVER, 'HTTP_HOST') . $this->Html->url(['action' => 'summary', Hash::get($character, 'Character.id') . '.json']) ?>"readonly>
</div>
</div><!-- /.container -->

<?php echo $this->InlineForm2->end(); ?>
