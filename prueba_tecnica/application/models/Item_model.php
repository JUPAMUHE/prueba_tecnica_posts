<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Método para guardar un nuevo item en la tabla post
    public function save_item($name, $author) {
        $data = array(
            'nombre' => $name,
            'autor' => $author,
            'fecha_creacion' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('post', $data);
    }

    // Método para obtener todos los items de la tabla post
    public function get_all_items() {
        return $this->db->get('post')->result_array();
    }

    // Método para guardar item en la tabla post_bookmark
    public function save_bookmark($post_id, $user_id) {
        $this->db->select('*');
        $this->db->from('post_bookmark');
        $this->db->where('post_bookmark.post_id', $post_id);
        $this->db->where('post_bookmark.user_id', $user_id);
        $query = $this->db->get();

        //Validar si ese usuario logueado anteriormente ha guardado ese post
        if($query->num_rows() > 0){
            return 0;
        }else{
            $data = array(
                'user_id' => $user_id,
                'post_id' => $post_id,
                'fecha_creacion' => date('Y-m-d H:i:s')
            );
    
            return $this->db->insert('post_bookmark', $data);
        }
       
    }

    //Metodo para ver los usuarios que han seleccionado ese post como favorito
    public function view_bookmark($post_id){
        $this->db->select('users.username as usuario_nombre,post_bookmark.fecha_creacion');
        $this->db->from('post_bookmark');
        $this->db->join('users', 'users.id = post_bookmark.user_id');
        $this->db->where('post_bookmark.post_id', $post_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); 
        } else {
            return false;
        }
    }
}
