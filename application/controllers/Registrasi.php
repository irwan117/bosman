<?php

class Registrasi extends CI_Controller
{
    public function index()
    {
        // Validasi form
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]', [
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[repassword]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password minimal 6 karakter!'
        ]);
        $this->form_validation->set_rules('repassword', 'Konfirmasi Password', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Halaman Registrasi';
            $this->load->view('admin/templates/admin_header', $data);
            $this->load->view('admin/registrasi', $data);
            $this->load->view('admin/templates/admin_footer');
        } else {
            // Data yang akan dimasukkan
            $data = [
                'nama_lengkap' => html_escape($this->input->post('nama_lengkap', true)),
                'email' => html_escape($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            ];
            $this->db->insert('tbl_user', $data);

            // Flashdata untuk pesan berhasil
            $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">
                Registrasi berhasil! Silakan login.
            </div>');

            redirect('login');
        }
    }
}
?>
