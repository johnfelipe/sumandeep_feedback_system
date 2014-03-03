<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class faculty extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Faculty');
        $this->load->model('sfs_user_model');
    }

    public function index() {
        $this->admin_layout->setField('page_title', 'Faculty Managment');
        $this->admin_layout->view('admin/faculty/list');
    }

    public function manage($userid = null) {
        $this->admin_layout->setField('page_title', 'Manage Faculty');

        if ($userid != null) {
            $data['faculty_detail'] = $this->sfs_user_model->getWhere(array('userid' => $userid));
        } else {
            $data['faculty_detail'] = null;
        }

        $this->admin_layout->view('admin/faculty/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_user_model();

        $obj->username = $this->input->post('faculty_username');
        $obj->fullname = $this->input->post('faculty_name');
        $obj->status = $this->input->post('status');
        $obj->role = 'F';

        if ($this->input->post('password') != '') {
            $obj->password = md5($this->input->post('password'));
        }



        if ($this->input->post('userid') != '') {
            $obj->userid = $this->input->post('userid');
            $check = $obj->updateData();
            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Editing the Data');
            }
        } else {
            $check = $obj->insertData();
            if ($check == true) {
                $this->session->set_flashdata('success', 'Added the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Adding the Data');
            }
        }


        redirect(ADMIN_URL . 'faculty', 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_user_model();
        $res = $obj->getWhere(array('userid' => $id));

        if (is_array($res) && count($res) == 1) {
            $obj->userid = $id;
            
            if ($res[0]->status == 'A') {
                $obj->status = 'D';
            } else {
                $obj->status = 'A';
            }
            
            $check = $obj->updateData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Faculty Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Updating the Faculty');
            }
            
        } else {
            $this->session->set_flashdata('error', 'Error while Updating the Faculty');
        }

    }

    function getJson() {
        $records = $this->sfs_user_model->getWhere(array('role' => 'F'));
        $array = $this->getArrayForJson($records);
        $data['aaData'] = $array;
        if (is_array($data)) {
            echo json_encode($data);
        }
    }

    function getArrayForJson($objects) {
        $arra = array();
        foreach ($objects as $value) {
            $temp_arr = array();
            $temp_arr[] = '<a href="' . ADMIN_URL . 'faculty/manage/' . $value->userid . '">' . $value->fullname . '</a>';
            if ($value->status == 'A') {
                $status = '<span class="label label-success">Active</span>';
            } else {
                $status = '<span class="label label-danger">Deactive</span>';
            }
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="faculty-status" id="' . $value->userid . '">' . $status . '</a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

}

?>
