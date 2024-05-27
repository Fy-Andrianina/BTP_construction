<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class DashBoardModel extends CI_Model{
    public function get_montant_devis(){
        $sql="select sum(devis_client.montant_avec_finition) as montant from devis_client";
        $query=$this->db->query($sql);
        $res=$query->row();
        return $res->montant;
    }
    public function get_montant_payement(){
        $sql="select sum(v_payement_etat_devis.montant_paye) as montant from v_payement_etat_devis";
        $query=$this->db->query($sql);
        $res=$query->row();
        return $res->montant;
    }
    public function get_montant_devis_par_mois($annee){
        $this->load->helper("my_query");
        $sql="SELECT SUM(devis_client.montant_avec_finition) AS montant, EXTRACT(MONTH FROM devis_client.date) AS mois
        FROM devis_client
        WHERE EXTRACT(YEAR FROM devis_client.date) = $annee
        GROUP BY mois";

        return fetch_array($this->db->query($sql));
        
    }
 }
 ?>