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
        $this->load->library('datatable');
        $session = $this->session->userdata('feedback_session');
        $this->datatable->aColumns = array('u.fullname', 's.subject_name', 't.topic_name', 'p.parameter_name', 'f.*');
        $this->datatable->eColumns = array('f.student_feedback_id');
        $this->datatable->sIndexColumn = "f.student_feedback_id";
        $this->datatable->sTable = " sfs_student_feedback f, sfs_subject s, sfs_user u, sfs_subject_topic t, sfs_feedback_parameters p";
        $this->datatable->myWhere = "WHERE f.studentid=u.userid AND f.subjectid=s.subjectid AND p.paramterid = f.parameterid AND f.topicid=t.topicid AND f.facultyid = " . $session->userid;
        $this->datatable->sOrder = "order by f.student_feedback_id desc";
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['fullname'];
            $temp_arr[] = $aRow['subject_name'];
            $temp_arr[] = $aRow['topic_name'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['feedback_date']));
            $temp_arr[] = date('H:i a', strtotime($aRow['topic_time_from'])) . ' : ' . date('H:i a', strtotime($aRow['topic_time_to']));
            $temp_arr[] = $aRow['ratting'];
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
        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
        echo '<option value="">Select Topic</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->subjectid . '">' . $value->topic_name . '</option>';
        }
    }

    function save() {
        $sid = $this->input->post('sid');
        $parameters = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));
        $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
        $session = $this->session->userdata('feedback_session');
        foreach ($student_list as $student) {
            foreach ($parameters as $param) {
                $where = array(
                    'studentid' => $student->userid,
                    'facultyid' => $session->userid,
                    'parameterid' => $param->paramterid,
                    'subjectid' => $this->input->post('subjectid'),
                    'topicid' => $this->input->post('topicid'),
                    'feedback_date' => date('Y-m-d', strtotime($this->input->post('feedback_date'))),
                    'topic_time_from' => date('H:i', strtotime($this->input->post('topic_time_from'))),
                    'topic_time_to' => date('H:i', strtotime($this->input->post('topic_time_to'))),
                );
                $obj = new sfs_student_feedback_model();
                $check = $obj->getWhere($where);

                $obj->studentid = $student->userid;
                $obj->facultyid = $session->userid;
                $obj->parameterid = $param->paramterid;
                $obj->subjectid = $this->input->post('subjectid');
                $obj->topicid = $this->input->post('topicid');
                $obj->feedback_date = date('Y-m-d', strtotime($this->input->post('feedback_date')));
                $obj->topic_time_from = date('H:i', strtotime($this->input->post('topic_time_from')));
                $obj->topic_time_to = date('H:i', strtotime($this->input->post('topic_time_to')));
                $score = $this->input->post('ratting_' . $param->paramterid . '_' . $student->userid);
                if ($score != '') {
                    $obj->ratting = $score;
                } else {
                    $obj->ratting = '1';
                }

                if (is_array($check) && count($check) == 1) {
                    $obj->student_feedback_id = $check[0]->student_feedback_id;
                    $obj->updateData();
                } else {
                    $obj->insertData();
                }
            }
        }

        redirect(FACULTY_URL . 'feedback', 'refresh');
    }

}
