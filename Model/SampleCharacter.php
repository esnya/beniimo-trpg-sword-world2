<?php
	class SampleCharacter extends SwordWorld2AppModel {
		public $belongsTo = [
		'SwordWorld2.Race',
		];

		public $hasMany = [
		'SwordWorld2.SampleCharacterSkill',
		'SwordWorld2.SampleCharacterLanguage',
		'SwordWorld2.SampleCharacterWaepon',
		'SwordWorld2.SampleCharacterCombatFeat',
		'SwordWorld2.SampleCharacterAlchemistAbility',
		'SwordWorld2.SampleCharacterBardAbility',
		'SwordWorld2.SampleCharacterEnhancerAbility',
		'SwordWorld2.SampleCharacterRiderAbility',
		];
	}
