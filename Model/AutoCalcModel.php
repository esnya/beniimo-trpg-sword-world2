<?php
	class AutoCalcModel extends SwordWorld2AppModel {
		public $rules = [];

		public function addRule($field, $depends, $function) {
			$this->rules[] = [
			$field,
			$depends,
			$function,
			false
			];
		}

		public function beforeSave($options = []) {
			$id = Hash::get($this->data, $this->name . '.id');

			$updateRules = [];
			$readFields = [];
			foreach (Hash::extract($this->data, $this->name) as $field => $value) {
				foreach ($this->rules as $key => $rule) {
					if ($rule[3] == false && array_search($this->name . '.' . $field, $rule[1]) !== FALSE) {
						$this->rules[$key][3] = true;
						$readFields = array_merge($readFields, $rule[1]);
					}
				}
			}

			if (!empty($readFields)) {
				$this->save(null, ['callbacks' => false]);
				$id = $this->id;
				$this->read(array_unique($readFields), $id);

				foreach ($this->rules as $rule) {
					if ($rule[3]) {
						$values = [];
						foreach ($rule[1] as $depend) {
							$value = Hash::get($this->data, $depend);
							$values[] = $value;
						}
						$this->data = Hash::insert($this->data, $rule[0], $rule[2]($values));
					}
				}
			}

			return true;
		}

	}
