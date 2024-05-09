<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Items extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('item_model');
        $this->load->library('session');
    }

    // Método para guardar un nuevo elemento
    public function save() {
        $name = $this->input->post('name');
        $author = $this->input->post('author');

        // Guardar el elemento en la base de datos
        $this->item_model->save_item($name, $author);

        // Devolver respuesta JSON
        echo json_encode(array('success' => true));
    }

     // Método para obtener los elementos
     public function get_items() {
        // Obtener los elementos de la base de datos
        $data['posts'] = $this->item_model->get_all_items();
        //Obtener los bookmarks seleccionados del usuario actual
        $user_bookmarks = [];
        $user_id = $this->session->userdata('user_data')['id'];
        $bookmarks = $this->item_model->list_bookmark_user($user_id);
        
        // Verificar si hay existen bookmarks para el usuario actual
        if (is_array($bookmarks)) {
            $user_bookmarks = array_column($bookmarks, 'post_id');
        }       
        // Recorrer los posts y marcar aquellos que estén en los bookmarks del usuario actual
        foreach ($data['posts'] as &$post) {
            $post['post_bookmark'] = in_array($post['id'], $user_bookmarks) ? 1 : 0;
        }
        unset($post);

        // Cargar la vista parcial con los elementos
        $this->load->view('items/item_list_partial', $data);

    }

    // Método para guardar un post como favorito
    public function save_bookmark() {
        $post_id = $this->input->post('post_id');
        $user_id = $this->session->userdata('user_data')['id'];
        // Guardar el post como favorito en la tabla post_bookmark
        $result = $this->item_model->save_bookmark($post_id, $user_id);

        if ($result) {
            echo json_encode(array('success' => true));
        } else if($result==0){
            echo json_encode(array('success' => 0));
        }else {
            echo json_encode(array('success' => false, 'message' => 'Error al guardar el post como favorito'));
        }
    }

    public function view_bookmark() {
        $post_id = $this->input->post('post_id');
        // Guardar el post como favorito en la tabla post_bookmark
        $result = $this->item_model->view_bookmark($post_id);

        echo json_encode(array('data' => $result));
    }

    public function eliminar_post() {
        $post_id = $this->input->post('post_id');
        // Eliminar Post
        $result = $this->item_model->eliminar_post($post_id);

        echo json_encode(array('data' => $result));
    }

}
