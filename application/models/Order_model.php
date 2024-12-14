<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Mengambil semua pesanan berdasarkan user_id
    public function getOrdersByUserId($user_id) {
        $this->db->select('orders.id, orders.user_id, orders.perawatan_id, orders.jumlah, orders.total_harga, orders.alamat, orders.order_date, orders.status, perawatan.nama, perawatan.harga');
        $this->db->from('orders');
        $this->db->join('perawatan', 'orders.perawatan_id = perawatan.id');
        $this->db->where('orders.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
     public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('orders', ['status' => $status]);
    }
    // Menghapus pesanan berdasarkan order_id dan user_id
    public function hapusOrder($order_id, $user_id) {
        $this->db->where('id', $order_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('orders');
    }

   
}
?>
