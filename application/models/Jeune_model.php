<?php
class Jeune_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->library('session');
                $this->load->helper('date');
        }

        public function savoiretre()
        {
                $this->db->select('nom');
                $query = $this->db->get('savoir_etre');
                return $query->result();
        }
        public function creationReferences()
        {
                $this->load->library('linkGenerator');
                $lien = $this->linkgenerator->create(40,"reference.lien_validation");
                $tab = $this->session->userdata('logged_in');
                $reference = array(
                        'id_user' => $tab['id'] ,
                        'description' => set_value('description'),
                        'duree' => set_value('duree') , 
                        'etat' => 1, 
                        'nom' => set_value('nom') , 
                        'prenom' => set_value('prenom'), 
                        'mail' => set_value('mail'),
                        'lien_validation'=> $lien);
                $this->db->insert('reference', $reference);
                $dashboard = array(
                        'id_user' => $tab['id'],
                        'type' => '2',
                        'date' => date('Y-m-d'),
                        'id_ref' => $this->db->insert_id());
                $this->db->insert('dashboard', $dashboard);
                $nombre =  count($this->input->post('savoirEtre'));
                $lastID=$this->db->insert_id();
                for($i=0;$i<$nombre;$i++){
                        $savoir = array(
                        'id_ref'=>$lastID,
                        'id_savoir_etre'=>set_value('savoirEtre[]'));
                        $this->db->insert('savoir_etre_user',$savoir);
                }
        }

        public function creadash() {
                $sql = 'SELECT date, type FROM dashboard WHERE id_user = ? ORDER BY date DESC';
                $id_user = $this->session->userdata('logged_in')['id'];
                $query = $this->db->query($sql, array($id_user));
                $tab = $query->result_array();
                return $tab;
        }
} 
?>