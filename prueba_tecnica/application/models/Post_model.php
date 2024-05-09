<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_posts() {
        return $this->db->get('post')->result_array();
    }

}
