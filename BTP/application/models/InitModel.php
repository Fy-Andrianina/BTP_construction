<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class InitModel extends CI_Model{
    public function init($sql){
        $this->db->query($sql);
    }
    public function init_separatly($sql){
        $instructions = explode(";", $sql);

        // Exécuter chaque instruction séparément
        foreach ($instructions as $instruction) {
            $trimmedInstruction = trim($instruction);
            if (!empty($trimmedInstruction)) {
                echo $trimmedInstruction;
                $this->db->query($instruction);
            }
        }
        
    }
 } ?>