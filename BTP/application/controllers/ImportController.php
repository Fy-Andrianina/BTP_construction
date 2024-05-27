<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');
require_once APPPATH.'third_party/PHPExcel.php';
class ImportController extends SessionController {
    function __construct()
    {
        parent::__construct(); 
       $this->load->model("ImportModel");
    }
    public function index(){
        $data=array();
        $data['content']="import/import_maison_devis";
        $this->load->view("template",$data);
    }
    public function import_maison_devis(){
        $this->load->helper("my_file");
       
        if ($_FILES['fichier_maison_travaux'] == null && $_FILES['fichier_devis'] == null ) {
            echo "Impossible d'ouvrir le fichier.";
        } else {
            $file_path_maison_travaux = $_FILES['fichier_maison_travaux']['tmp_name']; // Get temporary file path
            // $contents_maison_travaux = read_content($file_path_maison_travaux);

            $file_path_devis=$_FILES['fichier_devis']['tmp_name']; 
            $ligne_maison_travaux=$this->develop($file_path_maison_travaux);
            $ligne_devis=$this->develop($file_path_devis);

            try{
                for ($i=1; $i <count($ligne_maison_travaux) ; $i++) { 
                    $array_maison_travaux=array(
                        "type_maison"=>$ligne_maison_travaux[$i][0],
                        "description"=>$ligne_maison_travaux[$i][1],
                        "surface"=>str_replace(",",".",$ligne_maison_travaux[$i][2]),
                        "code_travaux"=>$ligne_maison_travaux[$i][3],
                        "type_travaux"=>$ligne_maison_travaux[$i][4],
                        "unite"=>$ligne_maison_travaux[$i][5],
                        "prix_unitaire"=>str_replace(",",".",$ligne_maison_travaux[$i][6]),
                        "quantite"=>str_replace(",",".",$ligne_maison_travaux[$i][7]),
                        "duree_travaux"=>$ligne_maison_travaux[$i][8],
                        );
                $this->G->insert("temp_maison_travaux",$array_maison_travaux);
                }
                
                for ($i=1; $i <count($ligne_devis) ; $i++) { 

                    $array_devis=array(
                        "client_numero"=>$ligne_devis[$i][0],
                        "devis_client"=>$ligne_devis[$i][1],
                        "type_maison"=>$ligne_devis[$i][2],
                        "finition"=>$ligne_devis[$i][3],
                        "taux_finition"=>str_replace(array(",","%"),array(".",""),$ligne_devis[$i][4]),
                        "date_devis"=>$ligne_devis[$i][5],
                        "date_debut"=>$ligne_devis[$i][6],
                        "lieu"=>$ligne_devis[$i][7]
                    );
                $this->G->insert("temp_devis",$array_devis);
                }
                //check_erreur
                // $this->check_values_type_maison();
                // $this->check_values_devis();
                // if ($this->G->get_NB_Line("error_import")> 0) {
                //     $error=$this->G->getData_from_colonne("*","error_import");
                //     $this->initialiser_table_erreur("error_import");
                //     $this->initialiser_table("temp_devis_id_seq","temp_devis");
                //     $this->initialiser_table("temp_maison_travaux_id_seq","temp_maison_travaux");
                   
                //     $this->session->set_flashdata("erreur",$error);
                //     redirect('ImportController/sendErrorImport');
                //     } else {
                //           $this->insert_all_devis_maison_travaux();
                //     }
                //insertion des donnees
               $this->insert_all_devis_maison_travaux();
                
            } catch (\Exception $th) {
                echo  $th->getMessage();
            }
            redirect("importController/index");
        }
    }
    public function import_payement(){
        $this->load->helper("my_file");
       
        if ($_FILES['fichier_paiement'] == null) {
            echo "Impossible d'ouvrir le fichier.";
        } else {
            $file_path_paiement=$_FILES['fichier_paiement']['tmp_name']; 
            
            $ligne_paiement=$this->develop($file_path_paiement);

            try{
                for ($i=1; $i <count($ligne_paiement) ; $i++) { 
                    $array_paiement=array(
                        "devis_client"=>$ligne_paiement[$i][0],
                        "code_paiement"=>$ligne_paiement[$i][1],
                        "date_paiement"=>$ligne_paiement[$i][2],
                        "montant"=>str_replace(",",".",$ligne_paiement[$i][3])
                    );
                    $this->G->insert("temp_paiement",$array_paiement);
                }
                // check des erreurs
                // $this->check_values_payement();
                // if ($this->G->get_NB_Line("erreur_import_payement")> 0) {
                //     $error=$this->G->getData_from_colonne("*","erreur_import_payement");
                //     $this->initialiser_table_erreur("erreur_import_payement");
                //     $this->initialiser_table("temp_maison_travaux_id_seq","temp_paiement");
                //     $this->session->set_flashdata("erreur",$error);
                    // redirect('ImportController/sendErrorImport');
                // } else {
                   
                //      $this->insert_paiement();
                // }

                //insertion des donnees s'il y a pas d'erreur
                $this->insert_paiement();
            } catch (\Exception $th) {
                echo  $th->getMessage();
            }
            redirect("importController/index");
        }
    }
    //verifie la positivite des colonnes dnas une table
    public function check_Positive_column($colonne,$table,$erreur_table){
        
        $data=$this->G->get_Data_By_Columns(array('CAST('.$colonne.' as numeric )  <'=>0),$table);
        foreach($data as $d){
            $array=array("ligne"=>$d['id'],"type_erreur"=>$colonne." ne doit pas etre negative ou egale a 0");
            $this->G->insert($erreur_table,$array);
        }
    }
    public function check_Date_column($conditions,$table,$type_erreur,$erreur_table){
        $data=$this->G->get_Data_By_Columns($conditions,$table);
        foreach($data as $d){
            $array=array("ligne"=>$d['id'],"type_erreur"=>$type_erreur);
            $this->G->insert($array,$erreur_table);
        }
        
    }
    //qui initialise la table d'erreur
    public function initialiser_table_erreur($table_erreur){
        $this->ImportModel->initialiser_table_erreur($table_erreur);
    }
    //qui initialise la table d'erreur
    public function initialiser_table($nom_sequence,$table_erreur){
        $this->ImportModel->initialiser_table($nom_sequence,$table_erreur);
    }
    //verifie les donnees dnas temp_payement avant insertion
    public function check_values_payement(){
        $this->check_Positive_column("montant","temp_paiement","erreur_import_payement");
    }

