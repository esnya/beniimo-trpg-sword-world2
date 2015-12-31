<div class="container">
	<?php
		echo $this->InlineForm->create($sample_character, 'SampleCharacter', [
		'true' => '<span class="glyphicon glyphicon-check"></span>',
		'false' => '<span class="glyphicon glyphicon-unchecked"></span>',
		'input' => [
		'class' => 'form-control',
		],
		]);
	?>
	<div class="form-group">
		<label for="data[SampleCharacter][name]"><?php echo __('Name'); ?></label>
		<?php echo $this->InlineForm->control('name', [], [], ['class' => 'form-control']); ?>
	</div>
	<div class="form-group">
		<label for="data[SampleCharacter][race_id]"><?php echo __('Race'); ?></label>
		<?php echo $this->InlineForm->control('race_id', ['options' => $races]); ?>
	</div>
	<div class="form-group">
		<label for="data[SampleCharacter][nationality]"><?php echo __('Nationality'); ?></label>
		<?php echo $this->InlineForm->control('nationality'); ?>
	</div>
	<div class="form-group">
		<label for="data[SampleCharacter][adventurer_level]"><?php echo __('Adventurer Level'); ?></label>
		<?php echo $this->InlineForm->control('adventurer_level'); ?>
	</div>
	<div class="form-group">
		<label for="data[SampleCharacter][inventory]"><?php echo __('Inventory'); ?></label>
		<?php echo $this->InlineForm->control('inventory'); ?>
	</div>
	<div class="form-group">
		<label for="data[SampleCharacter][backgrounds_notes]"><?php echo __('Backgrounds / Notes'); ?></label>
		<?php echo $this->InlineForm->control('backgrounds_notes'); ?>
	</div>

	<div class="form-group">
		<label>
			<?php echo __('Ability Points'); ?>
		</label>
		<table class="table table-bordered text-center">
			<tbody>
				<tr>
					<th></th>
					<th></th>
					<th colspan="2"><?php echo __('Base Value'); ?></th>
					<th><?php echo __('Growth'); ?></th>
				</tr>
				<?php
					$base_abilities = [
					[__('Ability Skill'), 'ability_skill'],
					[__('Ability Body'), 'ability_body'],
					[__('Ability Mind'), 'ability_mind'],
					];
					$ability_table = [
					[__('Dexterity'), 'ability_a', 'growth_a'],
					[__('Agility'), 'ability_b', 'growth_b'],
					[__('Strength'), 'ability_c', 'growth_c'],
					[__('Vitality'), 'ability_d', 'growth_d'],
					[__('Intelligence'), 'ability_e', 'growth_e'],
					[__('Spirit'), 'ability_f', 'growth_f'],

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

						return $this->Html->tag('tr', $html);
					}, array_keys($ability_table), $ability_table));
				?>
			</tbody>
		</table>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Skills'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterSkill', [
			'skill_id' => ['name' => __('Skill'), 'options' => $skills],
			'level' => ['type' => 'number'],
			], ['class' => 'table']);
		?>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Languages'); ?></label>
		<?php
			echo $this->InlineForm->createTable('SampleCharacterLanguage', [
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

	<div class="form-group">
		<label class="sr-only"><?php echo __('Waepons'); ?></label>
		<div class="table-responsive">
			<?php
				echo $this->InlineForm->createSimpleTable('SampleCharacterWaepon', [
				'name' => ['name' => __('Waepon')],
				'skill_id' => [
				'name' => __('Using Skill'),
				'options' => $combat_skills,
				'empty' => true,
				],
				'to_hold',
				'strength_require' => ['type' => 'number'],
				'accuracy_correction' => ['name' => __('Correction'), 'type' => 'number'],
				'impact_table' => ['type' => 'number'],
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
				'extra_damage_correction' => ['name' => __('Correction'), 'type' => 'number'],
				'memo',

				], ['class' => 'table']);
			?>
		</div>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Combat Feats'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterCombatFeat', [
			'name' => ['name' => __('Combat Feat')],
			'auto_acquire' => ['type' => 'checkbox'],
			'effects',
			], ['class' => 'table']);
		?>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Ornaments'); ?></label>
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
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Rider Abilities'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterRiderAbility', [
			'name' => ['name' => __('Rider Ability')],
			'effects',
			], ['class' => 'table']);
		?>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Enhancer Abilities'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterEnhancerAbility', [
			'name' => ['name' => __('Enhancer Ability')],
			'effects',
			], ['class' => 'table']);
		?>
	</div>

	<div class="form-group">
		<label><?php echo __('Bard Instrument'); ?></label>
		<?php echo $this->InlineForm->control('bard_instrument'); ?>
	</div>
	<div class="form-group">
		<label><?php echo __('Bard Pet'); ?></label>
		<?php echo $this->InlineForm->control('bard_pet'); ?>
	</div>
	<div class="form-group">
		<label class="sr-only"><?php echo __('Bard Abilities'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterBardAbility', [
			'name' => ['name' => __('Bard Ability')],
			'instrument',
			'effects',
			], ['class' => 'table']);
		?>
	</div>

	<div class="form-group">
		<label class="sr-only"><?php echo __('Alchemist Abilities'); ?></label>
		<?php
			echo $this->InlineForm->createSimpleTable('SampleCharacterAlchemistAbility', [
			'name' => ['name' => __('Alchemist Ability')],
			'using_cards',
			'effects',
			], ['class' => 'table']);
		?>
	</div>
	<?php echo $this->InlineForm->end(); ?>
</div>
