<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_config_pagination(){
    $config = array();
    // // $config["base_url"] = base_url() . "votre_controller/maMethode";
    // // $config["total_rows"] = $this->Votre_modele->nombre_de_lignes();
    // $config["per_page"] = 10; // Nombre de lignes par page
    
    // Configurer la personnalisation de la pagination
    $config["uri_segment"] = 3;
    $config["full_tag_open"] = '<ul class="pagination">';
    $config["full_tag_close"] = '</ul>';
    $config["first_tag_open"] = '<li>';
    $config["first_tag_close"] = '</li>';
    $config["last_tag_open"] = '<li>';
    $config["last_tag_close"] = '</li>';
    $config['next_link'] = '&gt;';
    $config["next_tag_open"] = '<li>';
    $config["next_tag_close"] = '</li>';
    $config['prev_link'] = '&lt;';
    $config["prev_tag_open"] = '<li>';
    $config["prev_tag_close"] = '</li>';
    $config["cur_tag_open"] = '<li class="active"><a href="#">';
    $config["cur_tag_close"] = '</a></li>';
    $config["num_tag_open"] = '<li>';
    $config["num_tag_close"] = '</li>';
    
    return $config;
}

function get_config_upload(){
    $config['upload_path'] = FCPATH . './upload';
    $config['allowed_types'] = '*';
    $config['max_size']      = 100000000000; 
    $config['max_width']     = 1024000000000; 
    $config['max_height']    = 7680000000;
    return $config;
}
?>