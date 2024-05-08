<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation'); 
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->load->model('user_model');
    }

    public function login() {
       // Si ya está autenticado, redirige a la página de inicio
        if ($this->session->userdata('logged_in')) {
            $data['username'] = $this->session->userdata('user_data')['username'];
            $this->load->view('post/list',$data);
            return false;
        }

        // Si se envió el formulario, procesa los datos
        if ($this->input->post()) {
            $this->process_login();
            return false;
        } else {
            // De lo contrario, carga la vista de inicio de sesión
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_data');
            $this->load->view('auth/login');
            return false;
        }
    }

    private function process_login() {

        $username = $this->input->post('username',TRUE);
        $password = $this->input->post('password',TRUE);

        // Verificar si las credenciales son válidas
        $user = $this->user_model->get_user($username);
        if ($user && password_verify($password, $user['password'])) {
            //Agregar la informacion del usuario a las variables de session
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('user_data', $user);
            $data['username'] = $user['username'];
            $this->load->view('post/list',$data);
        } else {
            // Si las credenciales son incorrectas, mostrar un mensaje de error
            $data['error'] = 'Credenciales incorrectas. Por favor, inténtelo de nuevo.';
            $this->load->view('auth/login', $data);
        }
        
    }
 
    public function register() {
        //Redirigir a la ventana de registro
        $this->load->view('auth/register');
    }

    public function add_user() {
        //Se valida si el nombre de usuario ya existe
       $user = $this->user_model->get_user($this->input->post('username'));
       if($user){
            $data['error'] = 'Nombre de usuario ya ha sido registrado, intente con otro';
            $this->load->view('auth/register', $data);

       }else if($this->input->post('password') != $this->input->post('password_confirm')){
            //Validar que las contraseñas sean las mismas            
            $data['error'] = 'La contraseña no coinciden, intenten nuevamente';
            $this->load->view('auth/register', $data);

        }else{
            //Se guarda la información 
            $data_user = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'fecha_creacion' => date('Y-m-d H:i:s')
            );
    
            $this->user_model->register_user($data_user);
            $data['success'] = 'Usuario creado';
            $this->load->view('auth/login', $data);
        }
        
    }
    

    public function logout() {  
        //Se quitan las variables del usuario asignadas a la session
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_data');
        redirect('auth/login');
    }
}
