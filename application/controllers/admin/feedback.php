<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class feedback extends CI_Controller {

    function __construct() {
        parent::__construct();

        $session = $this->session->userdata('feedback_session');
        if (empty($session) && $session->user_type != 'admin') {
            $this->session->set_flashdata('error', 'Login First');
            redirect(base_url() . 'login', 'refresh');
        }

        $this->load->model('sfs_user_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_subject_model');
        $this->load->model('sfs_subject_topic_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_assign_faculty_model');
        $this->load->model('sfs_student_feedback_master_model');
        $this->load->model('sfs_student_feedback_details_model');
    }

    public function index() {
        redirect(ADMIN_URL . 'dashboard', 'refresh');
    }

    public function ViewStudentFeedback() {
        $this->admin_layout->view('admin/feedback/student_feedback_main_view');
    }

    function getSemesterDetails($cid) {
        $records = $this->sfs_semester_model->getWhere(array('cid' => $cid));
        echo '<option value="">Select Semester</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->sid . '">' . $value->semester_name . ' (' . $value->batch . ')' . '</option>';
        }
    }

    function getStudentDetails($sid) {
        $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
        echo '<option value="0">All Student</option>';
        foreach ($student_list as $value) {
            echo '<option value="' . $value->userid . '">' . $value->fullname . '</option>';
        }
    }

    function getSubjectDetails($sid) {
        $records = $this->sfs_subject_model->getWhere(array('sid' => $sid));
        echo '<option value="0">All Subject</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->subjectid . '">' . $value->subject_name . '</option>';
        }
    }

    function getTopicDetails($subjectid) {
        $records = $this->sfs_subject_topic_model->getWhere(array('subjectid' => $subjectid));
        echo '<option value="0">All Topic</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->topicid . '">' . $value->topic_name . '</option>';
        }
    }

    function getFacultyDetails($sid) {
        $records = $this->sfs_assign_faculty_model->getSemesterFaculty($sid);
        echo '<option value="">Select Faculty</option>';
        foreach ($records as $value) {
            echo '<option value="' . $value->userid . '">' . $value->fullname . '</option>';
        }
    }

    function subjectwiselistener() {
        if ($this->input->post('subjectid') == 0 && $this->input->post('userid') == 0) {
            $this->session->set_flashdata('info', 'All Subject & All Student Report is still under construction. Please Select either any SUBJECT or any STUDENT.');
            redirect(ADMIN_URL . 'report/feedback/student_subjectwise', 'refresh');
        } else if ($this->input->post('subjectid') != 0 && $this->input->post('userid') == 0) {
            $sid = $this->input->post('sid');
            $subjectid = $this->input->post('subjectid');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');

            if (!empty($date_from)) {
                $date_from = date('Y-m-d', strtotime($date_from));
            }

            if (!empty($date_to)) {
                $date_to = date('Y-m-d', strtotime($date_to));
            }

            $obj_master = new sfs_student_feedback_master_model();
            $feedback = $obj_master->getFeedbackId(array('sid' => $sid, 'subjectid' => $subjectid));


            if (!is_null($feedback) && !empty($feedback)) {
                $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
                $student_details = array();
                foreach ($student_list as $value) {
                    $obj_detail = new sfs_student_feedback_details_model();
                    $avg = $obj_detail->getAverageOfSingleStudent($feedback, $value->userid);
                    $med = $obj_detail->getMedianOfSingleStudent($feedback, $value->userid);
                    $temp = array();
                    $temp['name'] = $value->fullname;
                    $temp['average'] = $avg;
                    $temp['median'] = $med;
                    $student_details[] = $temp;
                }

                $data['sem_detials'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
                $data['course_detials'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detials'][0]->cid));
                $data['sub_detials'] = $this->sfs_subject_model->getWhere(array('subjectid' => $subjectid));
                $data['student_details'] = $student_details;
                $data['label'] = 'Student Wise';
                $this->admin_layout->view('admin/feedback/student_subjectwise_feedback', $data);
            } else {
                $this->session->set_flashdata('info', 'No Feedback is given');
                redirect(ADMIN_URL . 'report/feedback/student_subjectwise', 'refresh');
            }
        }
    }

    public function subjectWiseStudentFeedBack() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/student_subjectwise', $data);
    }

    function facultyWiseStudentFeedBack() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/faculty_subjectwise', $data);
    }

    function facultywiselistener() {
        $sid = $this->input->post('sid');
        $facultyid = $this->input->post('facultyid');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if (!empty($date_from)) {
            $date_from = date('Y-m-d', strtotime($date_from));
        }

        if (!empty($date_to)) {
            $date_to = date('Y-m-d', strtotime($date_to));
        }

        $obj_master = new sfs_student_feedback_master_model();
        $feedback = $obj_master->getFeedbackId(array('sid' => $sid, 'facultyid' => $facultyid));

        if (!is_null($feedback) && !empty($feedback)) {
            $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
            $student_details = array();
            foreach ($student_list as $value) {
                $obj_detail = new sfs_student_feedback_details_model();
                $avg = $obj_detail->getAverageOfSingleStudent($feedback, $value->userid);
                $med = $obj_detail->getMedianOfSingleStudent($feedback, $value->userid);
                $temp = array();
                $temp['name'] = $value->fullname;
                $temp['average'] = $avg;
                $temp['median'] = $med;
                $student_details[] = $temp;
            }

            $data['sem_detials'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
            $data['course_detials'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detials'][0]->cid));
            
            $data['faculty_detail'] = $this->sfs_user_model->getWhere(array('userid'=>$facultyid));

            $data['student_details'] = $student_details;
            $data['label'] = 'Faculty Wise';
            $this->admin_layout->view('admin/feedback/student_subjectwise_feedback', $data);
        } else {
            $this->session->set_flashdata('info', 'No Feedback is given');
            redirect(ADMIN_URL . 'report/feedback/student_facultywise', 'refresh');
        }
    }

}
