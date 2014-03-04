<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sfs_student_feedback_master_model');
        $this->load->model('sfs_student_feedback_details_model');
        $this->load->model('sfs_faculty_feedback_master_model');
        $this->load->model('sfs_faculty_feedback_details_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_feedback_parameters_model');
    }

    public function index($view) {
        $this->admin_layout->view('faculty/feedback/list');
    }

    function student() {
        $data['role'] = 'S';
        $this->admin_layout->view('admin/feedback/list', $data);
    }
    
    function faculty() {
        $data['role'] = 'F';
        $this->admin_layout->view('admin/feedback/list', $data);
    }

    function getJson($role) {
        $this->load->library('datatable');

        $table = '';

        if ($role == 'S') {
            $table = 'sfs_student_feedback_master f';
        } else {
            $table = 'sfs_faculty_feedback_master f';
        }

        $session = $this->session->userdata('feedback_session');
        $this->datatable->aColumns = array('s.subject_name', 't.topic_name', 'f.*');
        $this->datatable->eColumns = array('f.student_feedback_id');
        $this->datatable->sIndexColumn = "f.student_feedback_id";
        $this->datatable->sTable = " $table, sfs_subject s, sfs_subject_topic t";
        $this->datatable->myWhere = "WHERE f.subjectid=s.subjectid AND f.topicid=t.topicid";
        $this->datatable->sOrder = "order by f.student_feedback_id desc";
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['subject_name'];
            $temp_arr[] = $aRow['topic_name'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['feedback_date']));
            $temp_arr[] = date('H:i a', strtotime($aRow['topic_time_from'])) . ' : ' . date('H:i a', strtotime($aRow['topic_time_to']));
            $temp_arr[] = '<a href="' . FACULTY_URL . 'feedback/view_feedback/' . $aRow['student_feedback_id'] . '">Click Here</a>';
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

}
