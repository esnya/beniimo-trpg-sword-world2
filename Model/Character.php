<?php
	App::uses('AutoFieldModel', 'SwordWorld2.Model');
	class Character extends AutoFieldModel {
		public $belongsTo = array(
			'User',
			'SwordWorld2.Campaign',
			'SwordWorld2.Race',
			'EvasionSkill' => [
			'className' => 'SwordWorld2.Skill',
			'foreignKey' => 'evasion_skill_id',
			],
			'EvasionCharacterSkill' => [
			'className' => 'SwordWorld2.CharacterSkill',
			'foreignKey' => 'evasion_character_skill_id',
			],
		);

		public $hasMany = array(
			'CharacterSkill' => [
			'className' => 'SwordWorld2.CharacterSkill',
			'order' => ['level DESC', 'skill_id']
			],
			'SwordWorld2.CharacterItem',
			'SwordWorld2.CharacterLanguage',
			'SwordWorld2.CharacterHonorableItem',
			'SwordWorld2.CharacterWaepon',
			'CombatFeat' => [
			'className' => 'SwordWorld2.CombatFeat',
			'order' => 'auto_acquire DESC',
			],
			'MagicPower' => [
			'className' => 'SwordWorld2.CharacterSkill',
			'conditions' => [
			'magic_power not' => null, 'magic_power not' => 0,
			],
			'foreignKey' => 'character_id',
			],
			'SwordWorld2.CharacterEnhancerAbility',
			'SwordWorld2.CharacterRiderAbility',
			'SwordWorld2.CharacterBardAbility',
			'SwordWorld2.CharacterAlchemistAbility',
		);

		private static function correction_callback_builder($assigns, $ptn) {
			return function ($data) use ($assigns, $ptn) {
				$str = implode("\n", array_filter(
					Hash::flatten($data),
					function ($value) {
						return is_string($value);
					}
				));

				preg_match_all($ptn, $str, $matches, PREG_SET_ORDER);

				$value = array_sum(
					array_map(
						function ($match) {
							return ($match[2] == '-') ? -$match[3] : $match[3];
						},
						$matches
					)
				);

				return $value ? $value : null;
			};
		}

		public function __construct() {
			parent::__construct();

			$correction_fields = array(
				'dexterity' => ['dex', '器用度',],
				'agility' => ['agi', '敏捷度',],
				'strength' => ['str', '筋力',],
				'vitality' => ['vit', '生命力',],
				'intelligence' => ['int', '知力',],
				'spirit' => ['spr', '精神力',],
				'dexterity_bonus' => ['dex_bonus', 'dex_b', 'dexb', '器用度ボーナス', '器用度B', '器用度b'],
				'agility_bonus' => ['agi_bonus', 'agi_b', 'agib', '敏捷度ボーナス', '敏捷度B', '敏捷度b'],
				'strength_bonus' => ['str_bonus', 'str_b', 'strb', '筋力ボーナス', '筋力B', '筋力b'],
				'vitality_bonus' => ['vit_bonus', 'vit_b', 'vitb', '生命力ボーナス', '生命力B', '生命力b'],
				'intelligence_bonus' => ['int_bonus', 'int_b', 'intb', '知力ボーナス', '知力B', '知力b'],
				'spirit_bonus' => ['spr_bonus', 'spr_b', 'sprb', '精神力ボーナス', '精神力B', '精神力b'],
				'experience_points' => ['経験点',],
				'hp' => ['HP',],
				'mp' => ['MP',],
				'fortitude' => ['生命抵抗力',],
				'willpower' => ['精神抵抗力',],
				'monster_lore' => ['魔物知識','魔物知識判定',],
				'initiative' => ['先制',],
				'speed' => ['spd', '移動力',],
				'limited_speed' => ['制限移動',],
				'protection_point' => ['防護点',],
				'evasion' => ['回避力',],
				'accuracy' => ['命中力',],
				'extra_damage' => ['追加ダメージ',],
				'magic_power' => ['魔力',],
			);


			$ornament_areas = array('head', 'face', 'ears', 'neck', 'back', 'left_hand', 'right_hand', 'waist', 'feet', 'other');
			$correction_depends = array_merge(
				array_map(function ($area) { return "Character.ornament_{$area}_effect"; }, $ornament_areas),
				['CharacterWaepon.memo', 'Character.backgrounds_notes', 'CombatFeat.effects']
			);

			foreach ($correction_fields as $name => $assigns) {
				$assigns[] = $name;
				$tmp1 = implode('|', $assigns);
				$ptn = "/(?<!\(|（)($tmp1)(\+|-|=)([0-9]+)(?!\)|）)/";

				$this->addAutoField(
					"correction_$name",
					$correction_depends,
					$this->correction_callback_builder($assigns, $ptn)
				);
			}


			$sum_character = function ($data) { return array_sum($data['Character']); };

			foreach ([
			['dexterity', 'skill', 'a'],
			['agility', 'skill', 'b'],
			['strength', 'body', 'c'],
			['vitality', 'body', 'd'],
			['intelligence', 'mind', 'e'],
			['spirit', 'mind', 'f'],
			] as $ability) {
				$this->addAutoField(
					$ability[0],
					['Character.ability_' . $ability[1], 'Character.ability_' . $ability[2], 'Character.growth_' . $ability[2], 'Character.correction_' . $ability[0]],
					$sum_character
				);

				$this->addAutoField(
					$ability[0] . '_bonus',
					['Character.ability_' . $ability[1], 'Character.ability_' . $ability[2], 'Character.growth_' . $ability[2], $ability[0], 'Character.correction_' . $ability[0] . '_bonus'],
					function ($data) use($ability) {
						return floor(Hash::get($data, 'Character.' . $ability[0]) / 6) + Hash::get($data, 'Character.correction_' . $ability[0] . '_bonus');
					}
				);
			}

			$this->addAutoField(
				'adventurer_level',
				['CharacterSkill.level'],
				function ($data) {
					$levels = Hash::extract($data, 'CharacterSkill.{n}.level');
					return ($levels && !empty($levels)) ? max($levels) : null;
				}
			);

			$this->addAutoField(
				'experience_points',
				['Character.campaign_id', 'Character.fumbles', 'Character.experience_points', 'Campaign.experience_points', 'CharacterSkill.total_experience_points', 'Character.correction_experience_points'],
				function ($data) {
					if (!Hash::check($data, 'Character.campaign_id')) return Hash::get($data, 'Character.experience_points');
					return Hash::get($data, 'Campaign.experience_points') + Hash::get($data, 'Character.fumbles') * 50 - array_sum(Hash::extract($data, 'CharacterSkill.{n}.total_experience_points')) + Hash::get($data, 'Character.correction_experience_points');
				}
			);

			$this->addAutoField(
				'total_honors',
				['Character.honors', 'CharacterHonorableItem.honors'],
				function ($data) {
					return Hash::get($data, 'Character.honors') + array_sum(Hash::extract($data, 'CharacterHonorableItem.{n}.honors'));
				}
			);

			$this->addAutoField(
				'number_of_growth',
				['Character.growth_a', 'Character.growth_b', 'Character.growth_c', 'Character.growth_d', 'Character.growth_e', 'Character.growth_f'],
				$sum_character
			);

			$this->addAutoField(
				'hp',
				['Character.adventurer_level', 'Character.vitality', 'Character.correction_hp'],
				function ($data) {
					return Hash::get($data, 'Character.adventurer_level') * 3 + Hash::get($data, 'Character.vitality') + Hash::get($data, 'Character.correction_hp');
				}
			);

			$this->addAutoField(
				'mp',
				['Character.spirit', 'Character.race_id', 'CharacterSkill.skill_id', 'CharacterSkill.level', 'Character.correction_mp'],
				function ($data) {
					if (Hash::get($data, 'Character.race_id') == 12) {
						return null;
					} else {
						return Hash::get($data, 'Character.spirit') + array_sum(
							array_map(
								function ($skill) {
									return $skill['level'];
								}, array_filter(
									Hash::extract($data, 'CharacterSkill.{n}'),
									function ($skill) {
										$id = $skill['skill_id'];
										return $id >= 5 && $id <= 9 || $id == 17;
									}
								)
							)
						) * 3 + Hash::get($data, 'Character.correction_mp');
					}
				}
			);

			$this->addAutoField(
				'fortitude',
				['Character.adventurer_level', 'Character.vitality_bonus', 'Character.correction_fortitude'],
				$sum_character
			);
			$this->addAutoField(
				'willpower',
				['Character.adventurer_level', 'Character.spirit_bonus', 'Character.correction_willpower'],
				$sum_character
			);

			$this->addAutoField(
				'monster_lore',
				['Character.intelligence_bonus', 'CharacterSkill.skill_id', 'CharacterSkill.level', 'Character.correction_monster_lore'],
				function ($data) {
					$skills = array_filter(
						Hash::extract($data, 'CharacterSkill.{n}'),
						function ($skill) {
							return $skill['skill_id'] == 12 || $skill['skill_id'] == 15;
						}
					);
					if (!$skills || empty($skills)) {
						return null;
					} else {
						return Hash::get($data, 'Character.intelligence_bonus') + max(Hash::extract($skills, '{n}.level')) + Hash::get($data, 'Character.correction_monster_lore');
					}
				}
			);

			$this->addAutoField(
				'initiative',
				['Character.agility_bonus', 'CharacterSkill.skill_id', 'CharacterSkill.level', 'Character.correction_initiative'],
				function ($data) {
					$skills = array_filter(
						Hash::extract($data, 'CharacterSkill.{n}'),
						function ($skill) {
							return $skill['skill_id'] == 10;
						}
					);
					if (!$skills || empty($skills)) {
						return null;
					} else {
						return Hash::get($data, 'Character.agility_bonus') + max(Hash::extract($skills, '{n}.level')) + Hash::get($data, 'Character.correction_initiative');
					}
				}
			);

			$this->addAutoField(
				'limited_speed',
				['Character.agility', 'Character.correction_limited_speed'],
				function ($data) {
					$correction = Hash::get($data, 'Character.correction_limited_speed');
					return $correction ? $correction : 3;
				}
			);

			$this->addAutoField(
				'speed',
				['Character.agility', 'Character.correction_speed'],
				function ($data) {
					return Hash::get($data, 'Character.agility') + Hash::get($data, 'Character.correction_speed');
				}
			);

			$this->addAutoField(
				'maximum_speed',
				['Character.speed'],
				function ($data) {
					return Hash::get($data, 'Character.speed') * 3;
				}
			);

			$this->addAutoField(
				'protection_point',
				['Character.armor_protection_point', 'Character.shield_protection_point', 'Character.correction_protection_point'],
				$sum_character
			);

			$this->addAutoField(
				'evasion',
				['Character.armor_evasion', 'Character.shield_evasion', 'Character.evasion_skill_id', 'Character.agility_bonus', 'CharacterSkill.skill_id', 'CharacterSkill.level', 'Character.correction_evasion'],
				function ($data) {
					$skill_id = Hash::get($data, 'Character.evasion_skill_id');
					$level = Hash::extract($data, "CharacterSkill.{n}[skill_id=$skill_id].level");
					return ($skill_id ? (reset($level) + Hash::get($data, 'Character.agility_bonus')) : null) + Hash::get($data, 'Character.armor_evasion') + Hash::get($data, 'Character.shield_evasion') + Hash::get($data, 'Character.correction_evasion');
				}
			);

			$this->addAutoField(
				'rider_level',
				['CharacterSkill.level', 'CharacterSkill.skill_id'],
				function($data) {
					$levels = Hash::extract($data, 'CharacterSkill.{n}[skill_id=15].level');
					return (count($levels) == 1) ? reset($levels) : null;
				}
			);

			$this->addAutoField(
				'bard_standard_value',
				['CharacterSkill.level', 'CharacterSkill.skill_id', 'Character.spirit_bonus'],
				function($data) {
					$levels = Hash::extract($data, 'CharacterSkill.{n}[skill_id=14].level');
					return (count($levels) == 1) ? (reset($levels) + Hash::get($data, 'Character.spirit_bonus')) : null;
				}
			);

			$this->addAutoField(
				'bard_range',
				['CharacterSkill.level', 'CharacterSkill.skill_id'],
				function($data) {
					$levels = Hash::extract($data, 'CharacterSkill.{n}[skill_id=14].level');
					return (count($levels) == 1) ? (reset($levels) * 10) : null;
				}
			);

			$this->addAutoField(
				'alchemist_standard_value',
				['CharacterSkill.level', 'CharacterSkill.skill_id', 'Character.intelligence_bonus'],
				function($data) {
					$levels = Hash::extract($data, 'CharacterSkill.{n}[skill_id=16].level');
					return (count($levels) == 1) ? (reset($levels) + Hash::get($data, 'Character.intelligence_bonus')) : null;
				}
			);
		}

		/// Deprecated
		/*
		public function isOwner($id = null) {
			if (!$id) $id = $this->getID();
			$tmp = $this->recursive;
			$this->recursive = -1;
			$character = $this->findById($id, array('user_id'));
			$this->recursive = $tmp;
			return Hash::get($character, 'Character.user_id') == User::getLoginId();
		}
		*/

		public function isOwnedBy($id = null, $user_id) {
			if (!$id) $id = $this->getID();
			return $this->field('id', ['id' => $id, 'user_id' => $user_id]);
		}
		/*
		private static $correction_fields = array(
			'器用度' => 'dexterity',
			'敏捷度' => 'agility',
			'筋力' => 'strength',
			'生命力' => 'vital_power',
			'知力' => 'intelligence',
			'精神力' => 'spiritual_power',
			'魔力' => 'magic_power',
			'HP' => 'hp',
			'MP' => 'mp',
			'移動力' => 'speed',
			'制限移動' => 'limited_speed',
			'防護点' => 'protection',
			'回避力' => 'evasion',
			'魔物知識' => 'monster_lore',
			'魔物知識判定' => 'monster_lore',
			'先制' => 'initiative',
			'生命抵抗力' => 'fortitude',
			'精神抵抗力' => 'willpower',
			'経験点' => 'experience',
			'追加ダメージ' => 'extra_damage',
			'命中力' => 'accuracy',
		);


		private static $ornament_areas = array('head', 'face', 'ears', 'neck', 'back', 'left_hand', 'right_hand', 'waist', 'feet', 'other');
		*/
	}
