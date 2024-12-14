<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perawatan_model extends CI_Model {

    // Mengambil semua data perawatan
    public function getAllPerawatan() {
        return $this->db->get('perawatan')->result_array();
    }

    // Menambahkan data perawatan
    public function tambahDataPerawatan() {
        $data = [
            "nama" => $this->input->post('nama', true),
            "poto" => $this->input->post('poto', true),
            "harga" => $this->input->post('harga', true)
        ];
        // Insert data perawatan ke database
        $this->db->insert('perawatan', $data);
    }

    // Mengambil perawatan berdasarkan ID
    public function getPerawatanById($id) {
        return $this->db->get_where('perawatan', ['id' => $id])->row_array();
    }

    // Mencari data perawatan berdasarkan keyword
    public function cariDataPerawatan($keyword) {
        $this->db->like('nama', $keyword);
        $this->db->or_like('harga', $keyword);
        return $this->db->get('perawatan')->result_array();
    }

    // Mengubah data perawatan berdasarkan ID
    public function ubahDataPerawatan($id) {
        $data = [
            "nama" => $this->input->post('nama', true),
            "harga" => $this->input->post('harga', true)
        ];
        $this->db->where('id', $id);
        $this->db->update('perawatan', $data);
    }

    // Menghapus data perawatan berdasarkan ID
    public function hapusDataPerawatan($id) {
        $this->db->where('id', $id);
        $this->db->delete('perawatan');
    }

    // Menambahkan fungsi untuk menampilkan data berdasarkan user ID
    public function getPerawatanByUserId($user_id) {
        $this->db->select('keranjang.*, perawatan.nama, perawatan.harga, perawatan.poto');
        $this->db->from('keranjang');
        $this->db->join('perawatan', 'keranjang.perawatan_id = perawatan.id');
        $this->db->where('keranjang.user_id', $user_id);
        return $this->db->get()->result_array();
    }

    // Fungsi untuk menambahkan item ke keranjang
    public function tambahDataKeranjang($user_id, $perawatan_id, $jumlah) {
        $this->db->where('user_id', $user_id);
        $this->db->where('perawatan_id', $perawatan_id);
        $query = $this->db->get('keranjang');

        if ($query->num_rows() > 0) {
            // Update jumlah jika item sudah ada
            $this->db->set('jumlah', 'jumlah + '.$jumlah, FALSE);
            $this->db->where('user_id', $user_id);
            $this->db->where('perawatan_id', $perawatan_id);
            $this->db->update('keranjang');
        } else {
            // Insert perawatan baru ke keranjang
            $data = [
                'user_id' => $user_id,
                'perawatan_id' => $perawatan_id,
                'jumlah' => $jumlah
            ];
            $this->db->insert('keranjang', $data);
        }
    }

    // Fungsi untuk menghapus item dari keranjang
    public function hapusDataKeranjang($user_id, $perawatan_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('perawatan_id', $perawatan_id);
        $this->db->delete('keranjang');
    }
}
?>
