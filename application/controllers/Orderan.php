<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model Order_model
        $this->load->model('Order_model');
    }

    // Menampilkan daftar pesanan berdasarkan user yang sedang login
    public function index() {
        $user_id = $this->session->userdata('id_user');

        if (!$user_id) {
            redirect('login');
        }

        $data['orders'] = $this->Order_model->getOrdersByUserId($user_id);

        $this->load->view('templates/header_admin');
        $this->load->view('orderan/index', $data);
        $this->load->view('templates/footer_admin');
    }

    public function update_status($id){
        $status = $this->input->post('status');
        $this->order_model->update_status($id, $status);
        $this->session->set_flashdata('message', 'Status berhasil diperbarui.');
        redirect('orderan');
    }

    // Menghapus pesanan berdasarkan ID
    public function hapus($order_id) {
        $user_id = $this->session->userdata('id_user');

        if (!$user_id) {
            redirect('login');
        }

        $this->Order_model->hapusOrder($order_id, $user_id);

        $this->session->set_flashdata('message', 'Pesanan berhasil dihapus.');
        redirect('orderan');
    }
}
?>
