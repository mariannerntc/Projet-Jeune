<?php

/**
 * Class Jeune_model
 */
class Jeune_model extends CI_Model {

  /**
   * Jeune_model constructor.
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->helper('date');
  }

  /**
   * Créer une référence à partir des informations rentrée par l'utilisateur
   *
   * @return void
   */
  public function creationReferences()
  {
    $this->load->library('linkGenerator');
    $lien = $this->linkgenerator->create(40,"reference.lien_validation");
    $tab = $this->session->userdata('logged_in');
    $this->lang->load('date_lang');
    $duree = $this->input->post('duree');
    $type_duree = 'date_' . $this->input->post('duree_type');
    if($duree > 1)
      $type_duree .= 's';
    $duree .= ' ' .$this->lang->line($type_duree);
    $reference = array(
      'id_user' => $tab['id'] ,
      'description' => $this->input->post('description'),
      'duree' => $duree ,
      'etat' => 1,
      'nom' => $this->input->post('nom') ,
      'prenom' => $this->input->post('prenom'),
      'mail' => $this->input->post('mail'),
      'lien_validation'=> $lien);
    $this->db->insert('reference', $reference);

    $nombre =  count($this->input->post('savoirEtre'));
    $lastID=$this->db->insert_id();

    for($i=0;$i<$nombre;$i++){
      $savoir = array(
      'id_ref'=>$lastID,
      'id_savoir_etre'=>set_value('savoirEtre[]'));
      $this->db->insert('savoir_etre_user',$savoir);
    }

    $this->addRefToDashboard($lastID, $tab['id']); 
    $this->emailReferent($lien, set_value('nom'), set_value('prenom'), set_value('mail'));
  }

  /**
   * Envoie un mail au référent pour l'informer de la création de la référence
   * de l'utilisateur connecté et lui demandé de confirmer la référence
   *
   * @param string $lien le lien pour confirmer la référence
   * @param string $nomRef le nom du référent
   * @param string $prenomRef le prénom du référent
   * @param string $mail le mail du référent
   * @return void
   */
  public function emailReferent($lien, $nomRef, $prenomRef, $mail){
    $sql = 'SELECT nom, prenom FROM jeune WHERE id = ?';
    $user = $this->session->userdata('logged_in');
    $res = $this->db->query($sql, [$user['id']])->row();
    $nom = $res->nom;
    $prenom = $res->prenom;
    mail($mail, 'Jeune 6.4 - Demande de référence',"Bonjour $prenomRef $nomRef,\n
    $prenom $nom a fait une demande de référence sur le site de Jeune 6.4 et vous a renseigné en tant que référent. Pour que sa référence soit validée vous devez cliquer sur ce lien " . site_url("/referent/validation/$lien") . " . \n
Cordialement,
L'équipe de Jeune 6.4");
  }
  
  /**
   * Ajoute une reference dans le dashboard
   *
   * @param int $id l'id de la référence
   * @param string $user l'id de l'utilisateur
   * @return void
   */
  public function addRefToDashboard($id, $user){
    $this->addEntryToDashboard(2, $user, $id);
  }

  /**
   * Ajoute un groupement dans le dashboard
   *
   * @param string $lien lien de consultation
   * @param int $user l'id de l'utilisateur
   * @return void
   */
  public function addGrpToDashboard($lien, $user){
    $this->addEntryToDashboard(4, $user, $lien);
  }

  /**
   * Ajoute une référence validée
   *
   * @param array $ref Info sur la référence contenant l'id de l'utilisateur
   * ainsi que l'id de la référence
   */
  public function addRefvalidateToDashboard($ref){
    $idUser=$ref['id_user'];
    $idRef=$ref['id'];
    $this->addEntryToDashboard(3, $idUser, $idRef); 
  }

  /**
   * Ajoute une inscription dans le dashboard
   *
   * @param int $id l'id du jeune
   */
  public function addInscriptionToDashboard($id){
    $this->addEntryToDashboard(1, $id, NULL);
  }

  /**
   * Ajoute un évènement dans le dashboard
   *
   * @param int $type le type d'entrée
   * @param int $user id du jeune
   * @param string|NULL $opt option possibles
   */
  private function addEntryToDashboard($type, $user, $opt){
    $dashboard = array(
      'id_user' => $user,
      'type' => $type,
      'options' => $opt
    );
    $this->db->insert('dashboard', $dashboard);
  }

  /**
   * Crée le dashboard du jeune
   *
   * @return array tableau avec tous les évènements du jeune
   */
  public function creadash() {
    $sql = 'SELECT `date`, `type`, `options` FROM dashboard WHERE `id_user` = ? ORDER BY date DESC';
    $id_user = $this->session->userdata('logged_in')['id'];
    $query = $this->db->query($sql, array($id_user));
    $tab = $query->result_array();
    return $tab;
  }
} 
?>
