<?php
	class CampaignsController extends SwordWorld2AppController {
		public $helpers = ['InlineForm.InlineForm'];
		public $components = ['InlineForm.InlineForm', 'RequestHandler'];
		public function index() {
			$list = $this->Campaign->find('all', array(
				'fields' => array(
					'id',
					'name',
					'GameMaster.name',
					'modified',
				),
				'order' => array('modified' => 'desc'),
			));

			$this->set(compact('list'));
		}

		public function add() {
			$this->Campaign->create();
			$this->Campaign->save(['Campaign' => ['gamemaster_id' => $this->Auth->user('id')]]);
			return $this->redirect(['action' => 'view', $this->Campaign->id]);
		}

		public function view($id = null) {
			$data = $this->Campaign->findById($id);
			if (!$data) throw new NotFoundException;

			$is_owned = Hash::get($data, 'Campaign.gamemaster_id') == $this->Auth->user('id');

			$this->set(compact('data', 'is_owned'));
		}

		public function inlineform() {
			$this->InlineForm->inlineform($this);
		}

		public function recalculate($id = null) {
			$this->Campaign->id = $id;

			if (!$this->Campaign->exists($id)) {
				throw new NotFoundException;
			}

			$data = $this->Campaign->find('first', [
			'conditions' => ['Campaign.id' => $id],
			'recursive' => 2
			]);
			$this->Campaign->save($data);

			return $this->redirect(['action' => 'view', $id]);
		}
	}
