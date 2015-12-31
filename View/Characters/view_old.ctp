<style>
	body {
		margin-top: 50px;
		padding-top: 0;
	}

	#CharacterImage {
			max-height: 300px;
	}

	.text-middle {
		vertical-align: middle !important;
	}

   	.pre:before	{
		color: gray;
		padding-right: 5px;
		float: left;
	}
	.pre-plus:before {
		content: '+';
	}
	.pre-equal:before {
		content: '=';
	}

	.suf:after {
		float: right;
		color: gray;
		padding-left: 5px;
	}
	.suf-m:after {
		content: 'm';
	}
</style>
<?php
	echo $this->InlineForm->create($character, 'Character', [
	'readonly' => !$is_owned,
	'true' => '<span class="glyphicon glyphicon-check"></span>',
	'false' => '<span class="glyphicon glyphicon-unchecked"></span>',
	'input' => [
	'class' => 'form-control',
	],
	]);
?>
<div class="jumbotron">
	<div class="container">
		<div class="alert alert-info" style="margin-top: -28px;">
			<span class="glyphicon glyphicon-info-sign"></span>
			<?php echo __('This is old version of character sheet.'); ?>
			<?php echo __('You can visit to new page by '); echo $this->Html->link(__('this link'), ['action' => 'view', $character['Character']['id']]); echo __('.'); ?>
		</div>
		<div class="row">
			<div class="col-md-4 text-center">
				<?php
					echo $this->AjaxImage->img($character, 'Character.image', $this->Html->url(['action' => 'image', $character['Character']['id']]), ['id' => 'CharacterImage', 'class' => 'img-thumbnail img-responsive']);
				?>
			</div>
			<div class="col-md-8">
				<div class="row">
					<h1 class="col-md-12">
						<?php echo $this->InlineForm->control('name'); ?>
					</h1> <!-- col -->
				</div> <!-- row -->
				<div class="row">
					<div class="col-sm-4 col-md-6">
						<dl>
							<dt><?php echo __('User'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('User.name', ['readonly' => true]); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-4 col-md-6">
						<dl>
							<dt><?php echo __('Campaign'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('campaign_id', ['options' => $campaigns, 'empty' => true]); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-2 col-md-2">
						<dl>
							<dt><?php echo __('Sex'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('sex_id', ['options' => [__('Male'), __('Female')], 'empty' => true]); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-2 col-md-1">
						<dl>
							<dt><?php echo __('Age'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('age', ['type' => 'number']); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-3 col-md-2">
						<dl>
							<dt><?php echo __('Race'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('race_id', ['options' => $races]); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-3 col-md-3">
						<dl>
							<dt><?php echo __('Racial Abilities'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('Race.abilities', ['readonly' => true]); ?>
							</dd>
						</dl>
					</div> <!-- col -->
					<div class="col-sm-3 col-md-3">
						<dl>
							<dt><?php echo __('Nationality'); ?></dt>
							<dd>
							<?php echo $this->InlineForm->control('nationality'); ?>
							</dd>
						</dl>
					</div> <!-- col -->
				</div> <!-- row -->
			</div> <!-- col -->
		</div> <!-- row -->
	</div> <!-- container -->
</div> <!-- jumbotron -->
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Basic Informations'); ?>
				</div>
				<table class="table">
					<tbody>
						<tr>
							<th><?php echo __('Adventurer Level'); ?></th>
							<td><?php echo $this->InlineForm->control('adventurer_level', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Experience Points'); ?></th>
							<td><?php echo $this->InlineForm->control('experience_points', ['type' => 'number']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Fumbles'); ?></th>
							<td><?php echo $this->InlineForm->control('fumbles', ['type' => 'number']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Number of Growth'); ?></th>
							<td><?php echo $this->InlineForm->control('number_of_growth', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Is Private'); ?></th>
							<td><?php echo $this->InlineForm->control('is_private', ['type' => 'checkbox']); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Backgrounds / Notes'); ?>
				</div>
				<div class="panel-body">
					<?php echo $this->InlineForm->control('backgrounds_notes', ['multiline' => true]); ?>
				</div>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Inventory'); ?>
				</div>
				<div class="panel-body">
					<?php echo $this->InlineForm->control('inventory', ['multiline' => true]); ?>
				</div>
			</div> <!-- panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Money'); ?>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th><?php echo __('Money on Hands'); ?></th>
							<th><?php echo __('Deposit'); ?></th>
							<th><?php echo __('Debt'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $this->InlineForm->control('money_on_hand', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('money_deposit', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('money_debt', ['type' => 'number']); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Consumable Supplies'); ?>
				</div>
				<div class="table-responsive">
					<?php 
						echo $this->InlineForm->createTable('CharacterItem', [
						'name',
						'count',
						], ['class' => 'table']);
					?>
					<thead><?php echo $this->InlineForm->thead(); ?></thead>
					<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
					<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
					<?php echo $this->InlineForm->endTable(); ?>
				</div>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Ornaments'); ?>
				</div>
				<table class="table table-bordered">
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
							<td><?php echo $this->InlineForm->control("ornament_{$path}_name"); ?></td>
							<td><?php echo $this->InlineForm->control("ornament_{$path}_effect", ['multiline' => true]); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Languages'); ?>
				</div>
				<div class="table-responsive">
					<?php 
						echo $this->InlineForm->createTable('CharacterLanguage', [
						'name' => ['name' => __('Language')],
						'talk' => ['type' => 'checkbox'],
						'write' => ['type' => 'checkbox'],
						], ['class' => 'table']);
					?>
					<thead><?php echo $this->InlineForm->thead(); ?></thead>
					<tbody>
						<tr>
							<td><?php echo __('Common Trade Language'); ?></td>
							<td><span class="glyphicon glyphicon-check"></span></td>
							<td><span class="glyphicon glyphicon-check"></span></td>
						</tr>
						<?php echo $this->InlineForm->tbody(); ?>
					</tbody>
					<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
					<?php echo $this->InlineForm->endTable(); ?>
				</div>
			</div> <!-- panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Honorable Items'); ?>
				</div>
				<div class="table-responsive">
					<?php 
						echo $this->InlineForm->createTable('CharacterHonorableItem', [
						'name',
						'honors' => ['type' => 'number'],
						], ['class' => 'table']);
					?>
					<thead><?php echo $this->InlineForm->thead(); ?></thead>
					<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
					<tfoot>
						<tr>
							<th><?php echo __('Honors in Hand'); ?></th>
							<td><?php echo $this->InlineForm->control('honors', ['type' => 'number']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Total Honors'); ?></th>
							<td><?php echo $this->InlineForm->control('total_honors', ['readonly' => true]); ?></td>
						</tr>
						<?php echo $this->InlineForm->tfoot(); ?>
					</tfoot>
					<?php echo $this->InlineForm->endTable(); ?>
				</div>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#AbilityRaderChartModal"><span class="glyphicon glyphicon-screenshot"></span></button>
					<?php echo __('Ability Points'); ?>
				</div>
				<table id="AbilityTable" class="table table-bordered text-center">
                    <thead>
						<tr>
							<th></th>
							<th></th>
							<th colspan="2"><?php echo __('Base Value'); ?></th>
							<th><?php echo __('Growth'); ?></th>
							<th><?php echo __('Ability Points'); ?></th>
							<th><?php echo __('Bonus'); ?></th>
						</tr>
                    </thead>
					<tbody>
						<?php
							$base_abilities = [
							[__('Ability Skill'), 'ability_skill'],
							[__('Ability Body'), 'ability_body'],
							[__('Ability Mind'), 'ability_mind'],
							];
							$ability_table = [
							[__('Dexterity'), 'ability_a', 'growth_a', 'dexterity', 'dexterity_bonus'],
							[__('Agility'), 'ability_b', 'growth_b', 'agility', 'agility_bonus'],
							[__('Strength'), 'ability_c', 'growth_c', 'strength', 'strength_bonus'],
							[__('Vitality'), 'ability_d', 'growth_d', 'vitality', 'vitality_bonus'],
							[__('Intelligence'), 'ability_e', 'growth_e', 'intelligence', 'intelligence_bonus'],
							[__('Spirit'), 'ability_f', 'growth_f', 'spirit', 'spirit_bonus'],

							];

							echo implode(array_map(function ($i, $ability) use($base_abilities) {
								$html = '';

								if ($i%2 == 0) {
									$j = floor($i / 2);
									$html .= $this->Html->tag('th', $base_abilities[$j][0], ['rowspan' => 2, 'class' => 'text-middle']);
								}

								$html .= $this->Html->tag('th', $ability[0]);

								if ($i%2 == 0) {
									$html .= $this->Html->tag('td', $this->InlineForm->control($base_abilities[$j][1], ['type' => 'number']), ['rowspan' => 2, 'class' => 'text-middle']);
								}

								$html .= $this->Html->tag('td', $this->InlineForm->control($ability[1], ['type' => 'number']), ['class' => 'pre pre-plus']);
								$html .= $this->Html->tag('td', $this->InlineForm->control($ability[2], ['type' => 'number']), ['class' => 'pre pre-plus']);
								$html .= $this->Html->tag('td', $this->InlineForm->control($ability[3], ['readonly' => true]), ['class' => 'pre pre-equal']);
								$html .= $this->Html->tag('td', $this->InlineForm->control($ability[4], ['readonly' => true]), ['class' => 'pre pre-plus']);

								return $this->Html->tag('tr', $html);
							}, array_keys($ability_table), $ability_table));
						?>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Skills'); ?>
				</div>
				<div class="table-responsive">
					<?php
						echo $this->InlineForm->createTable('CharacterSkill', [
						'skill_id' => ['name' => __('Skill'), 'options' => $skills],
						'level' => ['type' => 'number'],
						'next_experience_points' => ['name' => __('Next'), 'readonly' => true],
						'total_experience_points' => ['name' => __('Total'), 'readonly' => true],
						], [
						'class' => 'table',
						]);
					?>
					<thead><?php echo $this->InlineForm->thead(); ?></thead>
					<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
					<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
					<?php echo $this->InlineForm->endTable(); ?>
				</div>
			</div>
		</div> <!-- col -->
	</div> <!-- row -->

	<div class="row">
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<table class="table">
					<tbody>
						<tr>
							<th><?php echo __('HP'); ?></th>
							<td><?php echo $this->InlineForm->control('hp', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('MP'); ?></th>
							<td><?php echo $this->InlineForm->control('mp', ['readonly' => true]); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<table class="table">
					<tbody>
						<tr>
							<th><?php echo __('Fortitude'); ?></th>
							<td><?php echo $this->InlineForm->control('fortitude', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Willpower'); ?></th>
							<td><?php echo $this->InlineForm->control('willpower', ['readonly' => true]); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<table class="table">
					<tbody>
						<tr>
							<th><?php echo __('Monster Lore'); ?></th>
							<td><?php echo $this->InlineForm->control('monster_lore', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Initiative'); ?></th>
							<td><?php echo $this->InlineForm->control('initiative', ['readonly' => true]); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<table class="table">
					<tbody>
						<tr>
							<th><?php echo __('Limited Speed'); ?></th>
							<td><?php echo $this->InlineForm->control('limited_speed', ['readonly' => true], ['class' => 'text-right suf suf-m']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Speed'); ?></th>
							<td><?php echo $this->InlineForm->control('speed', ['readonly' => true], ['class' => 'text-right suf suf-m']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Maximum Speed'); ?></th>
							<td><?php echo $this->InlineForm->control('maximum_speed', ['readonly' => true], ['class' => 'text-right suf suf-m']); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Waepons'); ?>
				</div>
				<div class="table-responsive">
					<?php
						echo $this->InlineForm->createTable('CharacterWaepon', [
						'name',
						'skill_id' => [
						'name' => __('Using Skill'),
						'options' => $combat_skills,
						'empty' => true,
						],
						'to_hold',
						'strength_require' => ['name' => __('StrReq'), 'type' => 'number'],
						'accuracy_correction' => ['type' => 'number'],
						'accuracy' => ['readonly' => true],
						'impact_table' => ['name' => __('I-Table'), 'type' => 'number'],
						'impact_3' => ['name' => '&#9314;', 'type' => 'text'],
						'impact_4' => ['name' => '&#9315;', 'type' => 'text'],
						'impact_5' => ['name' => '&#9316;', 'type' => 'text'],
						'impact_6' => ['name' => '&#9317;', 'type' => 'text'],
						'impact_7' => ['name' => '&#9318;', 'type' => 'text'],
						'impact_8' => ['name' => '&#9319;', 'type' => 'text'],
						'impact_9' => ['name' => '&#9320;', 'type' => 'text'],
						'impact_10' => ['name' => '&#9321;', 'type' => 'text'],
						'impact_11' => ['name' => '&#9322;', 'type' => 'text'],
						'impact_12' => ['name' => '&#9323;', 'type' => 'text'],
						'base_critical' => ['name' => __('Base Crit'), 'type' => 'text'],
						'extra_damage_correction' => ['name' => __('Damage Correction'), 'type' => 'number'],
						'extra_damage' => ['readonly' => true],
						'memo',
						], ['class' => 'table']);
					?>
					<thead><?php echo $this->InlineForm->thead(); ?></thead>
					<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
					<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
					<?php echo $this->InlineForm->endTable(); ?>
				</div>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th><?php echo __('Name'); ?></th>
							<th><?php echo __('Strength Require'); ?></th>
							<th><?php echo __('Protection Point'); ?></th>
							<th><?php echo __('Evasion'); ?></th>
							<th><?php echo __('Memo'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?php echo __('Armor'); ?></th>
							<td><?php echo $this->InlineForm->control('armor_name'); ?></td>
							<td><?php echo $this->InlineForm->control('armor_strength_require', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('armor_protection_point', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('armor_evasion', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('armor_memo'); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Shield'); ?></th>
							<td><?php echo $this->InlineForm->control('shield_name'); ?></td>
							<td><?php echo $this->InlineForm->control('shield_strength_require', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('shield_protection_point', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('shield_evasion', ['type' => 'number']); ?></td>
							<td><?php echo $this->InlineForm->control('shield_memo'); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th><?php echo __('Using Skill'); ?></th>
							<th><?php echo __('Sum'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?php echo __('Protection Point'); ?> </th>
							<td class="text-center">-</td>
							<td><?php echo $this->InlineForm->control('protection_point', ['readonly' => true]); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Evasion'); ?> </th>
							<td><?php echo $this->InlineForm->control('evasion_skill_id', ['options' => $combat_skills, 'empty' => true]); ?></td>
							<td><?php echo $this->InlineForm->control('evasion', ['readonly' => true]); ?></td>
						</tr>
					</tbody>
				</table>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Combat Feats'); ?>
				</div>
				<?php
					echo $this->InlineForm->createTable('CombatFeat', [
					'name',
					'auto_acquire' => ['type' => 'checkbox'],
					'effects',
					], ['class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Magic Powers'); ?>
				</div>
				<?php
					echo $this->InlineForm->createTable('MagicPower', [
					'Skill.name' => ['name' => __('Name'), 'readonly' => true],
					'level' => ['readonly' => true],
					'Character.intelligence_bonus' => ['name' => __('Intelligence Bonus'), 'readonly' => true],
					'magic_power' => ['readonly' => true],
					], ['readonly' => true, 'class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Enhancer'); ?>
				</div>
				<?php
					echo $this->InlineForm->createTable('CharacterEnhancerAbility', [
					'name',
					'effects',
					], ['class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Rider'); ?>
				</div>
				<div class="panel-body">
					<dl>
						<dt><?php echo __('Skill Level'); ?></dt>
						<dd><?php echo $this->InlineForm->control('rider_level', ['readonly' => true]); ?></dd>
					</dl>
				</div>
				<?php
					echo $this->InlineForm->createTable('CharacterRiderAbility', [
					'name',
					'effects',
					], ['class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Bard'); ?>
				</div>
				<div class="panel-body">
					<dl>
						<dt><?php echo __('Standard Value'); ?></dt>
						<dd><?php echo $this->InlineForm->control('bard_standard_value', ['readonly' => true]); ?></dd>
						<dt><?php echo __('Effective Range'); ?></dt>
						<dd><?php echo $this->InlineForm->control('bard_range', ['readonly' => true, 'class' => 'suf suf-m']); ?></dd>
					</dl>
						<dt><?php echo __('Instrument'); ?></dt>
						<dd><?php echo $this->InlineForm->control('bard_instrument'); ?></dd>
					</dl>
						<dt><?php echo __('Pet'); ?></dt>
						<dd><?php echo $this->InlineForm->control('bard_pet'); ?></dd>
					</dl>
				</div>
				<?php
					echo $this->InlineForm->createTable('CharacterBardAbility', [
					'name',
					'effects',
					'introduction',
					], ['class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __('Alchemist'); ?>
				</div>
				<div class="panel-body">
					<dl>
						<dt><?php echo __('Standard Value'); ?></dt>
						<dd><?php echo $this->InlineForm->control('alchemist_standard_value', ['readonly' => true]); ?></dd>
					</dl>
				</div>
				<?php
					echo $this->InlineForm->createTable('CharacterAlchemistAbility', [
					'name',
					'effects',
					'using_cards',
					], ['class' => 'table']);
				?>
				<thead><?php echo $this->InlineForm->thead(); ?></thead>
				<tbody><?php echo $this->InlineForm->tbody(); ?></tbody>
				<tfoot><?php echo $this->InlineForm->tfoot(); ?></tfoot>
				<?php echo $this->InlineForm->endTable(); ?>
			</div> <!-- panel -->
		</div> <!-- col -->
	</div> <!-- row -->
	<?php if ($is_owned): ?>
	<span>
		<?php
			echo $this->Html->link(
				__('Recalculate'),
				array('action' => 'recalculate', $character['Character']['id']),
				array('class' => 'btn btn-info', 'role' => 'button')
			);
		?>
	</span>
	<span>
		<?php echo $this->Html->tag('button', __('Delete Character'), ['class' => 'btn btn-danger', 'onclick' => 'if (confirm("' . __('Are you sure to delete character?') . '")) document.deleteform.submit(); return false;']); ?>
	</span>
	<?php endif; ?>
</div> <!-- container -->
<?php echo $this->InlineForm->end(); ?>
<form method="POST" action="<?php echo $this->Html->url(['action' => 'delete', $character['Character']['id']]); ?>" style="display: none" name="deleteform">
</form>

<div id="AbilityRaderChartModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Close'); ?></span></button>
      <h4 class="modal-title"><?php echo __('Ability Points'); ?></h4>
      </div>
      <div class="modal-body text-center">
<canvas id="#AbilityRaderChart" width=256 height=256 class="rader" data-header="#AbilityTable tbody tr:nth-child(odd) th:nth-child(2), #AbilityTable tbody tr:nth-child(even) th:nth-child(1)" data-target="#AbilityTable tbody tr td:nth-last-child(2) .if-value">
</canvas>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close"); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php echo $this->Html->script("SwordWorld2.rader", ["inline" => false]); ?>
