<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Barang extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('Barang_model', 'barang');
    }

    public function index_post()
    {
        //untuk cek apakah client minta params
        //params nya id untuk kasus ini
        $id_kreditor = $this->post('id_kreditor');

        if ($id_kreditor === null) {
            $barang = $this->barang->getBarang();
        } else {
            $barang = $this->barang->getBarang($id_kreditor);
        }
        if ($barang) {
            $this->response([
                'status' => true,
                'barang' => $barang
            ], 200); // HTTP OK
        } else {
            $this->response([
                'status' => false,
                'message' => 'Barang Tidak Ditemukan'
            ], 200); //HTTP_NOT_FOUND
        }
    }
}
