<?php
	class AutoFieldModel extends SwordWorld2AppModel {
		private $autoFields = [];

		public function addAutoField($name, $depends, $callback) {
			$depends0 = [];
			$depends1 = [];

			$assoc0 = array_merge($this->getAssociated('belongsTo'), $this->getAssociated('hasOne'));
			$assoc1 = $this->getAssociated('hasMany');
			foreach ($depends as $depend) {
				$path = explode('.', $depend);

				$field = end($path);
				$model = (count($path) == 2) ? reset($path) : $this->name;

				$depend = $model . '.' . $field;

				if (
					$model == $this->name || array_search($model, $assoc0) !== false
				) {
					$depends0[] = $depend;
				} else if (array_search($model, $assoc1) !== false) {
					if (!array_key_exists($model, $depends1)) {
						$depends1[] = [];
					}
					$depends1[$model][] = $depend;
				}
			}

			$this->autoFields[] = [
			'name' => $name,
			'depends0' => $depends0,
			'depends1' => $depends1,
			'callback' => $callback,
			'need_update' => false,
			];
		}

		private $autoFieldsData;
		public function startUpdate() {
			$this->autoFieldsData = [];
			foreach ($this->autoFields as &$autoField) {
				$autoField['need_update'] = false;
			}
		}

		public function checkUpdate(array $data, $senderModelName = null, $delete = false) {
			$update = false;
			$assoc1 = $this->getAssociated('hasMany');
			foreach ($this->autoFields as &$autoField) {
				$depends = ($senderModelName && array_key_exists($senderModelName, $autoField['depends1'])) ? $autoField['depends1'][$senderModelName] : $autoField['depends0'];
				foreach ($depends as $depend) {
					if (explode('.', $depend)[0] == $delete || Hash::check($data, $depend)) {
						$autoField['need_update'] = true;
						$update = true;
						break;
					}
				}
			}

			return $update;
		}

		public function compute($data, $delete = false) {
			$id = $this->getID();

			foreach ($this->autoFields as $autoField) {
				$values = [];

				$unsetDepends0 = [];
				foreach ($autoField['depends0'] as $depend) {
					if (Hash::check($data, $depend)){
						$values[$depend] = Hash::get($data, $depend);
					} else if (is_array($this->data) && Hash::check($this->data, $depend)) {
						$values[$depend] = Hash::get($this->data, $depend);
					} else {
						$unsetDepends0[] = $depend;
					}
				}

				if (!empty($unsetDepends0)) {
					$data = $this->find('first', [
					'conditions' => [
					($this->name . '.id') => $id,
					],
					'fields' => $unsetDepends0,
					'recursive' => 0,
					]);

					foreach ($unsetDepends0 as $depend) {
						$values[$depend] = Hash::get($data, $depend);
					}
				}

				foreach ($autoField['depends1'] as $modelName => $depends) {
					if (!is_string($modelName) || empty($depends)) continue;
					$model = $this->{$modelName};
					$data = $this->{$modelName}->find('all', [
					'conditions' => [
					($modelName . '.' . Inflector::underscore($this->name) . '_id') => $id,
					],
					'fields' => $depends,
					'recursive' => 0,
					]);

					$values[$modelName] = Hash::extract($data, '{n}.' . $modelName);
				}

				$this->set($autoField['name'], call_user_func($autoField['callback'], Hash::expand($values)));
			}
		}

		public function endUpdate() {
		}

		public function update(array $data = [], array &$options = [], $senderModelName = null, $delete = false) {
			if (is_array($data) && $this->checkRecursive($options)) {
				$this->startUpdate();
				if (!$this->checkUpdate($data, $senderModelName, $delete)) {
					return false;
				}
				$this->compute($data, $delete);
				$this->endUpdate();

				return true;
			} else {
				return false;
			}
		}

		private function checkRecursive(&$options) {
			$name = $this->name;

			if (!array_key_exists('autoFieldModel', $options)) {
				$options['autoFieldModel'] = [];
			} else if (array_search($name, $options['autoFieldModel']) !== false) {
				return false;
			}

			$options['autoFieldModel'][] = $name;

			return true;
		}

		public function beforeSave($options = []) {
			if (parent::beforeSave($options)) {
				$this->update($this->data, $options);
				return true;
			} else {
				return false;
			}
		}

		private function updateRecursive($id, array $data, $options = []) {
			$name = $this->name;

			$delete = Hash::get($options, 'delete') ? $name : false;

			foreach (array_merge($this->getAssociated('belongsTo'), $this->getAssociated('hasOne')) as $modelName) {
				$model = $this->{$modelName};
				if ($model instanceof AutoFieldModel) {
					$fieldName = Inflector::underscore($modelName . 'Id');
					$model->id = ($delete) ? Hash::get($data, "$name.$fieldName") : $this->field($fieldName);
					if ($model->id && $model->update($data, $options, $name, $delete) && $model->exists()) {
						$model->save(null, ['autoFieldModel' => Hash::extract($options, 'autoFieldModel')]);
					}
				}
			}

			foreach ($this->getAssociated('hasMany') as $modelName) {
				$model = $this->{$modelName};

				if ($model instanceof AutoFieldModel) {
					$className = explode('.', Hash::get($this->hasMany, "$modelName.className"));
					if (end($className) != $modelName) continue;

					$foreignKey = Hash::get($this->hasMany, "$modelName.foreignKey");
					$list = $model->find('all', [
					'conditions' => [$foreignKey => $id],
					'fields' => ['id'],
					'recursive' => -1,
					]);

					foreach (Hash::extract($list, '{n}.' . $modelName . '.id') as $childId) {
						$model->id = $childId;
						if ($model->update($data, $options, $name) && $model->exists()) {
							$model->save(null, ['autoFieldModel' => Hash::extract($options, 'autoFieldModel')]);
						}
					}
				}
			}
		}

		public function afterSave($created, $options = []) {
			parent::afterSave($created, $options);

			$models = Hash::extract($options, 'autoFieldModel');
			$models[] = $this->name;
			$options['autoFieldModel'] = $models;

			$this->updateRecursive($this->getID(), $this->data, $options);
		}

		private $deletedId;
		private $deletedData;
		public function beforeDelete($cascade = true, $options = []) {
			if (parent::beforeDelete($cascade, $options)) {
				$this->deletedId = $this->getID();
				$this->read();
				$this->deletedData = $this->data;
				return true;
			} else {
				return false;
			}
		}

		public function afterDelete() {
			$this->updateRecursive($this->deletedId, $this->data, ['delete' => true]);
		}
	}
