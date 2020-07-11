<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Authadmin extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('Authadmin_model', 'auth');
    }

    //API POST untuk id kreditor dan password
    public function index_post()
    {
        #Set response API if Success
        $response['SUCCESS'] = array('status' => TRUE, 'message' => 'Berhasil Login');

        #Set response API if Fail
        $response['FAIL'] = array('status' => FALSE, 'message' => 'Password / Username Salah', 'data' => null);


        $data_user = $this->auth->get_user($this->post('username'), $this->post('password'));

        if ($data_user) {
            $response['SUCCESS']['data'] = $data_user;
            $this->response($response['SUCCESS'], 200);
        } else {
            $this->response($response['FAIL'], 200);
        }
    }
}
