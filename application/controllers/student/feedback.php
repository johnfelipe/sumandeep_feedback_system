<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sfs_faculty_feedback_master_model');
        $this->load->model('sfs_faculty_feedback_details_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_assign_faculty_model');
        $this->load->model('sfs_feedback_parameters_model');
    }

    public function index() {
        $this->student_layout->view('student/feedback/list');
    }

    function getJson() {
        $this->load->library('datatable');
        $session = $this->session->userdata('feedback_session');
        $this->datatable->aColumns = array('u.fullname', 's.subject_name', 't.topic_name', 'f.*');
        $this->datatable->eColumns = array('f.faculty_feedback_id');
        $this->datatable->sIndexColumn = "f.faculty_feedback_id";
        $this->datatable->sTable = " sfs_faculty_feedback_master f, sfs_subject s, sfs_user u, sfs_subject_topic t";
        $this->datatable->myWhere = "WHERE f.facultyid=u.userid AND f.subjectid=s.subjectid AND f.topicid=t.topicid AND f.studentid = " . $session->userid;
        $this->datatable->sOrder = "order by f.faculty_feedback_id desc";
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['fullname'];
            $temp_arr[] = $aRow['subject_name'];
            $temp_arr[] = $aRow['topic_name'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['feedback_date']));
            $temp_arr[] = date('H:i a', strtotime($aRow['topic_time_from'])) . ' : ' . date('H:i a', strtotime($aRow['topic_time_to']));
            $temp_arr[] = '<a href="' . STUDENT_URL . 'feedback/view_feedback/' . $aRow['faculty_feedback_id'] . '">Click Here</a>';
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function add() {
        $session = $this->session->userdata('feedback_session');
        $student = $this->sfs_assign_student_model->getWhere(array('studentid' => $session->userid));
        $data['subject_list'] = $this->sfs_subject_model->getWhere(array('sid' => $student[0]->sid));
        $data['faculty_list'] = $this->sfs_assign_faculty_model->getSemesterFaculty($student[0]->sid);
        $data['parameters_list'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'F'));
        $this->student_layout->view('student/feedback/add', $data);
    }

    function getTopicDetails($subjectid) {
        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
        echo '<option value="">Select Topic</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->subjectid . '">' . $value->topic_name . '</option>';
        }
    }

    function save() {
        $parameters = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'F'));
        $session = $this->session->userdata('feedback_session');

        $obj_master = new sfs_faculty_feedback_master_model();
        $where_master = array(
            'studentid' => $session->userid,
            'facultyid' => $this->input->post('facultyid'),
            'subjectid' => $this->input->post('subjectid'),
            'topicid' => $this->input->post('topicid'),
            'feedback_date' => date('Y-m-d', strtotime($this->input->post('feedback_date'))),
            'topic_time_from' => date('H:i', strtotime($this->input->post('topic_time_from'))),
            'topic_time_to' => date('H:i', strtotime($this->input->post('topic_time_to'))),
        );

        $check_master = $obj_master->getWhere($where_master);
        $master_id = 0;

        $obj_master->studentid = $session->userid;
        $obj_master->facultyid = $this->input->post('facultyid');
        $obj_master->subjectid = $this->input->post('subjectid');
        $obj_master->topicid = $this->input->post('topicid');
        $obj_master->feedback_date = date('Y-m-d', strtotime($this->input->post('feedback_date')));
        $obj_master->topic_time_from = date('H:i', strtotime($this->input->post('topic_time_from')));
        $obj_master->topic_time_to = date('H:i', strtotime($this->input->post('topic_time_to')));

        if (is_array($check_master) && count($check_master) == 1) {
            $obj_master->faculty_feedback_id = $check_master[0]->faculty_feedback_id;
            $obj_master->updateData();
            $master_id = $check_master[0]->faculty_feedback_id;
        } else {
            $master_id = $obj_master->insertData();
        }

        foreach ($parameters as $param) {
            $where_detail = array(
                'faculty_feedback_id' => $master_id,
                'parameterid' => $param->paramterid,
            );

            $obj_detail = new sfs_faculty_feedback_details_model();
            $check_detail = $obj_detail->getWhere($where_detail);

            $obj_detail->faculty_feedback_id = $master_id;
            $obj_detail->parameterid = $param->paramterid;

            $score = $this->input->post('ratting_' . $param->paramterid);

            if ($score != '') {
                $obj_detail->ratting = $score;
            } else {
                $obj_detail->ratting = '1';
            }

            if (is_array($check_detail) && count($check_detail) == 1) {
                $obj_detail->faculty_feedback_detail_id = $check_detail[0]->faculty_feedback_detail_id;
                $obj_detail->updateData();
            } else {
                $obj_detail->insertData();
            }
        }

        redirect(STUDENT_URL . 'feedback', 'refresh');
    }
    
    function view_feedback($feedbackid) {
        $data['feedback_master'] = $this->sfs_faculty_feedback_master_model->getMasterFeedback($feedbackid);
        
        $data['parameters'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'F'));
        
        $this->faculty_layout->view('student/feedback/view_feedback', $data);
    }

}
