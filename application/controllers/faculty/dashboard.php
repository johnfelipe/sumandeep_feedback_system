<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $session = $this->session->userdata('feedback_session');
        if (empty($session) && $session->user_type != 'faculty') {
            $this->session->flashdata('error', 'Please Login First');
            redirect(base_url() . 'login', 'refresh');
        } else {
            $this->faculty_layout->view('faculty/dashobard');
        }
    }

}
