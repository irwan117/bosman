<?php
class Login extends CI_Controller
{
    public function index()
    {
        $data['judul'] = 'Halaman Login';
        $this->load->view('user/templates/admin_header', $data);
        $this->load->view('user/login', $data);
        $this->load->view('user/templates/admin_footer');
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
                    'id_user' => $tbl_user['id_user'], // Menyimpan id_user ke session
                ];
                $this->session->set_userdata($data);

                redirect('beranda');  // Redirect ke halaman utama setelah login
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

    // Cek jika pengguna sudah login, jika belum redirect ke login page
    public function check_login() {
        // Cek apakah sudah ada session 'id_user'
        if (!$this->session->userdata('id_user')) {
            redirect('login');  // Jika tidak ada, arahkan ke halaman login
        }
    }
}
?>
