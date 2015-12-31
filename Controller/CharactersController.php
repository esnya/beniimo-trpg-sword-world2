<?php
	class CharactersController extends SwordWorld2AppController {
		public $uses = ['SwordWorld2.Character', 'SwordWorld2.SampleCharacter'];
		public $helpers = array('InlineForm.InlineForm', 'RealtimeForm.RealtimeForm', 'AjaxImage.AjaxImage', 'InlineForm2.InlineForm2');
		public $components = array('RequestHandler', 'InlineForm.InlineForm', 'AjaxImage.AjaxImage', 'RealtimeForm.RealtimeForm', 'InlineForm2.InlineForm2');

        public function beforeFilter() {
            $this->Auth->allow('index', 'summary', 'image');
        }

		public function index() {
			$user_id = $this->Auth->user('id');
			$characters = $this->Character->find('all', array(
				'fields' => array(
					'id',
					'name',
					'User.name',
					'Race.name',
					'nationality',
					'adventurer_level',
					'modified',
				),
				'conditions' => [
				'or' => [
				'Character.user_id' => $user_id,
				'not' => ['Character.is_private'],
				'Character.is_private' => null,
				],
				],
				'order' => array('modified' => 'desc'),
			));

			$this->set(compact('characters'));
		}

        public function view_old($id = null) {
            return $this->view($id);
        }

        public function summary($id = null) {
            if (!$id || !$this->Character->exists($id)) {
                throw new NotFoundException();
            }

			$user_id = $this->Auth->user('id');
			$character = $this->Character->find('first', array(
                'conditions' => [
                    'Character.id' => $id,
                    'or' => [
                        'Character.user_id' => $user_id,
                        'not' => ['Character.is_private'],
                        'Character.is_private' => null,
                    ],
                ],
                'fields' => [
                    'Character.id',
                    'Character.name',
                    'Character.user_id',
                    'Character.hp',
                    'Character.mp',
                    'Character.image_mime',
                ],
                'recursive' => -1,
			));

			if (!$character) {
				throw new NotFoundException();
			}

            $this->set('character', [
                'id' => Hash::get($character, 'Character.id'),
                'name' => Hash::get($character, 'Character.name'),
                'url' => Router::url(['action' => 'view', Hash::get($character, 'Character.id')]),
                'portrait' => Hash::get($character, 'Character.image_mime') ? Router::url(['action' => 'image', Hash::get($character, 'Character.id')]) : null,
                'parameters' => [
                    'hp' => Hash::get($character, 'Character.hp'),
                    'mp' => Hash::get($character, 'Character.mp'),
                ],
            ]);
            $this->set('_serialize', 'character');
        }

		public function view($id = null) {
			if (!$id || !$this->Character->exists($id)) {
				throw new NotFoundException();
			}

			$user_id = $this->Auth->user('id');
			$character = $this->Character->find('first', array(
				'conditions' => [
				'Character.id' => $id,
				'or' => [
				'Character.user_id' => $user_id,
				'not' => ['Character.is_private'],
				'Character.is_private' => null,
				],
				],
				'recursive' => 2,
			));

			if (!$character) {
				throw new NotFoundException();
			}

			$is_owned = $user_id == $character['Character']['user_id'];
			$campaigns = $this->Character->Campaign->find('list');
			$races = $this->Character->Race->find('list');
			$skills = $this->Character->CharacterSkill->Skill->find('list');
			$combat_skills = $this->Character->CharacterSkill->Skill->find('list', [
			'fields' => ['id', 'name'],
			'conditions' => [
			'or' => [
			'skill_type' => 0,
			'id' => 13,
			],
			],
			'recursive' => -1,
			]);

			$this->set('title_for_layout', __('%s - Sword World 2.0 Characters -', Hash::get($character, 'Character.name')));

			$this->set(compact('character', 'is_owned', 'campaigns', 'races', 'sexes', 'skills', 'combat_skills'));
			$this->set('_serialize', 'character');
		}

		public function delete($id = null) {
			if (!$this->request->is('POST')) {
					throw new ForbiddenException;
			}

			$this->Character->id = $id;
			if (!$this->Character->exists()) {
				throw new NotFoundException;
			}

			if (!$this->Character->isOwnedBy($id, $this->Auth->user('id'))) {
				throw new ForbiddenException;
			}

			if (!$this->Character->delete()) {
				throw new InternalServerError;
			}

			return $this->redirect(array('action' => 'index'));
		}

		public function add() {
			$this->Character->save(array('Character' => array('user_id' => User::getLoginId())));
			return $this->redirect(array('action' => 'view', $this->Character->id));
		}

		public function inlineform() {
			return $this->InlineForm->inlineform($this);
		}

		public function inlineform2() {
			return $this->InlineForm2->inlineform2($this);
		}

		public function image($id = null) {
			if (!$this->Character->exists($id)) {
				throw new NotFoundException;
			}

			if ($this->request->is('post')) {
				$this->AjaxImage->save_image($this, $id, 'Character.image');
			} else {
				$this->layout = 'ajax';
				$image = $this->Character->find('first', [
				'conditions' => [
				'id' => $id,
				'NOT' => [ 'OR' => [['image_data' => null], ['image_mime' => null]]],
				],
				'fields' => ['image_data', 'image_mime'],
				'recursive' => -1,
				]);

				if (empty($image)) {
					throw new NotFoundException;
				}

				header('Content-type: ' . Hash::get($image, 'Character.image_mime'));
				echo Hash::get($image, 'Character.image_data');
			}
		}

		public function recalculate($id = null) {
			$this->Character->id = $id;

			if (!$this->Character->exists($id)) {
				throw new NotFoundException;
			}

			$data = $this->Character->find('first', [
			'conditions' => ['Character.id' => $id],
			'recursive' => 0
			]);
			$this->Character->save($data);

			foreach (['CharacterSkill', 'CharacterWaepon'] as $modelName) {
				$data = $this->Character->{$modelName}->find('all', [
				'conditions' => ['character_id' => $id],
				'recursive' => -1
				]);
				foreach ($data as $tmp) {
					$this->Character->{$modelName}->save($tmp);
				}
			}

			return $this->redirect(['action' => 'view', $id]);
		}

		public function sample($id = null) {
			$this->SampleCharacter->recursive = 2;

			if ($id) {
				$sample_character = $this->SampleCharacter->findById($id);
			} else {
				$sample_character = null;
			}

			if ($sample_character) {
				$this->Character->create();
				$this->Character->save(
					['Character' => Hash::insert(
						Hash::remove(
							Hash::extract($sample_character, 'SampleCharacter'),
							'id'
						),
						'user_id',
						$this->Auth->user('id')
					)
					]
				);
				$character_id = $this->Character->getID();

				foreach ([
				'SampleCharacterSkill' => 'CharacterSkill',
				'SampleCharacterWaepon' => 'CharacterWaepon',
				'SampleCharacterCombatFeat' => 'CombatFeat',
				'SampleCharacterLanguage' => 'CharacterLanguage',
				'SampleCharacterBardAbility' => 'CharacterBardAbility',
				'SampleCharacterRiderAbility' => 'CharacterRiderAbility',
				'SampleCharacterEnhancerAbility' => 'CharacterEnhancerAbility',
				'SampleCharacterAlchemistAbility' => 'CharacterAlchemistAbility',
				] as $from => $to) {
					foreach ($sample_character[$from] as $item) {
						$this->Character->{$to}->create();
						$item['character_id'] = $character_id;
						$this->Character->{$to}->save([$to => $item]);
					}
				}
				return $this->redirect(['action' => 'recalculate', $character_id]);
			} else {
				$sample_characters = $this->SampleCharacter->find('all');

				$title_for_layout = __('Create a new character from sample characters');
				$this->set(compact('title_for_layout', 'sample_characters'));
			}
		}
	}
