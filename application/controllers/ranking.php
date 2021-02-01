<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH. '/libraries/Rest_Controller.PHP';
class Ranking extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        
    }

    public function index_put()
    {
        $data = $this->put();

        

        if ($this->db->insert('ranking', $data)) {

            $data = array(
                'error' => FALSE,
                'message' => 'Registro añadido',
            );

            $this->response($data);
        } else {

            $respuesta = array(
                'error' => TRUE,
                'message' => 'No se puede añadir el registro'
            );

            $this->response($respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index_get()
    {

        $this->db->order_by('puntuacion ASC, id ASC');
        $this->db->limit(10);
        $query = $this->db->get('ranking');

        if (!isset($query)) {

            $data = array(
                'error' => TRUE,
                'message' => 'no se puede conectar a la base de datos',
                'data' => NULL,
            );

            $this->response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {

            if ($query->result() == [] || $query->result() == null) {

                $data = array(
                    'error' => TRUE,
                    'message' => 'No hay registros',
                    'data' => [],
                );

                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            } else {

                $data = array(
                    'error' => FALSE,
                    'message' => 'Registros leidos correctamente',
                    'data' => $query->result(),
                );

                $this->response($data, REST_Controller::HTTP_OK);
            }
        }
    }

}