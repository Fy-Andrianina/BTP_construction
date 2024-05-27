<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class TravauxController extends SessionController {
    function __construct()
    {
        parent::__construct(); 
        // if($this->session->has_userdata('user') == true){
        // $users=$this->session->has_userdata('user');
        // echo var_dump($users);
        // if(!isset($users[0]['admin']))
        //     {
        //         redirect(site_url('NonAccessController'));
        // }
        // }
    }
    public function index(){
        $data=array();
        $data['content']="travaux/liste_type_travaux";
    //   echo var_dump($users);
        $this->load->library("pagination");
        $this->load->helper("my_config");
        $config = array();
        $config["base_url"] = base_url() . "TravauxController/index";
        $config["total_rows"] = $this->G->get_Nb_Line("v_type_travaux");
        $config["per_page"] = 5; // Nombre de lignes par page

        array_push($config, get_config_pagination()); //ajout des autres configurations

        // Initialiser la pagination
        $this->pagination->initialize($config);

        // Récupérer les données de la base de données pour affichage
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["data"] = $this->G->getData_Pagination("v_type_travaux", $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();


        $this->load->view("template", $data);
    }
    public function update_form(){
        $data=array();
        $data['content']="travaux/form_update";
        $data['unites']=$this->G->getData_from_colonne("*","unite");
        $type_travaux = $this->G->get_Data_By_Columns(array("idtype_travaux"=>$this->input->get("idtype_travaux")),"v_type_travaux");
        $data['type_travaux']=$type_travaux[0];
        $this->load->view("template", $data);
    }
    public function process_update(){
        $data=array();
        $data['content']="travaux/form_update";
        $data['unites']=$this->G->getData_from_colonne("*","unite");
        $type_travaux = $this->G->get_Data_By_Columns(array("idtype_travaux"=>$this->input->post("idtype_travaux")),"v_type_travaux");
        $data['type_travaux']=$type_travaux[0];

        $data['default_unite']=$this->input->post("unite");
        $data['default_prix']=$this->input->post("prix_unitaire");
        $data['default_nom']=$this->input->post("nom_type_travaux");
        
        if(!empty($data['default_unite']) && !empty($data['default_prix']) && !empty($data['default_nom'])){
            $data['default_nom']=trim($data['default_nom']);
            if($data['default_prix']<=0){
                $data['error'] = "Le prix_unitaire doit etre de valeur positive et non 0 ou negative";
            }else{
                $array=array(
                    "prix_unitaire"=>(float)$data['default_prix'],
                    "idunite"=>$data['default_unite'],
                    "nom_type_travaux"=>$data['default_nom']
                );
                // echo var_dump($type_travaux);
                try{
                    $this->G->update_data("type_travaux",$array,array("idtype_travaux"=>$type_travaux[0]['idtype_travaux']));

                }catch(Exception $e){
                    $data['error']=$e->getMessage();
                }
                redirect(site_url()."TravauxController/index");
            }
        }
        else{
            $data['error']="Veiller completer toutes les champs";
        }
        $this->load->view("template", $data);
    }

}
?>