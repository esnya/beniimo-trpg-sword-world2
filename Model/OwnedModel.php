<?php
	class OwnedModel extends SwordWorld2AppModel {
		public function isOwnedBy($id, $user_id) {
			return $this->field('id', [($this->name . '.id') => $id, 'user_id' => $user_id]) !== false;
		}
	}
