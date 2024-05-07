<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_posts() {
        return $this->db->get('post')->result_array();
    }

}
