<?php
/**
 * Created by PhpStorm.
 * User: JAVAN
 * Date: 05/02/2018
 * Time: 10.51
 */

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function login($usernameEmail, $password, $role)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('usernameEmail', 'Nama Pengguna/E-Mail', 'required|min_length[1]|max_length[64]', array(
            'required' => '%s harus diisi.',
            'min_length' => '% minimal 1 karakter.',
            'max_length' => '% maksimal 64 karakter.'
        ));
        $this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[4]|max_length[64]', array(
            'required' => '%s harus diisi.',
            'min_length' => '%s minimal 4 karakter.',
            'max_length' => '%s maksimal 64 karakter.'
        ));

        if (! $this->form_validation->run()) {
            return false;
        }

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('(username = "' . $usernameEmail . '" OR email = "' .$usernameEmail. '") AND role = "' .$role. '"');
        $this->db->limit(1);
        $model = $this->db->get()->row_object();

        if (! $model) {
            $this->session->set_flashdata('message_error', 'Nama Pengguna/E-Mail yang kamu masukkan salah.');
        } elseif (! $this->validPassword($password, $model->password)) {
            $this->session->set_flashdata('message_error', 'Password yang kamu masukkan salah.');
        } elseif ($model && $this->validPassword($password, $model->password)) {
            $this->session->set_userdata('user', $model);

            return true;
        }

        return false;
    }

    public function validPassword($password, $hashedPassword)
    {
        $this->load->library('encryption');
        $decrypt = $this->encryption->decrypt($hashedPassword);

        if ($password == $decrypt) {
            return true;
        }

        return false;
    }
}