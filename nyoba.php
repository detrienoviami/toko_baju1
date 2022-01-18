#ini nyoba
<?php
class M_Registrasi extends CI_Model{

    public function registrasi()
    {
      $data = array(
        'nama' => $this->input->post('nama', true),
        'username' => $this->input->post('username', true),
        'level' => 'KLO',
        'status' => 'non aktif',
        'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
      );

      $this->db->insert('t_user', $data);
      $id_user = $this->db->insert_id();

      if ($id_user) {

        $c_t = microtime(true);
        $c_micro = sprintf("%06d",($c_t - floor($c_t)) * 1000000);
        $c_datetime = new DateTime( date('Y-m-d H:i:s.'.$c_micro, $c_t) );
        $nip = "KRY".$c_datetime->format("YmdHisu");

        $data1 = array(
          'nip' => $nip,
          'id_user' => $id_user,
          'nama' => $this->input->post('nama', true),
        );

        $ins_karyawan = $this->db->insert('t_karyawan', $data1);
      }
    }

    public function get_data_register()
    {
      $query = $this->db->select(`t_user.*,t_karyawan.*`)
                      ->from('t_user a')
                      ->join('t_karyawan b', 'a.id_user = b.id_user')
                      ->get();
        return $query->row_array();
    }

  }

?>
