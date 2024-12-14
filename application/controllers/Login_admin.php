<?php

class Login_admin extends CI_Controller
{
    public function index()
    {
        $data['judul'] = 'Halaman Login Admin';
        $this->load->view('admin/templates/admin_header', $data);
        $this->load->view('admin/login_admin', $data);
        $this->load->view('admin/templates/admin_footer');
    }

    public function proses_login()
    {
        // Validasi input email dan password
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Masukkan Email dan Password yang valid!</div>');
            redirect('login');
        }

        // Ambil input dari form
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        // Cari pengguna berdasarkan email
        $tbl_user = $this->db->get_where('tbl_user', ['email' => $email])->row_array();

        if ($tbl_user) {
            // Periksa password
            if (password_verify($password, $tbl_user['password'])) {
                // Set data sesi
                $data = [
                    'email' => $tbl_user['email'],
                    'id_user' => $tbl_user['id_user'], // Jika ada kolom ID user
                ];
                $this->session->set_userdata($data);

                redirect('beranda_admin');
            } else {
                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Password salah!</div>');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Email belum terdaftar!</div>');
            redirect('login');
        }
    }

    public function logout()
    {
        // Hapus semua data session
        $this->session->sess_destroy();
        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Anda telah berhasil logout.</div>');
        redirect('login');
    }
}

?>
