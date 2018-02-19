<?php
/**
 * Created by PhpStorm.
 * User: JAVAN
 * Date: 05/02/2018
 * Time: 09.59
 */

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->model(array('user_model'));
    }

    public function getCsrf()
    {
        //$csrf = array($this->security->get_csrf_token_name() => $this->security->get_csrf_hash());
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($csrf));
    }

    public function noSession()
    {
        if (! $this->session->userdata('user')) {
            $this->session->set_flashdata('message_error', 'Kamu belum login.');
            $this->session->set_userdata('current_url', current_url());

            redirect('admin/user/login');
        }
    }

    public function login()
    {
        if ($this->input->method(TRUE) == 'POST' && $this->user_model->login($this->input->post('usernameEmail'), $this->input->post('password'), 1)) {
            if ($this->session->userdata('current_url')) {
                $this->session->mark_as_flash('current_url');

                redirect($this->session->flashdata('current_url'));
            } else {
                redirect('admin/user/profile');
            }
        }

        $this->load->view('admin/login');
    }

    public function logout()
    {
        $this->noSession();

        if ($this->input->method(TRUE) != 'POST') {
            show_error('Aksi tidak di perbolehkan.', 405, 'Terjadi Kesalahan');

            die(405);
        }

        $this->session->sess_destroy();
        $this->session->set_flashdata('message_info', 'Kamu sudah keluar dari sesi.');

        redirect('admin/user/login');
    }

    public function index()
    {
        $this->noSession();

        $this->load->view('admin/index');
    }

    public function profile()
    {
        $this->noSession();

        $this->load->view('admin/profile');
    }
}