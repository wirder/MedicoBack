<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedicamentController extends MY_Controller {

	public function __construct() {
    parent::__construct();

		$this->load->model('medicament_model', 'medicament');
  }

	public function searchMedicamentById($id) {

		$cis = $this->medicament->getCISbyMedicamentId($id);
		$this->searchMedicamentByCIS($cis);

	}

	public function searchMedicamentByName($name) {

		$liste = $this->medicament->getMedicamentListByName($name);
		return json_output(200, $liste);
<<<<<<< HEAD

	}

	public function searchMedicamentByCIS($cis) {

		$medicament = $this->medicament->getMedicamentByCIS($cis->cis);
		return json_output(200, $medicament);

	}

	public function searchMedicamentsBySymptome($id) {

		$medicamentListeBySymptome = $this->medicament->getMedicamentsBySymptome($id);
		return json_output(200, $medicamentListeBySymptome);

	}

	public function searchSymptomeById($id) {

		$symptome = $this->medicament->getSymptomeById($id);
		return json_output(200, $symptome);

	}

	public function searchMedicamentsByLaboratoireName($name) {

		$medicamentListeByLaboratoireName = $this->medicament->getMedicamentListeByLaboratoireName($name);
		return json_output(200, $medicamentListeByLaboratoireName);
=======

	}

	public function searchMedicamentByCIS($cis) {

		$medicament = $this->medicament->getMedicamentByCIS($cis->cis);
		return json_output(200, $medicament);
>>>>>>> origin/master

	}

	public function addDefinitionAlternative() {

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $params = json_decode(file_get_contents('php://input'), TRUE);

            $cis = (int)$params['cis'];
            $id_user = (int)$params['id_user'];
            $definition = $params['definition'];

            $data = [
                'cis' => $cis,
                'id_user' => $id_user,
                'definition_alternative' => $definition
            ];

            $resp = $this->medicament->addDefinitionAlternative($data);
            json_output(200,$resp);
        }

    }

    public function voteDefinitionAlternative() {

        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'PUT'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $params = json_decode(file_get_contents('php://input'), TRUE);

            $id_definition_alternative = (int)$params['id_definition_alternative'];
            $vote = (int)$params['vote'];

            if (in_array($vote, [-1,1])) {
                $datas = [
                    'id_definition_alternative' => $id_definition_alternative,
                    'id_user' => 1,
                    'vote' => $vote
                ];

                $resp = $this->medicament->voteDefinitionAlternative($datas);
                json_output(200, $resp);
            } else {
                json_output(403, array('status' => 403, 'message' => 'Invalid vote value.'));
            }
        }

    }

}
