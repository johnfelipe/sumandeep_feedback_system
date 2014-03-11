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

        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function index() {
        $this->student_layout->view('student/feedback/list');
    }

    function getJson() {
        $this->load->library('datatable');
        $session = $this->session->userdata('feedback_session');
        $this->datatable->aColumns = array('f.feedback_date', 'u.fullname', 's.subject_name', 't.topic_name', 'f.*');
        $this->datatable->eColumns = array('f.faculty_feedback_id');
        $this->datatable->sIndexColumn = "f.faculty_feedback_id";
        $this->datatable->sTable = " sfs_faculty_feedback_master f, sfs_subject s, sfs_user u, sfs_subject_topic t";
        $this->datatable->myWhere = "WHERE f.facultyid=u.userid AND f.subjectid=s.subjectid AND f.topicid=t.topicid AND f.studentid = " . $session->userid;
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = date('d-m-Y', strtotime($aRow['feedback_date']));
            $temp_arr[] = $aRow['fullname'];
            $temp_arr[] = $aRow['subject_name'];
            $temp_arr[] = $aRow['topic_name'];
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
            echo '<option value="' . $value->topicid . '">' . $value->topic_name . '</option>';
        }
    }

    function checkTime() {
        $session = $this->session->userdata('feedback_session');
        $get = $this->sfs_faculty_feedback_master_model->getWhere(array('studentid' => $session->userid, 'subjectid' => $_POST['subjectid'], 'topicid' => $_POST['topicid'], 'topic_time_from' => $_POST['topic_time_from'], 'topic_time_to' => $_POST['topic_time_to'], 'feedback_date' => get_current_date_time()->get_date_for_db()));

        if (count($get) == 1) {
            echo 'true';
        } else {
            echo 'false';
        }
        exit;
    }

    function save() {
        $parameters = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'F'));
        $session = $this->session->userdata('feedback_session');

        $obj_master = new sfs_faculty_feedback_master_model();
        $obj_master->studentid = $session->userid;
        $obj_master->sid = $this->input->post('sid');
        $obj_master->facultyid = $this->input->post('facultyid');
        $obj_master->subjectid = $this->input->post('subjectid');
        $obj_master->topicid = $this->input->post('topicid');
        $obj_master->feedback_date = date('Y-m-d', strtotime($this->input->post('feedback_date')));
        $obj_master->topic_time_from = date('H:i', strtotime($this->input->post('topic_time_from')));
        $obj_master->topic_time_to = date('H:i', strtotime($this->input->post('topic_time_to')));

        $master_id = $obj_master->insertData();

        foreach ($parameters as $param) {
            $obj_detail = new sfs_faculty_feedback_details_model();

            $obj_detail->faculty_feedback_id = $master_id;
            $obj_detail->parameterid = $param->paramterid;

            $score = $this->input->post('ratting_' . $param->paramterid);

            if ($score != '') {
                $obj_detail->ratting = $score;
            } else {
                $obj_detail->ratting = '0';
            }

            $obj_detail->insertData();
        }

        redirect(STUDENT_URL . 'feedback', 'refresh');
    }

    function view_feedback($feedbackid) {
        $data['feedback_master'] = $this->sfs_faculty_feedback_master_model->getMasterFeedback($feedbackid);

        $data['parameters'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'F'));

        $this->student_layout->view('student/feedback/view_feedback', $data);
    }

}
