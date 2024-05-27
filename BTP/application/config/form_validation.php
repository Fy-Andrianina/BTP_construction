<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'signup' => array(
        array(
            'field' => 'nom',
            'label' => 'Nom d\'utilisateur',
            'rules' => 'required|alpha_numeric|trim'
        ),
        array(
            'field' => 'prenom',
            'label' => 'Votre prenom',
            'rules' => 'required|alpha_numeric|trim'
        ),
        array(
            'field' => 'dtn',
            'label' => 'Date de naissance',
            'rules' => 'required'
        ),
        array(
            'field' => 'sexe',
            'label' => 'Sexe',
            'rules' => 'required|numeric'
        ), array(
            'field' => 'email',
            'label' => 'Votre email',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Mot de passe',
            'rules' => 'required|trim'
        )
        
    ),
    "login"=>array(
        array(
            'field' => 'email',
            'label'=> 'E-mail',
            'rules'=>'required|valid_email|trim'
        ),
        array(
            'field' => 'password',
            'label'=> 'Mot de passe',
            'rules'=>'required'
        ),
    ),
        "paye"=>array(
            array(
                'field' => 'montant',
                'label'=> 'Le montant a payer',
                'rules'=>'required|numeric|greater_than[0]'
            ),
        ),
        "login_client"=>array(
            array(
                'field' => 'numero',
                'label'=> 'Le Numero de telephone',
                'rules'=>'required|alpha_numeric|trim|exact_length[10]'
            ),
        ),
        "devis"=>array(
            array(
                'field' => 'type_maison',
                'label'=> 'Le type de maison',
                'rules'=>'required|numeric'
            ),
            array(
                'field' => 'type_finition',
                'label'=> 'Le Type de finition',
                'rules'=>'required|numeric'
            ),
            array(
                'field' => 'date_debut',
                'label'=> 'La debut de travaux ',
                'rules'=>'required|valid_date'
            ),
        )
);
?>