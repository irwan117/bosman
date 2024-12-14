<?php 

  /**
   * summary
   */
    class Styling_model extends CI_model{
        public function getAllStyling()
    {
        return $this->db->get('styling')->result_array();
        
    }
      
        public function tambahDataStyling()
        {
            $data =[
                "nama"=>$this->input->post('nama',true),
                "poto"=>$this->input->post('poto',true),
                "harga"=>$this->input->post('harga',true),
            ];
            $this->db->insert('styling', $data);
        }
        
        public function getStylingById($id)
        {
            return $this->db->get_where('styling', ['id' =>$id])->row_array();
        }

        public function cariDataStyling()
        {
            $keyword = $this->input->post('keyword', true);
            $this->db->like('nama', $keyword);
            $this->db->or_like('harga', $keyword);
            return $this->db->get('styling')->result_array();
        }
    

        
        public function ubahDataStyling($id)
        {
            $data = [
                "nama" => $this->input->post('nama', true),
                "harga" => $this->input->post('harga', true),

            ];
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('styling',$data);
        }
        
        public function hapusDataStyling($id)
        {
            $this->db->where('id',$id);
            $this->db->delete('styling');

        }
    }

