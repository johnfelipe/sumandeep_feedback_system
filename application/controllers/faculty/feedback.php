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
        $this->datatable->aColumns = array('u.fullname', 's.subject_name', 't.topic_name', 'p.parameter_name', 'f.*');
        $this->datatable->eColumns = array('f.student_feedback_id');
        $this->datatable->sIndexColumn = "f.student_feedback_id";
        $this->datatable->sTable = " sfs_student_feedback f, sfs_subject s, sfs_user u, sfs_subject_topic t, sfs_feedback_parameters p";
        $this->datatable->myWhere = "WHERE ";
        $this->datatable->sOrder = "order by housenumber desc";
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = '<a href="' . ADMIN_BASE_URL . 'customer/edit/' . $this->encrypt->encode($aRow['customerid'], $this->config->item('my_encrypt_key')) . '">' . $aRow['customer_name'] . '</a>';
            $temp_arr[] = $aRow['housenumber'];
            $temp_arr[] = $aRow['mobileno'];
            $temp_arr[] = $aRow['stb_no'];
            $temp_arr[] = $aRow['name'];
            $temp_arr[] = '<a href="' . ADMIN_BASE_URL . 'customer/history/' . $this->encrypt->encode($aRow['customerid'], $this->config->item('my_encrypt_key')) . '">' . $this->lang->line('click_here') . '</a>';
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="deletepage icon-trash" id="' . $aRow['customerid'] . '"></a>';
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
        
        
        $session = $this->session->userdata('feedback_session');
        $records = $this->sfs_student_feedback_model->getwhere(array('facultyid'=>$session->userid));
        $array = $this->getArrayForJson($records);
        $data['aaData'] = $array;
        if (is_array($data)) {
            echo json_encode($data);
        }
    }

   /* function getArrayForJson($objects) {
        $arra = array();
        foreach ($objects as $value) {
            $temp_arr = array();
            $temp_arr[] = $value->studentid;
            $temp_arr[] = $value->subjectid;
            $temp_arr[] = $value->topicid;
            $temp_arr[] = $value->feedback_date;
            $temp_arr[] = $value->topic_time_from .' : ' . $value->topic_time_to;
            $temp_arr[] = $value->ratting;
            $arra[] = $temp_arr;
        }
        return $arra;
    }*/

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
                $obj = new sfs_student_feedback_model();
                $obj->studentid = $student->userid;
                $obj->facultyid = $session->userid;
                $obj->parameterid = $param->paramterid;
                $obj->subjectid = $this->input->post('subjectid');
                $obj->topicid = $this->input->post('topicid');
                $obj->feedback_date = date('Y-m-d', strtotime($this->input->post('feedback_date')));
                $obj->topic_time_from = $this->input->post('topic_time_from');
                $obj->topic_time_to = $this->input->post('topic_time_to');
                $score = $this->input->post('ratting_' . $param->paramterid . '_' . $student->userid);
                if ($score != '') {
                    $obj->ratting = $score;
                } else {
                    $obj->ratting = '1';
                }
                
                $obj->insertData();
            }
        }
        
        redirect(FACULTY_URL . 'feedback', 'refresh');
    }

}
