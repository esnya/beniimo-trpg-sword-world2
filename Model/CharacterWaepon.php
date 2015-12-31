<?php
	App::uses('AutoFieldModel', 'SwordWorld2.Model');
	class CharacterWaepon extends AutoFieldModel {
		public $belongsTo = array(
			'SwordWorld2.Skill',
			'SwordWorld2.Character',
		);

		public function __construct() {
			parent::__construct();

			$this->addAutoField(
				'accuracy',
				['CharacterWaepon.accuracy_correction', 'CharacterWaepon.skill_id', 'CharacterWaepon.character_id', 'Character.dexterity_bonus', 'Character.correction_accuracy'],
				function ($data) {
					$level = $this->Character->CharacterSkill->field('level', [
					'character_id' => Hash::get($data, 'CharacterWaepon.character_id'),
					'skill_id' => Hash::get($data, 'CharacterWaepon.skill_id'),
					]);
					return ($level ? ($level + Hash::get($data, 'Character.dexterity_bonus')) : null) + Hash::get($data, 'CharacterWaepon.accuracy_correction') + Hash::get($data, 'Character.correction_accuracy');
				}
			);

			$this->addAutoField(
				'extra_damage',
				['CharacterWaepon.extra_damage_correction', 'CharacterWaepon.skill_id', 'CharacterWaepon.character_id', 'Character.strength_bonus', 'Character.correction_extra_damage'],
				function ($data) {
					$level = $this->Character->CharacterSkill->field('level', [
					'character_id' => Hash::get($data, 'CharacterWaepon.character_id'),
					'skill_id' => Hash::get($data, 'CharacterWaepon.skill_id'),
					]);
					return ($level ? ($level + Hash::get($data, 'Character.strength_bonus')) : null) + Hash::get($data, 'CharacterWaepon.extra_damage_correction') + Hash::get($data, 'Character.correction_extra_damage');
				}
			);
		}
	}
