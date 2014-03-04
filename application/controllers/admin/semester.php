<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class semester extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Semester');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_user_model');
    }

    public function index($cid) {
        $this->admin_layout->setField('page_title', 'Semester Managment');
        $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $cid));
        $this->admin_layout->view('admin/semester/list', $data);
    }

    public function manage($cid, $sid = null) {
        $this->admin_layout->setField('page_title', 'Manage Semester');
        $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $cid));
        if ($sid != null) {
            $data['sem_detail'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
        } else {
            $data['sem_detail'] = null;
        }

        $this->admin_layout->view('admin/semester/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_semester_model();

        $obj->semester_name = $this->input->post('sem_name');
        $obj->cid = $this->input->post('cid');
        $obj->batch = $this->input->post('sem_batch');

        if ($this->input->post('sid') != '') {
            $obj->sid = $this->input->post('sid');
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


        redirect(ADMIN_URL . 'semester/' . $this->input->post('cid'), 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_semester_model();
        $res = $obj->getWhere(array('sid' => $id));
        if (is_array($res) && count($res) == 1) {
            $obj->sid = $id;
            $check = $obj->deleteData();
            if ($check == true) {
                $this->session->set_flashdata('success', 'Deleted the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Deleting the Data');
            }
        } else {
            $this->session->set_flashdata('error', 'Error while Deleting the Data');
        }
        redirect(ADMIN_URL . 'semester/' . $res[0]->cid, 'refresh');
    }

    function getJson($cid) {
        $records = $this->sfs_semester_model->getWhere(array('cid' => $cid));
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'semester/manage/' . $value->cid . '/' . $value->sid . '">' . $value->semester_name . '</a>';
            $temp_arr[] = $value->batch;
            $temp_arr[] = '<a href="' . ADMIN_URL . 'subject/' . $value->sid . '">Click Here</a>';
            $temp_arr[] = '<a href="' . ADMIN_URL . 'semester/assign_faculty/' . $value->sid . '">Click Here</a>';
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="deletepage icon-trash" id="' . $value->sid . '"></a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

    function assign_faculty($sid) {
        $this->load->model('sfs_assign_faculty_model');

        $data['faculty_details'] = $this->sfs_user_model->getWhere(array('role' => 'F'));
        $data['sem_detail'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
        $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detail'][0]->cid));
        $faculty_assign_list = $this->sfs_assign_faculty_model->getSemesterFaculty($sid);

        $temp = array();
        foreach ($faculty_assign_list as $list) {
            $temp[] = $list->userid;
        }

        $data['assign_faculty'] = $temp;
        $this->admin_layout->view('admin/semester/assign_faculty', $data);
    }

    function assign_faculty_details() {
        $this->load->model('sfs_assign_faculty_model');

        foreach ($this->input->post('assign_faculty') as $post) {
            $obj = new sfs_assign_faculty_model();
            $check = $obj->getWhere(array('facultyid' => $post, 'sid' => $this->input->post('sid')));
            if (count($check) == 0) {
                $obj->facultyid = $post;
                $obj->sid = $this->input->post('sid');
                $obj->insertData();
            }
        }
        
        redirect(ADMIN_URL . 'semester/semester/' . $this->input->post('cid'), 'refresh');
        
        
    }

}

?>
