<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class UtilisateurModel extends CI_Model{
    public function check_login($email,$pass)
    {
        $request="SELECT * from utilisateur where email ='%s' and password='%s'";
        // echo $pass;
        $request=sprintf($request,$email,$pass);
        // echo $request;
        echo $request;
        $tab = $this->db->query($request);
        if($tab != null){
            // echo json_encode($tab);
            return $tab->result_array();
        }
        return False;
    }
    public function check($email,$pass){
        $query = $this->db->get_where('utilisateur', array('email' => $email));

        // Récupération du résultat
        $result = $query->row();
        if ($result) {
            // Vérification du mot de passe
            if (password_verify($pass, $result->password)) {
                return $query->result_array();
            } else {
                // Mot de passe invalide
                return False;

            }
        }
    }
    public function check_numero($numero){
        $query = $this->db->get_where('client', array('numero' => $numero));

        // Récupération du résultat
        $result = $query->row();
        if (empty($result)) {
                $this->insert_client($numero);
                $query = $this->db->get_where('client', array('numero' => $numero));
                return $query->result_array();
           
        }else{
            return $query->result_array();
        }
    }
    public function insert_client($numero){
        $colonne=array("numero"=>$numero);
        $this->db->insert("client",$colonne);
    }

    public function idUsed($email){
        $query = $this->db->get_where('utilisateur', array('email' => $email));

        // Récupération du résultat
        $result = $query->row();
        if (empty($result)) {
           
        }
    }
    public function insert_new_user($nom,$prenom,$email,$password,$sexe,$date_naissance){
        $sql="INSERT INTO utilisateur( nom, prenom, sexe, email, password,dtn ) VALUES ('%s', '%s', %u, '%s', '%s','%s')";
        $sql=sprintf($sql,$nom,$prenom,$sexe,$email,$password,$date_naissance);
        $this->db->query($sql);
    }
 }
?>