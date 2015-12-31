<?php
	class SampleCharactersController extends SwordWorld2AppController {
		public $helpers = array('InlineForm.InlineForm');
		public $components = array('RequestHandler', 'InlineForm.InlineForm', );

		public function index() {
			$this->SampleCharacter->recursive = 0;
			$sample_characters = $this->SampleCharacter->find('all');

			$this->set(compact('sample_characters'));
			$this->set('_serialize', 'sample_characters');
		}

		public function view($id = null) {
			$this->SampleCharacter->recursive = 1;

			$sample_character = $this->SampleCharacter->findById($id);
			if (!$sample_character) {
				throw new NotFoundException;
			}

			$races = $this->SampleCharacter->Race->find('list');
			$skills = $this->SampleCharacter->SampleCharacterSkill->Skill->find('list');
			$combat_skills = $this->SampleCharacter->SampleCharacterSkill->Skill->find('list', [
			'conditions' => [
			'or' => [
			'skill_type' => 0,
			'id' => 13,
			],
			],
			'recursive' => -1,
		]);

			$this->set(compact('sample_character', 'races', 'skills', 'combat_skills'));
			$this->set('_serialize', 'sample_character');
		}

		public function add() {
			$this->SampleCharacter->create();
			$this->SampleCharacter->save();
			return $this->redirect(['action' => 'view', $this->SampleCharacter->getID()]);
		}

		public function inlineform() {
			return $this->InlineForm->inlineform($this);
		}
	}


