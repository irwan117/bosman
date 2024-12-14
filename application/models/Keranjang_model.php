<?php
class Keranjang_model extends CI_Model {

// Fungsi untuk mengambil data keranjang berdasarkan user_id
public function getKeranjangById($user_id) {
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('keranjang');
    return $query->result_array();
}

// Fungsi untuk menambahkan data order ke tabel orders
public function tambahDataOrder($user_id, $perawatan_id, $jumlah, $total_harga, $alamat) {
    $data = [
        'user_id' => $user_id,
        'perawatan_id' => $perawatan_id,
        'jumlah' => $jumlah,
        'total_harga' => $total_harga,
        'alamat' => $alamat,
        'status' => 'pending',
        'order_date' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('orders', $data);
}

// Fungsi untuk menghapus item dari keranjang setelah checkout
public function HapusDataKeranjang($user_id, $perawatan_id) {
    $this->db->where('user_id', $user_id);
    $this->db->where('perawatan_id', $perawatan_id);
    $this->db->delete('keranjang');
}
}
?>