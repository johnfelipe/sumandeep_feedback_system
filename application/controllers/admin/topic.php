<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class topic extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Topic Managment');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
           redirect(base_url() .'login', 'refresh');
        }
    }

    public function index($subjectid) {
        $this->admin_layout->setField('page_title', 'Topic Managment');
        $data['subject_detail'] = $this->sfs_subject_model->getWhere(array('subjectid' => $subjectid));
        $this->admin_layout->view('admin/topic/list', $data);
    }

    public function manage($subjectid, $topicid = null) {
        $this->admin_layout->setField('page_title', 'Manage Topic');

        $data['subject_detail'] = $this->sfs_subject_model->getWhere(array('subjectid' => $subjectid));

        if ($topicid != null) {
            $data['topic_detail'] = $this->sfs_subject_topic_model->getWhere(array('topicid' => $topicid));
        } else {
            $data['topic_detail'] = null;
        }

        $this->admin_layout->view('admin/topic/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_subject_topic_model();

        $obj->topic_name = $this->input->post('topic_name');
        $obj->subjectid = $this->input->post('subjectid');

        if ($this->input->post('topicid') != '') {
            $obj->topicid = $this->input->post('topicid');
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

        redirect(ADMIN_URL . 'topic/' . $obj->subjectid . '/0', 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_to();
        $res = $obj->getWhere(array('topicid' => $id));

        if (is_array($res) && count($res) == 1) {
            $obj->topicid = $id;
            $check = $obj->deleteData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Student Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Updating the Student');
            }
        } else {
            $this->session->set_flashdata('error', 'Error while Updating the Student');
        }
    }

    function getJson($subjectid) {
        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'topic/manage/' . $value->subjectid . '/' . $value->topicid . '">' . $value->topic_name . '</a>';
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" id="' . $value->subjectid . '" class="deletepage icon-trash"></a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

}

?>
