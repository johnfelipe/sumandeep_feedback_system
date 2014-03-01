<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class course extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Course');
        $this->load->model('sfs_course_model');
    }

    public function index() {
        $this->admin_layout->setField('page_title', 'Course Managment');
        $this->admin_layout->view('admin/course/list');
    }

    public function manage($cid = null) {
        $this->admin_layout->setField('page_title', 'Manage Course');

        if ($cid != null) {
            $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $cid));
        } else {
            $data['course_detail'] = null;
        }

        $this->admin_layout->view('admin/course/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_course_model();

        $obj->course_name = $this->input->post('course_name');

        if ($this->input->post('cid') != '') {
                $obj->cid = $this->input->post('cid');
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


        redirect(ADMIN_URL . 'course', 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_course_model();
        $res = $obj->getWhere(array('cid' => $id));
        if (is_array($res) && count($res) == 1) {
            $obj->cid = $id;
            $check = $obj->deleteData();
            if ($check == true) {
                $this->session->set_flashdata('success', 'Deleted the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Deleting the Data');
            }
        } else {
            $this->session->set_flashdata('error', 'Error while Deleting the Data');
        }
        redirect(ADMIN_URL . 'course', 'refresh');
    }

    function getJson() {
        $records = $this->sfs_course_model->getAll();
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'course/manage/' . $value->cid . '">' . $value->course_name . '</a>';
            $temp_arr[] = '<a href="' . ADMIN_URL . 'semester/' . $value->cid . '">Click Here</a>';
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="deletepage icon-trash" id="' . $value->cid . '"></a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

}

?>
