<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Transaksiadmin extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Transaksiadmin_model', 'transaksiadmin');
    }

    // API POST untuk aplikasi android admin
    public function index_post()
    {
        $id_barang = $this->post('id_barang');
        $id_kreditor = $this->post('id_kreditor');
        $current_id_barang = $this->transaksiadmin->getBarangId($id_barang, $id_kreditor);
        $dataLama = array("id_barang" => $this->post("id_barang"));

        $data = [
            'id_kreditor' => $this->post('id_kreditor'),
            'id_barang' => $this->post('id_barang'),
            'id_transaksi' => $this->post('id_transaksi'),
            'tanggal_transaksi' => $this->post('tanggal_transaksi'),
            'nominal_transaksi' => $this->post('nominal_transaksi')
        ];

        if ($dataLama === $current_id_barang) {
            if ($this->transaksiadmin->tambahTransaksi($data) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Transaksi Telah Ditambahkan !',
                    'transaksi' => $data
                ], 201); //HTTP_CREATED
            } else {
                // kalo id ga ada ditabel
                $this->response([
                    'status' => false,
                    'message' => 'Transaksi Gagal',
                    'transaksi' => null
                ], 200); //HTTP_BAD_REQUES
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Barang Tidak Ditemukan / Bukan Milik Kreditor Yang Bersangkutan',
                'transaksi' => null
            ], 200); //HTTP_BAD_REQUES
        }
    }

    public function index_put()
    {
        $id_transaksi = $this->put("id_transaksi");

        $data = array(
            "id_kreditor" => $this->put("id_kreditor"),
            "id_barang" => $this->put("id_barang"),
            "id_transaksi" => $this->put("id_transaksi"),
            "tanggal_transaksi" => $this->put("tanggal_transaksi"),
            "nominal_transaksi" => $this->put("nominal_transaksi")
        );

        if ($this->transaksiadmin->updateTransaksi($data, $id_transaksi) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data Transaksi Telah Diubah',
                'transaksi' => $data
            ], 200); //HTTP_CREATED
        } else {
            // kalo id ga ada ditabel
            $this->response([
                'status' => false,
                'message' => 'Data Gagal Di Ubah ! Masukkan Nominal',
                'transaksi' => null
            ], 200); //HTTP_BAD_REQUES
        }
    }
}
