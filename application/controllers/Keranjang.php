<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keranjang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model Keranjang_model
        $this->load->model('Keranjang_model');
        // Tambahkan pemuatan Perawatan_model
        $this->load->model('Perawatan_model');
    }

    // Menampilkan keranjang berdasarkan user yang sedang login
    public function index() {
        // Ambil ID pengguna dari session
        $user_id = $this->session->userdata('id_user');
        
        // Cek apakah pengguna sudah login
        if (!$user_id) {
            redirect('login');
        }
    
        // Gunakan Perawatan_model untuk mengambil keranjang dengan detail perawatan
        $data['keranjang'] = $this->Perawatan_model->getPerawatanByUserId($user_id);
    
        // Memuat view keranjang
        $this->load->view('templates/header');
        $this->load->view('keranjang/index', $data);
        $this->load->view('templates/footer');
    }

    // Menambahkan item ke keranjang
    // Di Keranjang.php
    public function tambah($perawatan_id) {
        $user_id = $this->session->userdata('id_user');
        
        if (!$user_id) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('login');
        }

        $jumlah = $this->input->post('jumlah', true);
        
        if ($jumlah < 1) {
            $this->session->set_flashdata('error', 'Jumlah tidak valid');
            redirect('perawatan');
        }

        $this->Perawatan_model->tambahDataKeranjang($user_id, $perawatan_id, $jumlah);

        $this->session->set_flashdata('message', 'Item berhasil ditambahkan ke keranjang!');
        redirect('keranjang');
    }

    public function checkout() {
        $user_id = $this->session->userdata('id_user');
        
        if (!$user_id) {
            redirect('login');
        }
    
        // Ambil data keranjang
        $data['keranjang'] = $this->Keranjang_model->getKeranjangById($user_id);
    
        if (empty($data['keranjang'])) {
            $this->session->set_flashdata('error', 'Keranjang Anda kosong');
            redirect('keranjang');
        }
    
        // Hitung total harga
        $total_harga = 0;
        foreach ($data['keranjang'] as $item) {
            $perawatan = $this->Perawatan_model->getPerawatanById($item['perawatan_id']);
            $total_harga += $perawatan['harga'] * $item['jumlah'];
        }
        $data['total_harga'] = $total_harga;
    
        // Tampilkan form checkout
        $this->load->view('templates/header');
        $this->load->view('keranjang/checkout_form', $data);
        $this->load->view('templates/footer');
    }
    
    public function proses_checkout() {
        $user_id = $this->session->userdata('id_user');
        
        if (!$user_id) {
            redirect('login');
        }
    
        // Validasi form
        $this->form_validation->set_rules('nama_penerima', 'Nama Penerima', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');
        $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required|trim');
    
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form
            $this->checkout();
            return;
        }
    
        // Ambil data keranjang
        $keranjang = $this->Keranjang_model->getKeranjangById($user_id);
    
        if (empty($keranjang)) {
            $this->session->set_flashdata('error', 'Keranjang Anda kosong');
            redirect('keranjang');
        }
    
        // Siapkan data alamat
        $alamat_lengkap = "Nama: " . $this->input->post('nama_penerima') . 
                          "\nTelepon: " . $this->input->post('no_telepon') . 
                          "\nAlamat: " . $this->input->post('alamat') . 
                          "\nKota: " . $this->input->post('kota') . 
                          "\nKode Pos: " . $this->input->post('kode_pos');
    
        // Proses checkout
        try {
            $total_harga = 0;
            foreach ($keranjang as $item) {
                // Ambil detail perawatan
                $perawatan = $this->Perawatan_model->getPerawatanById($item['perawatan_id']);
                $total_item = $perawatan['harga'] * $item['jumlah'];
                $total_harga += $total_item;
    
                // Tambah order untuk setiap item
                $this->Keranjang_model->tambahDataOrder(
                    $user_id, 
                    $item['perawatan_id'], 
                    $item['jumlah'], 
                    $total_item, 
                    $alamat_lengkap
                );
            }
    
            // Hapus semua item di keranjang
            foreach ($keranjang as $item) {
                $this->Perawatan_model->hapusDataKeranjang($user_id, $item['perawatan_id']);
            }
    
            $this->session->set_flashdata('message', 'Checkout berhasil! Total: Rp ' . number_format($total_harga, 0, ',', '.'));
            redirect('order');
    
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Checkout gagal: ' . $e->getMessage());
            redirect('keranjang');
        }
    }
    
    // Menghapus item dari keranjang
    public function hapus($perawatan_id) {
        // Ambil ID pengguna dari session
        $user_id = $this->session->userdata('id_user');
        
        // Jika pengguna belum login, redirect ke halaman login
        if (!$user_id) {
            redirect('login');
        }

        // Hapus item dari keranjang
        $this->Keranjang_model->HapusDataKeranjang($user_id, $perawatan_id);

        // Set flashdata dan redirect kembali ke halaman keranjang setelah berhasil menghapus
        $this->session->set_flashdata('message', 'Item berhasil dihapus dari keranjang!');
        redirect('keranjang');
    }

}
?>
