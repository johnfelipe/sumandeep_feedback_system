<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
            redirect(base_url() . 'login', 'refresh');
        }

        $this->load->model('sfs_user_model');
    }

    public function index() {
        $session = $this->session->userdata('feedback_session');
        $data['profile'] = $this->sfs_user_model->getWhere(array('userid' => $session->userid));
        $this->student_layout->view('faculty/profile/edit_profile', $data);
    }

    function checkusername($userid) {
        $get = $this->sfs_user_model->getWhere(array('username' => urldecode($_GET['student_username'])));
        if (count($get) == 1 && $get[0]->userid != $userid) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    function checkemail($userid) {
        $get = $this->sfs_user_model->getWhere(array('email' => urldecode($_GET['email'])));
        if (count($get) == 1 && $get[0]->userid != $userid) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    function checkOldPassword() {
        $session = $this->session->userdata('feedback_session');
        $get = $this->sfs_user_model->getWhere(array('userid' => $session->userid, 'password' => md5($_GET['old_password'])));
        if (count($get) == 1) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function updateProfile() {
        $obj = new sfs_user_model();

        $obj->username = $this->input->post('faculty_username');
        $obj->fullname = $this->input->post('faculty_name');
        $obj->email = $this->input->post('email');
        $session = $this->session->userdata('feedback_session');
        $obj->userid = $session->userid;
        $check = $obj->updateData();

        if ($check == true) {
            $this->session->set_flashdata('success', 'Update the your profile Successfully');
        } else {
            $this->session->set_flashdata('error', 'Error while Editing your profile');
        }

        redirect(FACULTY_URL . 'profile', 'refresh');
    }

    function updatePassword() {
        $obj = new sfs_user_model();

        $obj->password = md5($this->input->post('password'));
        $session = $this->session->userdata('feedback_session');
        $obj->userid = $session->userid;
        $check = $obj->updateData();

        if ($check == true) {
            $this->session->set_flashdata('success', 'Password Change Successfuly');
        } else {
            $this->session->set_flashdata('error', 'Error while changing Password');
        }

        redirect(FACULTY_URL . 'password_change', 'refresh');
    }

    function changePassword() {
        $this->student_layout->view('faculty/profile/change_password');
    }

}
