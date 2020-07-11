<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/REST_Controller_Definitions.php';

class Kreditor extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->model('Kreditor_model', 'kreditor');
    }

    public function index_get()
    {
        //untuk cek apakah client minta params
        //params nya id untuk kasus ini
        $id_kreditor = $this->get('id_kreditor');

        if ($id_kreditor === null) {
            $kreditor = $this->kreditor->getKreditor();
        } else {
            $kreditor = $this->kreditor->getKreditor($id_kreditor);
        }
        if ($kreditor) {
            $this->response([
                'status' => true,
                'data' => $kreditor
            ], 200); // HTTP OK
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kreditor Tidak Ditemukan'
            ], 404); //HTTP_NOT_FOUND
        }
    }

    public function index_put()
    {
        $id = $this->put("id_kreditor");
        $current_password = $this->kreditor->getPasswordById($id);

        //==================UBAH PASSWORD===================
        if ($this->put("password")) {
            $passwordBaru = array("password" => $this->put("password"));
            $passwordBaru2 = array("password" => $this->put("password2"));
            $dataLama = array("password" => $this->put("password_lama"));

            if ($dataLama === $current_password) {
                if ($passwordBaru == $passwordBaru2) {
                    if ($this->kreditor->updatePassword($passwordBaru, $id) > 0) {
                        $this->response([
                            'status' => true,
                            'message' => 'Kata Sandi Telah Di Ubah !'
                        ], 200); //HTTP_CREATED
                    } else {
                        // kalo id ga ada ditabel
                        $this->response([
                            'status' => false,
                            'message' => 'Kata Sandi Gagal Di Ubah !'
                        ], 200); //HTTP_BAD_REQUES
                    }
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Kata Sandi Tidak Sama  !'
                    ], 200); //HTTP_BAD_REQUES
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Kata Sandi Lama Dengan Baru Beda !'
                ], 200); //HTTP_BAD_REQUES
            }
            //=============FORGOT PASSWORD==============
        } else if ($this->put("nomor_hp") && $this->put("email")) {
            //masukkan api
            $nomorHp = $this->put("nomor_hp");
            $email = $this->put("email");

            $getNomorHp = $this->db->get_where('kreditor', ['nomor_hp' => $nomorHp])->row_array();
            if ($getNomorHp) {
                //kirim email
                $this->_sendEmail($nomorHp, $email);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Nomor HP Tidak Teregistrasi !',
                ], 200); //HTTP_BAD_REQUES
            }
        }
        //========================UBAH BIODATA===================== 
        else if ($this->put("nama_kreditor") && $this->put("alamat") && $this->put("nomor_hp") && $this->put("nomor_ktp")) {
            $data = array(
                "nama_kreditor" => $this->put("nama_kreditor"),
                "alamat" => $this->put("alamat"),
                "nomor_hp" => $this->put("nomor_hp"),
                "nomor_ktp" => $this->put("nomor_ktp")
            );
            if ($this->kreditor->updateKreditor($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Data Telah Di Ubah ! Silahkan Login Kembali',
                    'data' => $data
                ], 200); //HTTP_CREATED
            } else {
                // kalo id ga ada ditabel
                $this->response([
                    'status' => false,
                    'message' => 'Data Gagal Di Ubah ! Masukkan Data Yang Ingin Diubah',
                    'data' => null
                ], 200); //HTTP_BAD_REQUES
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Masukkan Kata Sandi Dengan Benar'
            ], 200); //HTTP_BAD_REQUES
        }
    }


    //=============METHOD===============

    private function _sendEmail($nomorHp, $email)
    {
        $dataKreditor = $this->kreditor->getDataByPhone($nomorHp);
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            //user sama pass adalah email yang mengirimkan ke email client
            'smtp_user' => 'alfian.test12@gmail.com',
            'smtp_pass' => 'Sifin130413.',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        //kirim dari 
        $this->email->from('alfian.test12@gmail.com', 'Biod Admin');
        //kirim ke
        $this->email->to($email);

        //isi email
        $this->email->subject('Lupa Password Ya?');
        $this->email->message('<h3>Yth. Atas Nama Bapak/Ibu : ' . $dataKreditor['nama_kreditor'] . ' </h3>
                                <p>berikut adalah ID dan Password Bapak/Ibu</p>
                                <p>Setelah Login segera lakukan perubahan Password Terbaru !</p>
                                <h4>ID : ' . $dataKreditor['id_kreditor'] . ' </h4>
                                <h4>PASSWORD : ' . $dataKreditor['password'] . '</h4>');
        // "Atas Nama : " . $dataKreditor['nama_kreditor'] . " ID kamu : " . $dataKreditor['id_kreditor'] . " Password kamu : " . $dataKreditor['password'] . " Segera lakukan penggantian password yang baru agar lebih aman"

        if ($this->email->send()) {
            $this->response([
                'status' => true,
                'message' => 'Email Telah Dikirim ke alamat : ' . $email . ' !'
            ], 200); //HTTP_CREATED
        } else {
            $this->response([
                'status' => false,
                'message' => 'Email Gagal Dikirim !',
            ], 400); //HTTP_BAD_REQUES
            echo $this->email->print_debugger();
            die;
        }
    }
}
