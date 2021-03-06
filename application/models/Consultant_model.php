<?php

/**
 * Class Consultant_model
 */
class Consultant_model extends CI_Model {

  /**
   * Consultant_model constructor.
   */
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
  }
  /**
   * Vérifie si la clé présent dans l'url appartient à un groupement
   *
   * @param string $lien Clé de l'url
   * @return object Retourne l'ensemble des groupements contenant la clé
   */
  public function verifLien($lien){
    $tabLienGroupement = $this->db->get_where('groupement', array('lien_consultation' => $lien));
    return $tabLienGroupement->result();
  }

  /**
   * Permet de récuperer l'ensemble les informations des références appartenant au groupement
   *
   * @param array $tabRefGroupement Tableau contenant l'ensemble des informations du groupement
   * @return object Retourne l'ensemble des références appartenant au groupement
   */
  public function recupRef($tabRefGroupement){
    $acc=[];
    for ($i=0; $i <count($tabRefGroupement) ; $i++) {
       array_push($acc,$tabRefGroupement[$i]->id_ref);
    }
    $this->db->where_in('id', $acc);
    $this->db->from('reference');
    $toto = $this->db->get();
    return $toto->result();
  }

  /**
   * Permet de récuperer l'ensemble des id des savoir-être appartenant aux références au sein du groupement 
   *
   * @param array $tabRefGroupement Tableau contenant l'ensemble des informations du groupement
   * @return array Retourne l'ensemble des id des savoir-être
   */
  public function recupIdRef($tabRefGroupement){
    $tabId=[];
    for ($i=0; $i <count($tabRefGroupement) ; $i++) {
        $tabId[$i]=$tabRefGroupement[$i]->id_ref;
    }
    return $tabId;
  }
        
  /**
   * Permet de récuperer les informations sur le jeune
   *
   * @param array $ref Tableau contenant l'ensemble des références appartenant au groupement
   * @return object Retourne l'ensemble des informations sur le jeune
   */
  public function informationJeune($ref){
    $idJeune = $ref[0]->id_user;
    $infoJeune = $this->db->get_where('jeune', array('id' => $idJeune));
    return $infoJeune->result();
  }
} 
