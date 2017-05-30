<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicament_model extends CI_Model {

  private $table = 'specialites s';

  public function getCISbyMedicamentId($id) {

    if ( isset($id) )
      $this->db->where('id', $id);

    $this->db->select('cis');
    $this->db->from($this->table);
    $query = $this->db->get();

    if ( $query->num_rows() > 0 ) {
      return $query->row();
    }

    return FALSE;

  }

  public function getMedicamentListByName($name) {

    if ( isset($name) )
      $this->db->like('denomination_medicament', $name);

    $this->db->select('*');
    $this->db->from($this->table);
    $query = $this->db->get();

    if ( $query->num_rows() > 0 ) {
      return $query->result();
    }

    return FALSE;

  }

  public function getMedicamentByCIS($cis) {

    if ( isset($cis) )
      $this->db->where('s.cis', $cis);

    $this->db->select('s.cis as cis_medicament, s.*, p.*, i.*, g.*, d.*, cond.*, compo.*, smr.*, asmr.*, ct.*');
    $this->db->from($this->table);
    $this->db->join('presentations p', 's.cis = p.cis', 'left');
    $this->db->join('informations i', 's.cis = i.cis', 'left');
    $this->db->join('groupes_generiques g', 's.cis = g.cis', 'left');
    $this->db->join('definitions_alternatives d', 's.cis = d.cis', 'left');
    $this->db->join('conditions cond', 's.cis = cond.cis', 'left');
    $this->db->join('compositions compo', 's.cis = compo.cis', 'left');
    $this->db->join('avis_smr smr', 's.cis = smr.cis', 'left');
    $this->db->join('avis_asmr asmr', 's.cis = asmr.cis', 'left');
    $this->db->join('avis_ct ct', 'asmr.code_has = ct.code_has', 'left');
    $query = $this->db->get();

    if ( $query->num_rows() > 0 ) {
      return $query->row();
    }

    return FALSE;

  }

    public function addDefinitionAlternative($data) {
        $this->db->insert('definitions_alternatives',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function voteDefinitionAlternative($datas) {
        $sql = $this->db->insert_string('votes_definitions_alternatives', $datas) . ' ON DUPLICATE KEY UPDATE vote=VALUES(vote)';

        $this->db->query($sql);

        return array('status' => 201,'message' => 'Data has been updated.');
    }

    public function getSymptomesCategories() {

      $this->db->select('*');
      $this->db->from('symptomes_categories');
      $query = $this->db->get();

      if ( $query->num_rows() > 0 ) {
        return $query->result();
      }

      return FALSE;

    }

    public function getSymptomesByCategorie($id) {

      if ( isset($id) )
        $this->db->where('id_categorie', $id);

      $this->db->select('*');
      $this->db->from('symptomes');
      $query = $this->db->get();

      if ( $query->num_rows() > 0 ) {
        return $query->result();
      }

      return FALSE;

    }

    public function getMedicamentsBySymptome($id) {

      if ( isset($id) )
        $this->db->where('id_symptome', $id);

      $this->db->select('symp.cis, s.id, s.denomination_medicament');
      $this->db->from('symptomes_cis symp');
      $this->db->join('specialites s', 'symp.cis = s.cis', 'left');
      // $this->db->limit(25);
      $query = $this->db->get();

      if ( $query->num_rows() > 0 ) {
        return $query->result();
      }

      return FALSE;

    }

    public function getSymptomeById($id) {

      if ( isset($id) )
        $this->db->where('id', $id);


      $this->db->select('*');
      $this->db->from('symptomes');
      $query = $this->db->get();

      if ( $query->num_rows() > 0 ) {
        return $query->row();
      }

      return FALSE;

    }

    public function getMedicamentListeByLaboratoireName($name) {

      if ( isset($name) )
        $this->db->like('laboratoire', $name);

      $this->db->select('*');
      $this->db->from($this->table);
      $query = $this->db->get();

      if ( $query->num_rows() > 0 ) {
        return $query->result();
      }

      return FALSE;

    }

}
