<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends MY_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('Medicament_model', 'medicament');
  }

	public function index() {

    // $this->data['hello'] = 'Hello world!';
		$this->load->view('index', $this->data);

	}

  public function initCategoriesSymptomes() {

    $categories = $this->medicament->getSymptomesCategories();
    return json_output(200, $categories);

  }

  public function searchSymptomesByCategorie($id) {

    $symptomes = $this->medicament->getSymptomesByCategorie($id);
    return json_output(200, $symptomes);

  }

  public function searchMedicamentsBySymptome($id) {

    $medicaments = $this->medicament->getMedicamentsBySymptome($id);
    return json_output(200, $medicaments);

  }

}
