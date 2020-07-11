<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Transaksi extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('Transaksi_model', 'transaksi');
    }

    public function index_post()
    {
        //untuk cek apakah client minta params
        //params nya id untuk kasus ini
        $id_kreditor = $this->post('id_kreditor');

        if ($id_kreditor === null) {
            $transaksi = $this->transaksi->getTransaksi();
        } else {
            $transaksi = $this->transaksi->getTransaksi($id_kreditor);
        }
        if ($transaksi) {
            $this->response([
                'status' => true,
                'transaksi' => $transaksi
            ], 200); // HTTP OK
        } else {
            $this->response([
                'status' => false,
                'message' => 'Barang Tidak Ditemukan'
            ], 404); //HTTP_NOT_FOUND
        }
    }
}
