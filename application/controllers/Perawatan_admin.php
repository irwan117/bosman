<?php



class Perawatan_admin extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('Perawatan_model');

        $this->load->library('upload');

    }



    public function index()

    {    

        if (empty($this->session->userdata('email'))) {

            redirect('login');
        }



        $data['judul'] = 'Bosman';

        $data['perawatan'] = $this->Perawatan_model->getAllPerawatan();

        

        if($this->input->post('keyword')) {

            $data['perawatan'] = $this->Perawatan_model->cariDataPerawatan();

        }



        // Jika ada post data

        if($this->input->post()) {

            $config['upload_path'] = './assets/images/';

            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $config['max_size'] = 2048;

            $config['encrypt_name'] = TRUE;



            $this->upload->initialize($config);



            if ($this->upload->do_upload('poto')) {

                $upload_data = $this->upload->data();

                

                $data_insert = [

                    'nama' => $this->input->post('nama'),

                    'poto' => $upload_data['file_name'],

                    'harga' => $this->input->post('harga')

                ];



                $this->db->insert('perawatan', $data_insert);

                $this->session->set_flashdata('flash', 'ditambahkan');

                redirect('perawatan_admin');

            } else {

                $this->session->set_flashdata('error', $this->upload->display_errors());

            }

        }



        $this->load->view('templates/header_admin', $data);

        $this->load->view('perawatan_admin/index', $data);

        $this->load->view('templates/footer_admin');



    }



    public function ubah()

    {

        $id = $this->input->post('id');

        

        // Ambil data lama

        $old_data = $this->db->get_where('perawatan', ['id' => $id])->row_array();



        // Konfigurasi upload

        $config['upload_path'] = './assets/images/';

        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $config['max_size'] = 2048;

        $config['encrypt_name'] = TRUE;



        $this->upload->initialize($config);



        // Jika ada file yang diupload

        if (!empty($_FILES['poto']['name'])) {

            if ($this->upload->do_upload('poto')) {

                // Hapus file lama jika ada

                if ($old_data['poto'] && file_exists('./assets/images/' . $old_data['poto'])) {

                    unlink('./assets/images/' . $old_data['poto']);

                }



                $new_foto = $this->upload->data('file_name');

                

                $data = [

                    'nama' => $this->input->post('nama'),

                    'poto' => $new_foto,

                    'harga' => $this->input->post('harga')

                ];

            } else {

                $this->session->set_flashdata('error', $this->upload->display_errors());

                redirect('perawatan_admin');

            }

        } else {

            // Jika tidak ada file baru yang diupload

            $data = [

                'nama' => $this->input->post('nama'),

                'harga' => $this->input->post('harga')

            ];

        }



        // Update data

        $this->db->where('id', $id);

        $this->db->update('perawatan', $data);

        

        $this->session->set_flashdata('flash', 'diubah');

        redirect('perawatan_admin');

    }



    public function hapus($id)

    {

        // Ambil data untuk hapus file

        $perawatan = $this->db->get_where('perawatan', ['id' => $id])->row_array();

        

        // Hapus file foto jika ada

        if ($perawatan['poto'] && file_exists('./assets/images/' . $perawatan['poto'])) {

            unlink('./assets/images/' . $perawatan['poto']);

        }



        $this->Perawatan_model->hapusDataPerawatan($id);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect('perawatan_admin');

    }

}
?>