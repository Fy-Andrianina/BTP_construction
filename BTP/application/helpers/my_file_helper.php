<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
function read_content($file_path) {
    $lignes = array();

    try {
        // Ouvrir le fichier en mode lecture avec l'encodage UTF-8
        $fichier = fopen($file_path, 'r');
        
        if ($fichier) {
            while (($ligne = fgets($fichier)) !== false) {
                // Convertir la ligne en UTF-8 si nécessaire
                $ligne_utf8 = mb_convert_encoding($ligne, 'UTF-8', 'UTF-8');
                $lignes[] = $ligne_utf8;
            }
            fclose($fichier);
            return $lignes;
        } else {
            throw new \Exception("Impossible de lire le fichier");
        }
    } catch (\Exception $e) {
        // Gérer l'erreur en affichant une vue d'erreur
        throw $e;// ['message' => $e->getMessage()];
    }
}



?>