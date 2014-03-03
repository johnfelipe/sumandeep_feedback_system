<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sfs_student_feedback_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_feedback_parameters_model');
    }

    public function index() {
        $this->faculty_layout->view('faculty/feedback/list');
    }

    function getJson() {
        $records = $this->sfs_student_feedback_model->getAll();
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

    function add() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->faculty_layout->view('faculty/feedback/add', $data);
    }

    function getSemesterDetails($cid) {
        $records = $this->sfs_semester_model->getWhere(array('cid' => $cid));
        echo '<option value="">Select Semester</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->sid . '">' . $value->semester_name . ' (' . $value->batch . ')' . '</option>';
        }
    }

    function getStudentDetails($sid) {
        $data['parameters'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));
        $data['student_list'] = $this->sfs_assign_student_model->getSemesterStudent($sid);
        echo $this->load->view('faculty/feedback/student_list', $data, true);
    }

    function getSubjectDetails($sid) {
        $records = $this->sfs_subject_model->getWhere(array('sid' => $sid));
        echo '<option value="">Select Subject</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->subjectid . '">' . $value->subject_name . '</option>';
        }
    }

    function getTopicDetails($subjectid) {
        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
        echo '<option value="">Select Topic</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->subjectid . '">' . $value->topic_name . '</option>';
        }
    }

}
