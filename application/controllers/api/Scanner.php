<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Scanner extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('Scanner_model', 'scanner');
    }

    //API POST UNTUK AMBIL DATA LIST BARANG SESUAI ID 
    //DAN DATA TRANSAKSI TERAKHIR

    public function index_post()
    {
        #Set response API if Success
        $response['SUCCESS'] = array('status' => TRUE, 'message' => 'Berhasil Memindai');

        #Set response API if Fail
        $response['FAIL'] = array('status' => FALSE, 'message' => 'Gagal Memindai', 'data' => null);

        $data_kreditor = $this->scanner->get_kreditor($this->post("id_kreditor"));
        // $data_barang = $this->scanner->get_barang($this->post('id_kreditor'));
        // // $data_transaksi = $this->scanner->get_transaksi($this->post('id_kreditor'));
        $data_transaksi = $this->scanner->getIdTransaksi();

        if ($data_kreditor) {
            $response['SUCCESS']['kreditor'] = $data_kreditor;
            // $response['SUCCESS']['barang'] = $data_barang;
            $response['SUCCESS']['transaksi']['id_transaksi'] = $data_transaksi;
            $this->response($response['SUCCESS'], 200);
        } else {
            $this->response($response['FAIL'], 200);
        }
    }
}
