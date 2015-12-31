<?php
	class MistCastleBlockMapsController extends SwordWorld2AppController {
		public $helpers = array('InlineForm2.InlineForm2');
		public $components = array('RequestHandler', 'InlineForm2.InlineForm2');

		public function index() {
			$user_id = $this->Auth->user('id');
			$maps = $this->MistCastleBlockMap->find('all');
			$this->set(compact('maps'));
		}

		public function view($id = null) {
			if (!$id || !$this->MistCastleBlockMap->exists($id)) {
				throw new NotFoundException();
			}

			$user_id = $this->Auth->user('id');
			$map = $this->MistCastleBlockMap->find('first', [
			'conditions' => ['MistCastleBlockMap.id' => $id],
			]);
			$is_owned = $user_id == $map['MistCastleBlockMap']['user_id'];
			$this->set(compact('is_owned', 'map'));
			$this->set('_serialize', 'map');
		}

		public function add() {
			$user_id = $this->Auth->user('id');
			$this->MistCastleBlockMap->create();
			$this->MistCastleBlockMap->set('user_id', $user_id);
			$this->MistCastleBlockMap->save();
			return $this->redirect(['action' => 'view', $this->MistCastleBlockMap->getLastInsertID()]);
		}

		public function inlineform2() {
			return $this->InlineForm2->inlineform2($this);
		}
	}
