<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'controllers/SessionController.php');

class DevisController extends SessionController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('DevisModel');
        date_default_timezone_set('Europe/Moscow');
    }
    public function index()
    {
        $data = array();
        $data['content'] = "devis/liste_devis";
        $user = $this->session->userdata("user");

        $this->load->library("pagination");
        $this->load->helper("my_config");
        $config = array();
        $config["base_url"] = base_url() . "DevisController";
        $config["total_rows"] = $this->G->get_Nb_Line("v_payement_etat_devis");
        $config["per_page"] = 10; // Nombre de lignes par page

        array_push($config, get_config_pagination()); //ajout des autres configurations

        // Initialiser la pagination
        $this->pagination->initialize($config);

        // Récupérer les données de la base de données pour affichage
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient']));
        $data["links"] = $this->pagination->create_links();


        $this->load->view("template", $data);
    }
    public function create_devis()
    {
        $this->load->library("form_validation");

        if ($this->form_validation->run('devis') === FALSE) {
            $data['type_maisons'] = $this->G->getData_from_colonnes("*", "v_devis_maison_montant");
            $data['type_finitions'] = $this->G->getData_from_colonnes("*", "finition");
            $data['lieux'] = $this->G->getData_from_colonnes("*", "lieu");

            $data['content'] = "devis/creation_devis";
            $this->load->view("template", $data);
        } 
    }
    
    public function form_creation_devis(){
            
                $type_maison = $this->input->post("type_maison");
                $type_finition = $this->input->post("type_finition");
                $date_debut = $this->input->post("date_debut");
                $idlieu = $this->input->post("idlieu");

                $date = $this->input->post("date");
                if (!empty($type_maison) && !empty($type_finition) && !empty($date_debut) && !empty($date)) {
                    $devis_maison = $this->G->get_Data_By_Columns(array("idtype_maison" => $type_maison),"devis_maison");
                    $iddevis_maison=$devis_maison[0]['iddevis_maison'];
                    $users=$this->session->userdata("user");
                    $user=$users[0];
                    $date_debut_obj = new DateTime($date_debut);
                    $date_obj = new DateTime($date);
                  
                    // Comparer les dates
                    if ($date_debut_obj < $date_obj) {
                        // La date de début est antérieure à la date
                        $data=array();
                        $data['type_maisons'] = $this->G->getData_from_colonnes("*", "v_devis_maison_montant");
                        $data['type_finitions'] = $this->G->getData_from_colonnes("*", "finition");
                        $data['lieux'] = $this->G->getData_from_colonnes("*", "lieu");
                        
                        $data['default_finition']=$type_maison;
                        $data['default_date_debut']=$date_debut;
                        $data['default_date']=$date;
                        $data['default_maison']=$type_maison;
                        $data['default_lieu']=$idlieu;
                        $data['error'] = "La date de début de construction ne doit pas etre antérieure à la date de creation du devis";
                        $data['content'] = "devis/creation_devis";
                        $this->load->view("template", $data);
                    }else{
                    // insertion dans la table devis_client
                        $data = array(
                            "idclient"=>$user['idclient'],
                            "iddevis_maison" => $iddevis_maison,
                            "idfinition" => $type_finition,
                            "date_debut" => $date_debut,
                            "date" => $date,
                            "idlieu"=>$idlieu
                        );

                        $this->G->insert("devis_client", $data);
                        $iddevis_client = $this->G->get_Last_line();
                        $this->DevisModel->update_other_data($iddevis_client,$type_finition,$iddevis_maison);//update des colonne(montant_sans_finition,duree,pourcentage_finition)
                        $this->DevisModel->update_montant_finition($iddevis_client);//update de la colonne montant avec finition
                        $this->DevisModel->update_date_finition($iddevis_client);//update de la colonne date_fin par rapport uax duree de la finition
                        $this->DevisModel->insert_detail_devis_client($iddevis_maison,$iddevis_client);//insertion des details du devis
                        redirect(site_url()."DevisController");
                    }
                }else{
                    $data_error=array();
                   
                    $data_error['type_maisons'] = $this->G->getData_from_colonnes("*", "v_devis_maison_montant");
                    $data_error['type_finitions'] = $this->G->getData_from_colonnes("*", "finition");
                    $data_error['lieux'] = $this->G->getData_from_colonnes("*", "lieu");

                    $data_error['error'] = "Complter tous les champs";
                    $data_error['content'] = "devis/creation_devis";
                    $this->load->view("template", $data_error);
                }
    }
    public function unpayed_devis(){
        $data = array();
        $data['content'] = "devis/liste_devis";
        $user = $this->session->userdata("user");

        $this->load->library("pagination");
        $this->load->helper("my_config");
        $config = array();
        $config["base_url"] = base_url() . "DevisController";
        $config["total_rows"] = $this->G->get_Nb_Line("v_payement_etat_devis");
        $config["per_page"] = 10; // Nombre de lignes par page

        array_push($config, get_config_pagination()); //ajout des autres configurations

        // Initialiser la pagination
        $this->pagination->initialize($config);

        // Récupérer les données de la base de données pour affichage
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient'],"reste_a_payer !="=>0));
        $data["links"] = $this->pagination->create_links();


        $this->load->view("template", $data);
    }

    public function ExportPDF()
    {
        $this->load->library("tcpdf");
        $pdf = new TCPDF();
        $pdf->AddPage();
        $iddevis_client = $this->input->get("iddevis_client");

        $data = $this->G->get_Data_By_Columns(array("iddevis_client" => $iddevis_client), "v_detail_devis_travaux");
        $devis_client = $this->G->get_Data_By_Columns(array("iddevis_client" => $iddevis_client), "devis_client");
        $montant_avec_finition = $devis_client[0]['montant_avec_finition'];
        $montant_sans_finition = $devis_client[0]['montant_sans_finition'];
        $data_paye=$this->DevisModel->get_Payement_ByDevisClient($iddevis_client);
        $montant_paye=$this->DevisModel->get_paye_total_devis($iddevis_client);
        $html = '<h3>Devis</h3>';
        $html .= '<p>Les details de votre devis : </p>';
        $html .= '
            <table border="1">
                <thead>
                    <tr>
                        
                        <th>Designation</th>
                        <th>Unite</th>
                        <th>Quantite</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($data as $d) {
            $html .= '
                            <tr>
                                
                                <td style="text-align:left;font-size:11px">' . $d['nom_type_travaux'] . '</td>
                                <td >' . $d['abbreviation'] . '</td>
                                <td >' . $d['quantite'] . '</td>
                                <td >' .number_format($d['prix_unitaire'], 0, ',', ' ') . '</td>
                                <td>' . number_format($d['montant'], 0, ',', ' ') . '</td>
                                </tr>';
        }
        $html .= '
                            <tr>
                            <td colspan="4" style="text-align:end"> <b>Montant avec finition</b></td>
                            <td>' . number_format($montant_avec_finition, 0, ',', ' ') . '</td>
                          
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:end"><b>Montant sans finition</b></td>
                                <td>' . number_format($montant_sans_finition, 0, ',', ' ') . '</td>
                            </tr>';
        $html .= '</tbody></table>
        <h1>Paiement</h1>
        <table border="1">
                <thead>
                    <tr>
                        
                        <th>Date</th>
                        <th>Montant</th>
                    
                    </tr>
                </thead>
                </tbody>';
        foreach ($data_paye as $d) {
            $html .= '
                            <tr>
                                
                                <td style="text-align:left;font-size:11px">' . $d['date'] . '</td>
                                <td>' . number_format($d['montant'], 0, ',', ' ') . '</td>
                                </tr>';
        }
        $html .= '
        <tr>
        <td style="text-align:end"> <b>Montant total payer</b></td>
        <td>' . number_format($montant_paye, 0, ',', ' ') . '</td></tr>
                            </tbody>
                        </table>
                <style>
                td{
                    margin:20px;
                    text-align:center;
                }
                table{
                    border:collapse;
                }
                </style>
            ';

        $pdf->writeHTML($html, true, false, true, false, '');

        $file = 'devis_detail';
        $pdf->Output($file, 'D');
        $pdfFilePath = FCPATH . 'assets/pdf/' . $file . '.pdf';
        $pdf->Output($pdfFilePath, 'F');
        $pdf->Output($pdfFilePath, 'D');
        redirect(site_url() . "DevisController");
    }
    // public function get_between_price_client(){
    //     $min=$this->input->post("min");
    //     $max=$this->input->post("max");

    //     if($min!=null && $max!=null){
    //         if($min==null && $max !=null){
    //             $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient'],
    //                                                                                                                             "montant_avec_finition <="=>$max));

    //         }else if($min!=null && $max ==null){
    //             $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient'],
    //                                                                                                                             "montant_avec_finition >= "=>$min));

    //         }else($min!=null && $max !=null){
    //             $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient'],
    //                                                                                                                             "montant_avec_finition >= "=> $min,"montant_avec_finition <= "=> $max));
    //         }
    //     }else{
    //         $data['error']="Veiller completer au moins un champs";
    //         $data["data"] = $this->G->getData_Pagination_by_column("v_payement_etat_devis", $config["per_page"], $page, array("idclient" => $user[0]['idclient']));
    //     }
    // }

}
?>