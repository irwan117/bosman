<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perawatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Perawatan_model'); // Memuat model Perawatan_model
        $this->load->library('session');
    }

    public function index() {
        $keyword = $this->input->post('keyword', true);

        if ($keyword) {
            $data['perawatan'] = $this->Perawatan_model->cariDataPerawatan($keyword); // Cari data berdasarkan keyword
        } else {
            $data['perawatan'] = $this->Perawatan_model->getAllPerawatan(); // Ambil semua data perawatan
        }

        $data['keyword'] = $keyword; // Simpan keyword untuk ditampilkan di view
        $data['judul'] = 'Daftar Perawatan';

        // Tampilkan view
        $this->load->view('templates/header', $data);
        $this->load->view('Perawatan/index', $data);
        $this->load->view('templates/footer');
    }
}
?>
