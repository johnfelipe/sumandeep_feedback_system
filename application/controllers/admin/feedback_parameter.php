<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback_parameter extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Feedback Parameters');
        $this->load->model('sfs_feedback_parameters_model');
    }

    public function index() {
        $this->admin_layout->setField('page_title', 'Feedback Parameters Managment');
        $this->admin_layout->view('admin/feedback_parameter/list');
    }

    public function manage($cid = null) {
        $this->admin_layout->setField('page_title', 'Manage Feedback Parameters');

        if ($cid != null) {
            $data['feedback_parameter_detail'] = $this->sfs_feedback_parameters_model->getWhere(array('paramterid' => $cid));
        } else {
            $data['feedback_parameter_detail'] = null;
        }

        $this->admin_layout->view('admin/feedback_parameter/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_feedback_parameters_model();

        $obj->parameter_name = $this->input->post('parameter_name');
        $obj->role = $this->input->post('role');
        $obj->status = $this->input->post('status');

        if ($this->input->post('paramterid') != '') {
            $obj->paramterid = $this->input->post('paramterid');
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


        redirect(ADMIN_URL . 'feedback_parameter', 'refresh');
    }

    function changeStatus($id) {
        $obj = new sfs_feedback_parameters_model();
        $res = $obj->getWhere(array('paramterid' => $id));

        if (is_array($res) && count($res) == 1) {
            $obj->paramterid = $id;
            
            if ($res[0]->status == 'A') {
                $obj->status = 'D';
            } else {
                $obj->status = 'A';
            }
            
            $check = $obj->updateData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Updating the Data');
            }
            
        } else {
            $this->session->set_flashdata('error', 'Error while Updating the Data');
        }
    }
    
    function changeRole($id) {
        $obj = new sfs_feedback_parameters_model();
        $res = $obj->getWhere(array('paramterid' => $id));

        if (is_array($res) && count($res) == 1) {
            $obj->paramterid = $id;
            
            if ($res[0]->role == 'S') {
                $obj->role = 'F';
            } else {
                $obj->role = 'S';
            }
            
            $check = $obj->updateData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Updating the Data');
            }
            
        } else {
            $this->session->set_flashdata('error', 'Error while Updating the Data');
        }
    }

    function getJson() {
        $records = $this->sfs_feedback_parameters_model->getAll();
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'feedback_parameter/manage/' . $value->paramterid . '">' . $value->parameter_name . '</a>';
            if ($value->role == 'S') {
                $role = 'Student';
            } else if ($value->role == 'F') {
                $role = 'Faculty';
            } else {
                $role = '';
            }
            
            $temp_arr[] = '<a href="javascript:;" onclick="changeRole(this)" class="parameter-role" id="' . $value->paramterid . '">' . $role . '</a>';

            if ($value->status == 'A') {
                $status = '<span class="label label-success">Active</span>';
            } else {
                $status = '<span class="label label-danger">Deactive</span>';
            }
            $temp_arr[] = '<a href="javascript:;" onclick="changeStatus(this)" class="parameter-status" id="' . $value->paramterid . '">' . $status . '</a>';

            $arra[] = $temp_arr;
        }
        return $arra;
    }

}

?>
