<?php
	App::uses('AutoFieldModel', 'SwordWorld2.Model');
	class CharacterSkill extends AutoFieldModel {
		public $belongsTo = [
		'SwordWorld2.Skill',
		'SwordWorld2.Character',
		];

		private $exp_table = [
		500,
		1000,
		1000,
		1500,
		1500,
		2000,
		2500,
		3000,
		4000,
		5000,
		6000,
		7500,
		9000,
		10500,
		12000,
		13500,
		];

		public $rules;

		function __construct() {
			parent::__construct();

			$this->addAutoField(
				'next_experience_points',
				['CharacterSkill.skill_id', 'CharacterSkill.level', 'Skill.table_a'],
				function($data) {
					$level = Hash::get($data, 'CharacterSkill.level');
					return ($level > 0 && $level <= 15) ? $this->exp_table[$level+Hash::get($data, 'Skill.table_a')] : null;
				}
			);

			$this->addAutoField(
				'total_experience_points',
				['CharacterSkill.skill_id', 'CharacterSkill.level', 'Skill.table_a'],
				function($data) {
					$level = Hash::get($data, 'CharacterSkill.level');
					$table = Hash::get($data, 'Skill.table_a');
					return ($level > 0 && $level <= 15) ? array_sum(array_slice($this->exp_table, $table, $level)) : null;
				}
			);

			$this->addAutoField(
				'magic_power',
				['CharacterSkill.level', 'CharacterSkill.skill_id', 'Character.intelligence_bonus', 'Character.correction_magic_power'],
				function($data) {
					$type = $this->Skill->field('skill_type', [
					'Skill.id' => Hash::get($data, 'CharacterSkill.skill_id'),
					]);
					if ($type != 1) return null;
					return Hash::get($data, 'CharacterSkill.level') + Hash::get($data, 'Character.intelligence_bonus') + Hash::get($data, 'Character.correction_magic_power');
				}
			);
		}
	}
