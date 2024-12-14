<?php
class Beranda_admin extends CI_Controller
{
    public function index()
    {
        if (empty($this->session->userdata('email'))) {
            redirect('login'); 
        }
        $data['judul'] = 'Bosman';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('Beranda_admin/index', $data);
        $this->load->view('templates/footer_admin');
    }
}
?>
