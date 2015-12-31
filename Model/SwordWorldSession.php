<?php
	App::uses('AutoFieldModel', 'SwordWorld2.Model');
	class SwordWorldSession extends AutoFieldModel {
		public $belongsTo = ['SwordWorld2.Campaign'];
		public function beforeSave($options = []) {
			if (parent::beforeSave($options)) {
				if (Hash::get($this->data, $this->name . '.start_date') == null) {
					$this->data[$this->name]['start_date'] = date('Y-m-d');
				}
				if (Hash::get($this->data, $this->name . '.end_date') == null) {
					$this->data[$this->name]['end_date'] = $this->data[$this->name]['start_date'];
				}

				return true;
			} else {
				return false;
			}
		}
	}
