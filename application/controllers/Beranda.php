<?php
class Beranda extends CI_Controller
{
    public function index()
    {
        if (empty($this->session->userdata('email'))) {
            redirect('login'); 
        }
        $data['judul'] = 'Bosman';
        $this->load->view('templates/header', $data);
        $this->load->view('Beranda/index', $data);
        $this->load->view('templates/footer');
    }
}
?>
