<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subject extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Subject');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_subject_model');
    }

    public function index($sid) {
        $this->admin_layout->setField('page_title', 'Subject Managment');
        $data['sem_detail'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
        $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detail'][0]->cid));
        $this->admin_layout->view('admin/subject/list', $data);
    }

    public function manage($sid, $subjectid = null) {
        $this->admin_layout->setField('page_title', 'Manage Semester');
        
        $data['sem_detail'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
        $data['course_detail'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detail'][0]->cid));
        
        if ($subjectid != null) {
            $data['subject_detail'] = $this->sfs_subject_model->getWhere(array('subjectid' => $subjectid));
        } else {
            $data['subject_detail'] = null;
        }

        $this->admin_layout->view('admin/subject/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_subject_model();

        $obj->subject_name = $this->input->post('subject_name');
        $obj->sid = $this->input->post('sid');
        if ($this->input->post('subjectid') != '') {
                $obj->subjectid = $this->input->post('subjectid');
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


        redirect(ADMIN_URL . 'subject/' . $this->input->post('sid') , 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_subject_model();
        $res = $obj->getWhere(array('subjectid' => $id));
        if (is_array($res) && count($res) == 1) {
            $obj->subjectid = $id;
            $check = $obj->deleteData();
            if ($check == true) {
                $this->session->set_flashdata('success', 'Deleted the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Deleting the Data');
            }
        } else {
            $this->session->set_flashdata('error', 'Error while Deleting the Data');
        }
        redirect(ADMIN_URL . 'subject', 'refresh');
    }

    function getJson($sid) {
        $records = $this->sfs_subject_model->getWhere(array('sid'=>$sid));
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'subject/manage/' . $value->sid .'/' . $value->subjectid . '">' . $value->subject_name . '</a>';
            $temp_arr[] = '<a href="' . ADMIN_URL . 'topic/' . $value->subjectid . '/0">View Topics</a>';
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="deletepage icon-trash" id="' . $value->subjectid . '"></a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

}

?>
