<?php

class Transaksi_model extends CI_Model
{
    public function getTransaksi($id_kreditor = null)
    {
        if ($id_kreditor === null) {
            //result_array() -> array associative
            $this->db->select('tanggal_transaksi');
            $this->db->select('id_transaksi');
            $this->db->select('nominal_transaksi');
            $this->db->select('tanggal_transaksi');
            $this->db->select('nama_barang');
            $this->db->from('transaksi');
            $this->db->join('kreditor', 'kreditor.id_kreditor = transaksi.id_kreditor');
            $this->db->join('barang', 'barang.id_barang = transaksi.id_barang');
            return $this->db->get()->result_array();
        } else {
            $this->db->select('tanggal_transaksi');
            $this->db->select('id_transaksi');
            $this->db->select('nominal_transaksi');
            $this->db->select('tanggal_transaksi');
            $this->db->select('nama_barang');
            $this->db->from('transaksi');
            $this->db->join('kreditor', 'kreditor.id_kreditor = transaksi.id_kreditor');
            $this->db->join('barang', 'barang.id_barang = transaksi.id_barang');
            $this->db->where('kreditor.id_kreditor', $id_kreditor);
            return $this->db->get()->result_array();
        }
    }
}
