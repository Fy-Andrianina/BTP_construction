<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class FinitionController extends SessionController {
    function __construct()
    {
        parent::__construct(); 
        // if($this->session->has_userdata('user') == true){
        // $users=$this->session->has_userdata('user');
        // echo var_dump($users);
        // if(!isset($users[0]['admin']))
        //     {
        //         redirect(site_url('NonAccessController'));
        //     }
        // }
    }
    public function index(){
        $data=array();
        $data['content']="finition/liste_finition";
    //   echo var_dump($users);
        $this->load->library("pagination");
        $this->load->helper("my_config");
        $config = array();
        $config["base_url"] = base_url() . "FinitionController/index";
        $config["total_rows"] = $this->G->get_Nb_Line("finition");
        $config["per_page"] = 5; // Nombre de lignes par page

        array_push($config, get_config_pagination()); //ajout des autres configurations

        // Initialiser la pagination
        $this->pagination->initialize($config);

        // Récupérer les données de la base de données pour affichage
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["data"] = $this->G->getData_Pagination("finition", $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();


        $this->load->view("template", $data);
    }
    public function update_form(){
        $data=array();
        $data['content']="finition/form_update";
        
        $type_finition = $this->G->get_Data_By_Columns(array("idfinition"=>$this->input->get("idfinition")),"finition");
        // echo var_dump($type_finition);
        $data['type_finition']=$type_finition[0];
        $this->load->view("template", $data);
    }
    public function process_update(){
        $data=array();
        $data['content']="finition/form_update";
        
        $type_finition = $this->G->get_Data_By_Columns(array("idfinition"=>$this->input->post("idfinition")),"finition");
        $data['type_finition']=$type_finition[0];
        $data['default_pourcentage']=$this->input->post("pourcentage");
    
        if($data['default_pourcentage']!=null){
            
            if($data['default_pourcentage']<0){
                $data['error'] = "Le pourcentage doit etre de valeur positive et non 0 ou negative";
            }else{
                $array=array(
                    "pourcentage"=>(float)($data['default_pourcentage'])
                );
                // echo var_dump($type_finition);
                try{
                    $this->G->update_data("finition",$array,array("idfinition"=>$type_finition[0]['idfinition']));

                }catch(Exception $e){
                    $data['error']=$e->getMessage();
                }
                redirect(site_url()."FinitionController/index");
            }
        }
        else{
            $data['error']="Veiller completer le champs pourcentage";
        }
        $this->load->view("template", $data);
    }

}
?>