    //verifie les donnees dnas temp_maison_travaux avant insertion
    public function check_values_type_maison(){
        $this->check_Positive_column("surface","temp_maison_travaux","error_import");
        $this->check_Positive_column("prix_unitaire","temp_maison_travaux","error_import");
        $this->check_Positive_column("quantite","temp_maison_travaux","error_import");
        $this->check_Positive_column("duree_travaux","temp_maison_travaux","error_import");
    }
    //verifie les donnees dnas temp_devis avant insertion
    public function check_values_devis(){
        $this->check_Positive_column("taux_finition","temp_devis","error_import");
    }
    
    public function sendErrorImport()
    {
        $Line_error=$this->session->flashdata("erreur");
        $data = array();
        $data['error'] = $Line_error;
        $data['content']="import/error_import";
        $this->load->view("template", $data);
    }
    public function develop($file_path){
        $objPHPExcel = PHPExcel_IOFactory::load($file_path);

            // Récupérer la première feuille de calcul
            $sheet = $objPHPExcel->getActiveSheet();
            
            $contenu_ligne=array();
            // Boucler sur les lignes
            foreach ($sheet->getRowIterator() as $row) {
                // Récupérer les cellules de chaque ligne
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $ligne=array();
                foreach ($cellIterator as $cell) {
                        $ligne[]=$cell->getValue();
                }
                $contenu_ligne[]=$ligne;
            }
            return $contenu_ligne;
    }
    public function insert_all_devis_maison_travaux(){
        try {
           $this->ImportModel->insert_all_devis_maison_travaux();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function insert_paiement(){
        $this->ImportModel->insert_Payement();
        
    }
}
?>