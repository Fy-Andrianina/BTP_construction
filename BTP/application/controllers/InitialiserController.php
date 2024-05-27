<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class InitialiserController extends CI_Controller {

    function __construct()
    {
        parent::__construct();  
        $this->load->model('InitModel');

        // if($this->session->has_userdata('user') == true){
        //     $users=$this->session->has_userdata('user');
        //     echo var_dump($users);
        //     if(!isset($users[0]['admin']))
        //     {
        //         redirect(site_url('NonAccessController'));
        //     }
        // }
    } 
    public function index(){
        $chemin_fichier_bat = FCPATH .'./assets/sql/run_sql.bat';
       
        $fichier_sql=FCPATH .'./assets/sql/initialise.sql';
        // echo $chemin_fichier_bat;
        // Exécute le fichier .bat
        exec($chemin_fichier_bat." ".$fichier_sql, $output, $return_var);
        // echo var_dump($output);
        // Vérifie si l'exécution a réussi
        if ($return_var === 0) {
            echo "Le fichier .bat a été exécuté avec succès.";
            redirect(site_url("DashboardController"));
        } else {
            echo "Une erreur s'est produite lors de l'exécution du fichier .bat.";
        }
    }
    public function init(){
        $fichier_sql=FCPATH .'./assets/sql/init.sql';
        $debut_sql=FCPATH .'./assets/sql/no_foreign.sql';
        $fin_sql=FCPATH .'./assets/sql/yes_foreign.sql';

        $sql = file_get_contents($fichier_sql);
        $sql_debut = file_get_contents($debut_sql);
        $sql_fin = file_get_contents($fin_sql);
        
       $this->InitModel->init($sql_debut);
       $this->InitModel->init_separatly($sql);
       $this->InitModel->init($sql_fin);
       redirect(site_url().'Welcome');
    }

} ?>