<?php

class Barang_model extends CI_Model
{
    public function getBarang($id_kreditor = null)
    {
        if ($id_kreditor === null) {
            //result_array() -> array associative
            $this->db->select('nama_barang');
            $this->db->select('angsuran');
            $this->db->select('nominal_angsuran');
            $this->db->select('uang_muka');
            $this->db->select('kredit_total');
            $this->db->select('kredit_masuk');
            $this->db->select('sisa_kredit');
            $this->db->select('status');
            $this->db->from('barang');
            $this->db->join('kreditor', 'kreditor.id_kreditor = barang.id_kreditor');
            $this->db->join('jenis_barang', 'jenis_barang.id = barang.barang_id');
            $this->db->join('jenis_status', 'jenis_status.id = barang.status_id');
            $this->db->join('jenis_angsuran', 'jenis_angsuran.id = barang.angsuran_id');
            return $this->db->get()->result_array();
        } else {
            $this->db->select('nama_barang');
            $this->db->select('angsuran');
            $this->db->select('nominal_angsuran');
            $this->db->select('uang_muka');
            $this->db->select('kredit_total');
            $this->db->select('kredit_masuk');
            $this->db->select('sisa_kredit');
            $this->db->select('status');
            $this->db->from('barang');
            $this->db->join('kreditor', 'kreditor.id_kreditor = barang.id_kreditor');
            $this->db->join('jenis_barang', 'jenis_barang.id = barang.barang_id');
            $this->db->join('jenis_status', 'jenis_status.id = barang.status_id');
            $this->db->join('jenis_angsuran', 'jenis_angsuran.id = barang.angsuran_id');
            $this->db->where('kreditor.id_kreditor', $id_kreditor);
            return $this->db->get()->result_array();
        }
    }
}
