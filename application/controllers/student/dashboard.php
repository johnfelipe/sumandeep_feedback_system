<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
           redirect(base_url() .'login', 'refresh');
        }
    }

    public function index() {
        $session = $this->session->userdata('feedback_session');
        if (empty($session) && $session->user_type != 'student') {
            $this->session->flashdata('error', 'Please Login First');
            redirect(base_url() . 'login', 'refresh');
        } else {
            $this->student_layout->view('student/dashobard');
        }
    }

}
