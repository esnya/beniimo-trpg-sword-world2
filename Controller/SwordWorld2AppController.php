<?php

App::uses('AppController', 'Controller');

class SwordWorld2AppController extends AppController {
	public function beforeFilter() {
		$this->set('copyright', 'Copyright &copy; 2014 GROUP SNE, ukatama. All Rights Reserved');
	}
}
