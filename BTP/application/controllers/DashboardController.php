<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class DashboardController extends SessionController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('DashBoardModel');
        date_default_timezone_set('Europe/Moscow');

        // if($this->session->has_userdata('user') == true){
        //     $users=$this->session->has_userdata('user');
        //     echo var_dump($users);
        //     if(!isset($users[0]['admin']))
        //     {
        //         redirect(site_url('NonAccessController'));
        //     }
        // }
    }
    public function index()
    {
        $data=array();
        $data['content']="dashboard/dash";
        $data['total_devis']=$this->DashBoardModel->get_montant_devis();
        $data['total_payement']=$this->DashBoardModel->get_montant_payement();
        $data['annee']=2024;
        if($this->input->post('annee')!=null){
            $data['annee']=$this->input->post('annee');
            $data['data']=$this->DashBoardModel->get_montant_devis_par_mois($this->input->post('annee'));
        }else{
            $data['data']=$this->DashBoardModel->get_montant_devis_par_mois(2024);
        }
        
        $this->load->view("template",$data);
    }
}
    ?>