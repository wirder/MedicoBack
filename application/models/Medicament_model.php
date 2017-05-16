<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicament_model extends CI_Model {

  private $table = 'specialites s';

  public function getCISbyMedicamentId($id) {

    if ( !is_null($id) )
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

    if ( !is_null($name) )
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

    if ( !is_null($cis) )
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

}
