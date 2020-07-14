<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class DataBarang extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('DataBarang_model', 'barang');
    }

    //API POST UNTUK AMBIL DATA LIST BARANG SESUAI ID 
    //DAN DATA TRANSAKSI TERAKHIR

    public function index_post()
    {
        #Set response API if Success
        $response['SUCCESS'] = array('status' => TRUE, 'message' => 'Berhasil Mengambil Data');

        #Set response API if Fail
        $response['FAIL'] = array('status' => FALSE, 'message' => 'Gagal Mengambil Data', 'data' => null);

        $data_barang = $this->barang->get_barang($this->post('id_kreditor'));

        if ($data_barang) {
            $response['SUCCESS']['barang'] = $data_barang;
            $this->response($response['SUCCESS'], 200);
        } else {
            $this->response($response['FAIL'], 200);
        }
    }
}
