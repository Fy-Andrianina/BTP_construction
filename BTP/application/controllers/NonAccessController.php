<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class NonAccessController extends SessionController
{
    public function index(){
        $data=array();
        $data['content']="errors/erreur_view";
        $this->load->view("template",$data);
    }
}
?>