<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class DevisModel extends CI_Model{
    public function get_Payement_ByDevisClient($id_devis_client){
        $sql="Select p.montant,p.date
        from payement_devis p
        where p.iddevis_client=$id_devis_client
        ORDER by p.date desc";
        $query=$this->db->query($sql);
        return fetch_array($query);
    }
    public function get_paye_total_devis($id_devis_client){
        $sql="Select sum(p.montant) as montant
        from payement_devis p
        where p.iddevis_client=$id_devis_client";
        $query=$this->db->query($sql);
        $row= $query->row();
        return $row->montant;
    }
    public function update_other_data($devis_client,$finition,$devis_maison){
        $sql="UPDATE devis_client set 
                montant_sans_finition=
                    (SELECT v_devis_maison_montant.montant from v_devis_maison_montant where v_devis_maison_montant.iddevis_maison=$devis_maison),
                duree=
                    (SELECT devis_maison.duree from devis_maison where devis_maison.iddevis_maison=$devis_maison),
                pourcentage_finition=
                (SELECT finition.pourcentage from finition where finition.idfinition=$finition)
            where devis_client.iddevis_client=$devis_client";
        $this->db->query($sql);
    }
    public function update_montant_finition($devis_client){
        $sql="UPDATE devis_client set
        montant_avec_finition=
            (SELECT ((devis_client.montant_sans_finition*devis_client.pourcentage_finition)/100)+devis_client.montant_sans_finition 
            from devis_client where devis_client.iddevis_client=$devis_client)
            where devis_client.iddevis_client=$devis_client";
        $this->db->query($sql);
    }
    public function update_date_finition($devis_client){
        $sql="UPDATE devis_client
        SET date_fin = (
            SELECT (devis_client.date_debut+ devis_client.duree * INTERVAL '1 DAY')
            FROM devis_client
            WHERE devis_client.iddevis_client = $devis_client
        )
        WHERE devis_client.iddevis_client = $devis_client";
        $this->db->query($sql);

    }
    public function insert_detail_devis_client($devis_maison,$devis_client){
        $sql="INSERT into detail_devis_client(iddevis_client,idtype_travaux, quantite,montant,prix_unitaire,nom_type_travaux)
        SELECT $devis_client,v_detail_travaux.idtype_travaux,v_detail_travaux.quantite,v_detail_travaux.montant,v_detail_travaux.prix_unitaire,v_detail_travaux.nom_type_travaux
        from v_detail_travaux where v_detail_travaux.iddevis_maison=$devis_maison";
        $this->db->query($sql);
    }
 }
 
 ?>