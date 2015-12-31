<?php
	App::uses('User', 'Model');
	App::uses('AutoCalcModel', 'SwordWorld2.Model');
	class CharacterChildModel extends AutoCalcModel {
		public function isOwnedBy($id, $user_id) {
			if (!$id) $id = $this->getID();
			$tmp = $this->recursive;
			$this->recursive = 0;
			$data = $this->findById($id, ['Character.user_id']);
			$this->recursive = $tmp;
			return Hash::get($data, 'Character.user_id') == $user_id;
		}
	}
