<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sfs_student_feedback_master_model');
        $this->load->model('sfs_student_feedback_details_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_feedback_parameters_model');
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function index() {
        $this->faculty_layout->view('faculty/feedback/list');
    }

    function getJson() {
        $this->load->library('datatable');
        $session = $this->session->userdata('feedback_session');
        $this->datatable->aColumns = array('f.feedback_date', 's.subject_name', 't.topic_name', 'f.*');
        $this->datatable->eColumns = array('f.student_feedback_id');
        $this->datatable->sIndexColumn = "f.student_feedback_id";
        $this->datatable->sTable = " sfs_student_feedback_master f, sfs_subject s, sfs_subject_topic t";
        $this->datatable->myWhere = "WHERE f.subjectid=s.subjectid AND f.topicid=t.topicid AND f.facultyid = " . $session->userid;
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = date('d-m-Y', strtotime($aRow['feedback_date']));
            $temp_arr[] = $aRow['subject_name'];
            $temp_arr[] = $aRow['topic_name'];
            $temp_arr[] = date('H:i a', strtotime($aRow['topic_time_from'])) . ' : ' . date('H:i a', strtotime($aRow['topic_time_to']));
            $temp_arr[] = '<a href="' . FACULTY_URL . 'feedback/view_feedback/' . $aRow['student_feedback_id'] . '">Click Here</a>';
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
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
        $session = $this->session->userdata('feedback_session');

        $feedbacks = $this->sfs_student_feedback_master_model->getWhere(array('feedback_date' => get_current_date_time()->get_date_for_db(), 'facultyid' => $session->userid));

        $temp = array();
        foreach ($feedbacks as $feedback) {
            $temp[] = $feedback->topicid;
        }

        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
        echo '<option value="">Select Topic</option>';
        foreach ($records as $value) {
            if (!in_array($value->topicid, $temp)) {
                echo '<option value="' . $value->topicid . '">' . $value->topic_name . '</option>';
            }
        }
    }

    function save() {
        $sid = $this->input->post('sid');
        $parameters = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));
        $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
        $session = $this->session->userdata('feedback_session');

        $where_master = array(
            'facultyid' => $session->userid,
            'subjectid' => $this->input->post('subjectid'),
            'topicid' => $this->input->post('topicid'),
            'feedback_date' => date('Y-m-d', strtotime($this->input->post('feedback_date'))),
            'topic_time_from' => date('H:i', strtotime($this->input->post('topic_time_from'))),
            'topic_time_to' => date('H:i', strtotime($this->input->post('topic_time_to'))),
        );

        $obj_master = new sfs_student_feedback_master_model();
        $check_master = $obj_master->getWhere($where_master);
        $master_id = 0;

        $obj_master->facultyid = $session->userid;
        $obj_master->subjectid = $this->input->post('subjectid');
        $obj_master->topicid = $this->input->post('topicid');
        $obj_master->feedback_date = date('Y-m-d', strtotime($this->input->post('feedback_date')));
        $obj_master->topic_time_from = date('H:i', strtotime($this->input->post('topic_time_from')));
        $obj_master->topic_time_to = date('H:i', strtotime($this->input->post('topic_time_to')));

        if (is_array($check_master) && count($check_master) == 1) {
            $obj_master->student_feedback_id = $check_master[0]->student_feedback_id;
            $obj_master->updateData();
            $master_id = $check_master[0]->student_feedback_id;
        } else {
            $master_id = $obj_master->insertData();
        }



        foreach ($student_list as $student) {
            foreach ($parameters as $param) {
                $where_detail = array(
                    'student_feedback_id' => $master_id,
                    'studentid' => $student->userid,
                    'parameterid' => $param->paramterid,
                );

                $obj_detail = new sfs_student_feedback_details_model();
                $check_detail = $obj_detail->getWhere($where_detail);

                $obj_detail->student_feedback_id = $master_id;
                $obj_detail->studentid = $student->userid;
                $obj_detail->parameterid = $param->paramterid;
                $score = $this->input->post('ratting_' . $param->paramterid . '_' . $student->userid);
                if ($score != '') {
                    $obj_detail->ratting = $score;
                } else {
                    $obj_detail->ratting = '1';
                }

                if (is_array($check_detail) && count($check_detail) == 1) {
                    $obj_detail->student_feedback_detail_id = $check_detail[0]->student_feedback_detail_id;
                    $obj_detail->updateData();
                } else {
                    $obj_detail->insertData();
                }
            }
        }

        redirect(FACULTY_URL . 'feedback', 'refresh');
    }

    function view_feedback($feedbackid) {
        $data['feedback_master'] = $this->sfs_student_feedback_master_model->getMasterFeedback($feedbackid);
        $data['feedback_detail'] = $this->sfs_student_feedback_details_model->getDetailFeedback($feedbackid);

        $data['parameters'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));
        $data['student_list'] = $this->sfs_assign_student_model->getSemesterStudent($data['feedback_master'][0]->sid);

        $this->faculty_layout->view('faculty/feedback/view_feedback', $data);
    }

}
