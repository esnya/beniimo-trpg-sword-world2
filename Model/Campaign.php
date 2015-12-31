<?php
	App::uses('AutoFieldModel', 'SwordWorld2.Model');
	class Campaign extends AutoFieldModel {
		public $belongsTo = [
			'GameMaster' => [
				'className' => 'User',
				'foreignKey' => 'gamemaster_id',
			],
		];

		public $hasMany = [
			'SwordWorld2.SwordWorldSession',
			'SwordWorld2.Character',
		];

		public function __construct() {
			parent::__construct();

			$this->addAutoField(
				'experience_points',
				['SwordWorldSession.base_experience_points', 'SwordWorldSession.additional_experience_points'],
				function ($data) {
					return 3000 + array_sum(Hash::extract($data, 'SwordWorldSession.{n}.base_experience_points')) + array_sum(Hash::extract($data, 'SwordWorldSession.{n}.additional_experience_points'));
				}
			);

			$this->addAutoField(
				'honors',
				['SwordWorldSession.honors'],
				function ($data) {
					return array_sum(Hash::extract($data, 'SwordWorldSession.{n}.honors'));
				}
			);

			$this->addAutoField(
				'growth_count',
				['SwordWorldSession.growth_count'],
				function ($data) {
					return array_sum(Hash::extract($data, 'SwordWorldSession.{n}.growth_count'));
				}
			);
		}

		/*
		public function update() {
			$id = $this->getID();

			if ($id) {
				$sessions = $this->SwordWorldSession->find('all', [
						'conditions' => ['campaign_id' => $id], 
						'fields' => [
							'SwordWorldSession.base_experience_points',
							'SwordWorldSession.additional_experience_points',
							'SwordWorldSession.growth_count',
							'SwordWorldSession.honors',
						],
						'recursive' => -1,
					]);

				$newData = [
					'experience_points' => 3000,
					'growth_count' => 0,
					'honors' => 0,
				];

				foreach ($sessions as $session) {
					$newData['experience_points'] += Hash::get($session, 'SwordWorldSession.base_experience_points') + Hash::get($session, 'SwordWorldSession.additional_experience_points');
					$newData['growth_count'] += Hash::get($session, 'SwordWorldSession.growth_count');
					$newData['honors'] += Hash::get($session, 'SwordWorldSession.honors');
				}

				$newData['id'] = $id;

				$this->save(['Campaign' => $newData]);
			}
		}
		*/

		/*
		public function afterSave($created, $options = []) {
			if (Hash::get($this->data, 'Campaign.experience_points')) {
				$id = $this->getID();
				$characters = $this->Character->find('all', [
						'conditions' => [
							'Character.campaign_id' => $id,
						],
						'fields' => [
							'Character.id',
						],
						'recursive' => -1
					]);
				foreach ($characters as $character) {
					$this->Character->startUpdate();
					$this->Character->id = Hash::get($character, 'Character.id');
					$this->Character->updateExperiencePoints();
					$this->Character->endUpdate();
				}
			}
		}
		*/
	}
