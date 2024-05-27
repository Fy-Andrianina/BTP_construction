<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class PayeController extends SessionController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('PaieModel');
        date_default_timezone_set('Europe/Moscow');
    }
    public function index()
    {
        $data=array();
        $data['content']="paye/form_paye_back";
        $data['iddevis_client']=$this->input->get("iddevis_client");
        $this->load->view("template",$data);
    }
   

    public function process_payment(){
        $data['default_montant']=$this->input->post("montant");
        $data['default_date']=$this->input->post("date");
        $data['iddevis_client']=$this->input->post("iddevis_client");

        $data['content']="DevisController/unpayed_devis";

        if(!empty($data['default_montant']) && !empty($data['default_date'])){
            $devis_payements=$this->G->get_Data_By_Columns(array("iddevis_client"=>$this->input->post("iddevis_client")),"v_payement_etat_devis");
            $devis_payement=$devis_payements[0];

            $date_creation_devis=new DateTime($devis_payement['date']);
            $date_payement=new DateTime($data['default_date']);

            if($date_payement < $date_creation_devis){
                
               $data['error'] = "La date de début de construction ne doit pas être antérieure à la date de création du devis qui est ".$devis_payement['date'];
                echo json_encode(array('error_message' =>$data['error']));
            }else{
                if($data['default_montant']<=0){
                
                    $data['error'] = "Le montant doit etre de valeur positive et non 0 ou negative";
                   echo json_encode(array('error_message' => $data['error']));
                    
                }else{
                    $montant=0;
                    if($data['default_montant'] > $devis_payement['reste_a_payer']){
                        $montant_temp= $data['default_montant'] - $devis_payement['reste_a_payer'];
                        $data['error']="Votre montant est trop excedant de ".$montant_temp;
                      echo  json_encode(array('error_message' => $data['error']));

                    }else if($data['default_montant'] <= $devis_payement['reste_a_payer']){
                        // echo json_encode($data['default_montant']);
                        $montant= (float)$data['default_montant'];
                        try{
                            $this->PaieModel->insert_payement($data['default_date'],$montant,$devis_payement['iddevis_client']);
                            echo json_encode(array('redirect' => $data['content']));

                        }catch (Exception $e) {
                                // Une erreur s'est produite lors de l'insertion, lancer une exception avec un message d'erreur
                                $data['error']= $e->getMessage();
                              echo json_encode(array('error_message' => $e->getMessage()));
    
                        }
                    }
                    
                }
            }

        }else{
            $data['error']="Veiller completer toutes les champs";
            echo json_encode(array('error_message' => $data['error']));

        }
        // echo json_encode(['redirect' => $url ]);
        // echo json_encode(['redirect' => $data['content']]);
    }

    public function etat_paye(){
        $users=$this->session->userdata("user");
        if(isset($users[0]['admin'])){
            $data = array();
            $data['content'] = "paye/etat_payement";
            $user = $this->session->userdata("user");

            $this->load->library("pagination");
            $this->load->helper("my_config");
            $config = array();
            $config["base_url"] = base_url() . "PayeController/etat_paye";
            $config["total_rows"] = $this->G->get_Nb_Line("v_payement_etat_devis");
            $config["per_page"] = 10; // Nombre de lignes par page

            array_push($config, get_config_pagination()); //ajout des autres configurations

            // Initialiser la pagination
            $this->pagination->initialize($config);

            // Récupérer les données de la base de données pour affichage
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            // $date_actuelle = date('Y-m-d');
            $data["data"] = $this->G->getData_Pagination("v_payement_etat_devis", $config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();

            $this->load->view("template", $data);
        }else{
            $data['content'] = "welcome_message";
            
            $this->load->view("template", $data);
        }
    }
    public function detail_devis(){
        $users=$this->session->userdata("user");
        // $iddevis_client = $this->input->get("iddevis_client");
        $url=explode("/",urldecode($this->input->get('iddevis_client')));
        $iddevis_client = $url[0];
        $iddevis_client_encoded = urlencode($iddevis_client);
        // echo $iddevis_client_encoded;
// $config["base_url"] = base_url() . "PayeController/detail_devis?iddevis_client=".$iddevis_client_encoded;
        if(isset($users[0]['admin'])){
            $data = array();
            $data['content'] = "devis/detail_devis";
            $user = $this->session->userdata("user");

            $this->load->library("pagination");
            $this->load->helper("my_config");
            $config = array();
            $config["base_url"] = base_url() . "PayeController/detail_devis?iddevis_client=".$iddevis_client_encoded;
            $config["total_rows"] = $this->G->get_Nb_Line("v_detail_devis_travaux");
            $config["per_page"] = 10; // Nombre de lignes par page

            array_push($config, get_config_pagination()); //ajout des autres configurations

            // Initialiser la pagination
            $this->pagination->initialize($config);

            // Récupérer les données de la base de données pour affichage
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            
            $data['data'] = $this->G->getData_Pagination_by_column("v_detail_devis_travaux", $config["per_page"], $page, array("iddevis_client" => $iddevis_client));
            $devis_client = $this->G->get_Data_By_Columns(array("iddevis_client" => $iddevis_client), "devis_client");
            $data['devis_client']=$devis_client;
            $data["links"] = $this->pagination->create_links();

            $this->load->view("template", $data);
           
           
        }
        else{
            $data['content'] = "welcome_message";
            $this->load->view("template", $data);
        }
    }
}
?>