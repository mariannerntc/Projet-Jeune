<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function index(){
    $this->load->helper('url');
    //$data['title'] = 'Bienvenue';

    $this->load->view('home/index');
  }
  
  public function accueil(){
    $data['title'] = 'Accueil';

    $this->load->view('templates/head', $data);
    $this->load->view('home/accueil', $data);
    $this->load->view('templates/foot', $data);
  }
}