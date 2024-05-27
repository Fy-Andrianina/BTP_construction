<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class GeneralisedModel extends CI_Model{
    public function get_Nb_Line($table){
        $nb = $this->db->count_all($table);
        return $nb;
      }
      public function getData_from_colonne($colonne,$table){
        $this->load->helper("my_query");
        $this->db->select($colonne);
        $query=$this->db->get($table);
        $result = fetch_array($query);
        return $result;
      }
      public function getData_from_colonnes($colonnes,$table){
        $this->load->helper("my_query");
        $this->db->select($colonnes);
        $query=$this->db->get($table);
        $result = fetch_array($query);
        return $result;
      }
      //prends les donnees avec les limites et debut
      public function getData_Pagination($table,$limit,$start){
        $this->load->helper("my_query");

        $this->db->limit($limit, $start);
        $query = $this->db->get($table);
        $result = fetch_array($query);

        return $result;
      }
      //prends les donnees avec les limites et debut
      public function getData_Pagination_by_column($table,$start,$limit,$colonnes){
        $this->load->helper("my_query");
        $this->db->where($colonnes);
        $this->db->limit($limit, $start);
        $query = $this->db->get($table);
        $result = fetch_array($query);

        return $result;
      }
      //condition sur une colonne
      public function get_Data_By_Column($column,$value,$table){
        $this->load->helper("my_query");
            $query=$this->db->where($column,$value)->get($table);
            $result = fetch_array($query);
        return $result;
      }
      //condition sur plusieurs colonnes
      public function get_Data_By_Columns($columns,$table){
        // $columns= array(
        //     'colonne1' => 'valeur1',
        //     'colonne2' => 'valeur2',
        //     'colonne3' => 'valeur3'
        // );
        // $where = array(
        //     'colonne1' => 'valeur1',
        //     'colonne2 >=' => 10, // Exemple de condition numérique (colonne2 doit être supérieure ou égale à 10)
        //     'colonne3 <=' => 100, // Exemple de condition numérique (colonne3 doit être inférieure ou égale à 100)
        //     'date_colonne >=' => '2024-01-01', // Exemple de condition pour une date (date_colonne doit être supérieure ou égale à '2024-01-01')
        //     'date_colonne <=' => '2024-12-31' // Exemple de condition pour une date (date_colonne doit être inférieure ou égale à '2024-12-31')
        // );
        $this->load->helper("my_query");
            $query=$this->db->where($columns)->get($table);
            $result = fetch_array($query);
        return $result;
      }
      public function global_search($table,$value,$colonne){
        $this->load->helper("my_query");

            $sql = "SELECT * FROM $table where $colonne like '%$value%'";
            $query =$this->db->query($sql);
            $result = fetch_array($query);

        return $result;
      }

    // delete les lignes selon les conditions des colonnes wheres
    public function delete_data($table, $where)
    {
        // $where = array(
        //     'colonne1' => 'valeur1',
        //     'colonne2 >=' => 10,
        //     'colonne3 <=' => 100
        // );

        $this->db->where($where);
        $this->db->delete($table);
        
        return $this->db->affected_rows();
    }
        
      // update les lignes selon les conditions des colonnes wheres
      public function update_data($table, $data, $where)
    {
        // $data = array(
        //     'colonne1' => 'nouvelle_valeur1',
        //     'colonne2' => 'nouvelle_valeur2',
        //     'colonne3' => 'nouvelle_valeur3'
        // );
        // $where = array(
        //     'colonne1' => 'valeur1',
        //     'colonne2 >=' => 10,
        //     'colonne3 <=' => 100
        // );
        $this->db->where($where);
        $this->db->update($table, $data);
        
        return $this->db->affected_rows();
    }
    public function insert($table,$data){
      $this->db->insert($table,$data);
    }
    public function get_Last_line(){
      return $this->db->insert_id();
    }

    


 }
 ?>