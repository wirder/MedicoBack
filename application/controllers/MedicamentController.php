<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedicamentController extends MY_Controller {

	public function __construct() {
    parent::__construct();

		$this->load->model('medicament_model', 'medicament');
  }

	public function searchMedicamentById($id) {

		$cis = $this->medicament->getCISbyMedicamentId($id);
		$medicament = $this->medicament->getMedicamentByCIS($cis->cis);
		krumo($medicament);
		return $medicament;

	}

	public function searchMedicamentByName($name) {

		$liste = $this->medicament->getMedicamentListByName($name);
		krumo($liste);
		return $liste;

	}

}
