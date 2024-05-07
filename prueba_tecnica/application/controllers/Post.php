<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->library('session');
    }

    public function index() {
        //Si el usuario no tiene una session asignada lo saca al login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        //Si tiene session activa lo lleva a la lista de los post
        $data['posts'] = $this->post_model->get_posts();
        $this->load->view('post/list', $data);
    }
}
