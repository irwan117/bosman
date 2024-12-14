<?php

class Styling extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Styling_model');
    }

    public function index()
    {    
        if (empty($this->session->userdata('email'))) {
            redirect('login');
        }

        $data['judul'] = 'Bosman';
        $data['styling'] = $this->Styling_model->getAllStyling();

        $this->load->view('templates/header', $data);
        $this->load->view('styling/index', $data);
        $this->load->view('templates/footer');
    }
}
?>