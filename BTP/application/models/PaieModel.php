<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class PaieModel extends CI_Model{
    public function insert_payement($date,$montant,$devis_client){
        
            try {
                $sql="insert into payement_devis(date,montant,iddevis_client) values('%s',%d,%d)";
                $sql=sprintf($sql,$date,$montant,$devis_client);
                $this->db->query($sql);
                return true; // Retourner true si l'insertion réussit
            } catch (Exception $e) {
                // Une erreur s'est produite lors de l'insertion, lancer une exception avec un message d'erreur
                throw new Exception("Erreur lors de l'insertion des données : " . $e->getMessage());
            }
        }
        
    }
 
 ?>