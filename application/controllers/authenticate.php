<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class authenticate extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sfs_user_model', 'sum');
    }

    public function index() {
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $data['page_title'] = 'Login';
            $this->load->view('login', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    function validateUser() {
        $result = $this->sum->check_login();

        if (is_array($result)) {
            if ($result[0]->role == 'F') {
                redirect(FACULTY_URL . 'dashboard', 'refresh');
            } elseif ($result[0]->role == 'S') {
                redirect(STUDENT_URL . 'dashboard', 'refresh');
            } elseif ($result[0]->role == 'A') {
                $newdata = array('feedback_session' => $result[0], 'logged_in' => TRUE, 'type' => 'admin');
                $this->session->set_userdata($newdata);
                redirect(ADMIN_URL . 'dashboard', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                redirect(base_url() . 'login', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid Username or Password');
            redirect(base_url() . 'login', 'refresh');
        }
    }

    function logout() {
        $this->session->unset_userdata('feedback_session');
        $this->session->sess_destroy();
        redirect(base_url() .'login', 'refresh');
    }

}
