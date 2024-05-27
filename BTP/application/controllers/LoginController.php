<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
// require_once(APPPATH . 'controllers/SessionController.php');
class LoginController extends CI_Controller{
    function __construct()
    {
        parent::__construct(); 
        $this->load->model('UtilisateurModel');
        
    } 
    public function index(){
        $this->load->library("form_validation");
        if($this->form_validation->run('login_client')===FALSE){
            $this->load->view("login/client_view");
        }else{
           $numero= $this->input->post("numero");
           if($this->check_format_number($numero)==True){
            $res=$this->UtilisateurModel->check_numero($numero);

            if($res!=False){
                 $this->session->set_userdata("user",$res);
                 redirect(site_url()."DevisController");
            }else{
                 $data=array();
                 $data['error']="Verifier votre le numero que vous aviez inserer";
                 $this->load->view("login/client_view",$data);
            }
           }else{
            $data=array();
            $file_path=site_url()."./assets/data_check/numero.json";
            $json_data = file_get_contents($file_path);
            $data['error']=" le numero doit commencer par ".$json_data;
            $this->load->view("login/client_view",$data);
           }
           
        }
    }
    public function check_format_number($numero){
        $file_path=site_url()."./assets/data_check/numero.json";
        $json_data = file_get_contents($file_path);

        // Décodage JSON en tableau PHP
        $numeros = json_decode($json_data);
        $prefix=substr($numero,0,3);
        foreach ($numeros as $numero) {
            if ($prefix === $numero) {
              return True;
            }
        }
        return False;
    }
    public function form_admin(){
        $this->load->library("form_validation");
        if($this->form_validation->run('login')===FALSE){
            $this->load->view("login/login_view");
        }else{
           $email= $this->input->post("email");
           $pwd=$this->input->post("password");
          
           $res=$this->UtilisateurModel->check($email,$pwd);

           if($res!=False){
                $this->session->set_userdata("user",$res);
                redirect(site_url()."DashboardController");
           }else{
                $data=array();
                $data['error']="Verifier votre Mot de passe ou e-mail";
                $this->load->view("login/login_view",$data);
           }
    }
}
   
    public function disconnect(){
        if($this->session->has_userdata('user') == true){
            $this->session->unset_userdata("user");
            redirect("loginController"); //page qui ne requiert pas de connection
        }
    }
    //signup
    public function process_Sign_Up(){
        $this->load->library("form_validation");
        if($this->form_validation->run('signup')===FALSE){
            $this->load->view('login/signup');
        }else{
            $pass_hache = password_hash(trim($this->input->post('password')), PASSWORD_DEFAULT);
            $this->UtilisateurModel->insert_new_user($this->input->post('nom'),
                                trim($this->input->post('prenom')),
                                trim($this->input->post('email')),
                                $pass_hache,
                                $this->input->post('sexe'),
                                $this->input->post('dtn'));
            redirect("loginController"); //page qui ne requiert pas de connection
        }
    }
    
} 
?>