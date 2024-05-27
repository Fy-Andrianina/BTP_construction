<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionController extends CI_Controller {
    function __construct()
    {
        parent::__construct(); 
        if($this->session->has_userdata('user') == false)
            {
                redirect(site_url('loginController'));
            }
    }
}
?>