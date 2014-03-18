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
        $this->load->model('sfs_faculty_feedback_master_model');
        $this->load->model('sfs_faculty_feedback_details_model');

        $this->admin_layout->setField('page_title', 'Feedback Report\'s');
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

    function getStudentDetails($sid, $view = 'F') {
        $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
        if ($view == 'F') {
            echo '<option value="0">All Student</option>';
        } else {
            echo '<option value="">Select Student</option>';
        }
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

    function getFacultyDetails($sid, $view = 'S') {
        $records = $this->sfs_assign_faculty_model->getSemesterFaculty($sid);
        if ($view == 'S') {
            echo '<option value="">Select Faculty</option>';
        } else {
            echo '<option value="0">All Faculty</option>';
        }
        foreach ($records as $value) {
            echo '<option value="' . $value->userid . '">' . $value->fullname . '</option>';
        }
    }

    function subjectwiselistener() {
        if (empty($_POST)) {
            redirect(ADMIN_URL . 'report/feedback/student_subjectwise', 'refresh');
        }

        $sid = $this->input->post('sid');
        $subjectid = $this->input->post('subjectid');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if (!empty($date_from)) {
            $data['date_from'] = ' (' . $date_from;
            $date_from = date('Y-m-d', strtotime($date_from));
        }

        if (!empty($date_to)) {
            $data['date_to'] = ' : ' . $date_to . ')';
            $date_to = date('Y-m-d', strtotime($date_to));
        }

        $obj_master = new sfs_student_feedback_master_model();
        $where = ' sid=' . $sid;

        if (!empty($subjectid) && $subjectid != '0') {
            $where .= ' AND subjectid=' . $subjectid;
        }


        if (!empty($date_from) && !empty($date_to)) {
            $where .= " And feedback_date BETWEEN '$date_from' AND '$date_to'";
        }

        $feedback = $obj_master->getFeedbackId($where);
        if (!is_null($feedback) && !empty($feedback)) {
            if ($this->input->post('userid') == 0) {
                $student_list = $this->sfs_assign_student_model->getSemesterStudent($sid);
            } else {
                $student_list = $this->sfs_user_model->getWhere(array('userid' => $this->input->post('userid')));
            }
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

    public function subjectWiseStudentFeedBack() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/student_subjectwise', $data);
    }

    function facultyWiseStudentFeedBack() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/faculty_subjectwise', $data);
    }

    function facultywiselistener() {
        if (empty($_POST)) {
            redirect(ADMIN_URL . 'report/feedback/student_facultywise', 'refresh');
        }
        $sid = $this->input->post('sid');
        $facultyid = $this->input->post('facultyid');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if (!empty($date_from)) {
            $data['date_from'] = ' (' . $date_from;
            $date_from = date('Y-m-d', strtotime($date_from));
        }

        if (!empty($date_to)) {
            $data['date_to'] = ' : ' . $date_to . ')';
            $date_to = date('Y-m-d', strtotime($date_to));
        }

        $obj_master = new sfs_student_feedback_master_model();
        $where = ' sid=' . $sid . ' AND facultyid=' . $facultyid;

        if (!empty($date_from) && !empty($date_to)) {
            $where .= " And feedback_date BETWEEN '$date_from' AND '$date_to'";
        }

        $feedback = $obj_master->getFeedbackId($where);

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

            $data['faculty_detail'] = $this->sfs_user_model->getWhere(array('userid' => $facultyid));

            $data['student_details'] = $student_details;
            $data['label'] = 'Faculty Wise';
            $this->admin_layout->view('admin/feedback/student_subjectwise_feedback', $data);
        } else {
            $this->session->set_flashdata('info', 'No Feedback is given');
            redirect(ADMIN_URL . 'report/feedback/student_facultywise', 'refresh');
        }
    }

    /*
     * Faculty Feedback Given By Student
     */

    function faculty_over_all() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/faculty_over_all', $data);
    }

    function facultyOverAllListener() {
        if (empty($_POST)) {
            redirect(ADMIN_URL . 'report/feedback/faculty_over_all', 'refresh');
        }
        $sid = $this->input->post('sid');
        $facultyid = (int) $this->input->post('facultyid');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if (!empty($date_from)) {
            $data['date_from'] = ' (' . $date_from;
            $date_from = date('Y-m-d', strtotime($date_from));
        }

        if (!empty($date_to)) {
            $data['date_to'] = ' : ' . $date_to . ')';
            $date_to = date('Y-m-d', strtotime($date_to));
        }

        $obj_master = new sfs_faculty_feedback_master_model();
        $where = ' sid=' . $sid;

        if (!empty($facultyid)) {
            $where .= ' AND facultyid =' . $facultyid;
        }

        if (!empty($date_from) && !empty($date_to)) {
            $where .= " And feedback_date BETWEEN '$date_from' AND '$date_to'";
        }

        $feedback = $obj_master->getFeedbackId($where);
        if (!is_null($feedback) && !empty($feedback)) {
            if ($facultyid === 0) {
                $list = $this->sfs_assign_faculty_model->getSemesterFaculty($sid);
                $details = array();
                foreach ($list as $value) {
                    $obj_detail = new sfs_faculty_feedback_details_model();
                    $avg = $obj_detail->getAverageOfSingleFaculty($feedback, $value->userid);
                    $med = $obj_detail->getMedianOfSingleFaculty($feedback, $value->userid);
                    $temp = array();
                    $temp['name'] = $value->fullname;
                    $temp['average'] = $avg;
                    $temp['median'] = $med;
                    $details[] = $temp;
                }
            } else if ($facultyid !== 0) {
                $user = $this->sfs_user_model->getWhere(array('userid' => $facultyid));
                $obj_detail = new sfs_faculty_feedback_details_model();
                $avg = $obj_detail->getAverageOfSingleFaculty($feedback, $facultyid);
                $med = $obj_detail->getMedianOfSingleFaculty($feedback, $facultyid);
                $temp = array();
                $temp['name'] = $user[0]->fullname;
                $temp['average'] = $avg;
                $temp['median'] = $med;
                $details[] = $temp;
            }

            $data['sem_detials'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
            $data['course_detials'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detials'][0]->cid));

            $data['faculty_details'] = $details;
            $data['label'] = 'Faculty Over All';
            $this->admin_layout->view('admin/feedback/faculty_feedback', $data);
        } else {
            $this->session->set_flashdata('info', 'No Feedback is given');
            redirect(ADMIN_URL . 'report/feedback/faculty_over_all', 'refresh');
        }
    }

    function studentWiseFacultyFeedBack() {
        $data['course_details'] = $this->sfs_course_model->getAll();
        $this->admin_layout->view('admin/feedback/faculty_studentwise', $data);
    }

    function facultyStudentWiseListener() {
        if (empty($_POST)) {
            redirect(ADMIN_URL . 'report/feedback/faculty_studentwise', 'refresh');
        }
        $sid = $this->input->post('sid');
        $student_id = $this->input->post('studentid');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if (!empty($date_from)) {
            $data['date_from'] = ' (' . $date_from;
            $date_from = date('Y-m-d', strtotime($date_from));
        }

        if (!empty($date_to)) {
            $data['date_to'] = ' : ' . $date_to . ')';
            $date_to = date('Y-m-d', strtotime($date_to));
        }

        $obj_master = new sfs_faculty_feedback_master_model();
        $where = ' sid=' . $sid;

        if (!empty($student_id)) {
            $where .= " And studentid = '$student_id'";
        }

        if (!empty($date_from) && !empty($date_to)) {
            $where .= " And feedback_date BETWEEN '$date_from' AND '$date_to'";
        }

        $feedback = $obj_master->getFeedbackId($where);

        if (!is_null($feedback) && !empty($feedback)) {
            if ($this->input->post('facultyid') == 0) {
                $list = $this->sfs_assign_faculty_model->getSemesterFaculty($sid);
            } else {
                $list = $this->sfs_user_model->getWhere(array('userid' => $this->input->post('facultyid')));
            }
            $details = array();
            foreach ($list as $value) {
                $obj_detail = new sfs_faculty_feedback_details_model();
                $avg = $obj_detail->getAverageOfSingleFaculty($feedback, $value->userid);
                $med = $obj_detail->getMedianOfSingleFaculty($feedback, $value->userid);
                $temp = array();
                $temp['name'] = $value->fullname;
                $temp['average'] = $avg;
                $temp['median'] = $med;
                $details[] = $temp;
            }

            $data['sem_detials'] = $this->sfs_semester_model->getWhere(array('sid' => $sid));
            $data['course_detials'] = $this->sfs_course_model->getWhere(array('cid' => $data['sem_detials'][0]->cid));

            $data['faculty_details'] = $details;
            $data['label'] = 'Student Wise';
            $this->admin_layout->view('admin/feedback/faculty_feedback', $data);
        } else {
            $this->session->set_flashdata('info', 'No Feedback is given');
            redirect(ADMIN_URL . 'report/feedback/faculty_studentwise', 'refresh');
        }
    }

    function temp($feedbackid) {
        $this->load->model('sfs_feedback_parameters_model');

        $student_list = $this->sfs_assign_student_model->getSemesterStudent(2);

        echo '<form action="' . ADMIN_URL . 'feedback/templistener" method="post"/>';

        foreach ($student_list as $value) {
            $obj_detail = new sfs_student_feedback_details_model();
            $parameters = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));

            $check = $obj_detail->getWhere(array('student_feedback_id' => $feedbackid, 'studentid' => $value->userid));

            if (count($check) == 1) {
                foreach ($parameters as $param) {
                    $temp = $obj_detail->getWhere(array('student_feedback_id' => $feedbackid, 'studentid' => $value->userid, 'parameterid' => $param->paramterid));

                    $name = $feedbackid . '_' . $value->userid . '_' . $param->paramterid;
                    echo 'Feedback Id:', $feedbackid, ' -- Studentid', $value->userid, ' -- Paramenter', $param->paramterid;
                    echo '-- Ratting: <input type="text" name="' . $name . '" value="' . mt_rand(1,5) . '"><br />';
                }
            }

            echo '----<br />';
        }

        echo '<input type="submit" name="submit" value="Save"/>';
        echo '</form>';
    }

    function templistener() {
        foreach ($_POST as $key => $p) {
            $v = explode('_', $key);

            if (count($v) == 3) {
                $obj_detail = new sfs_student_feedback_details_model();
                $temp = $obj_detail->getWhere(array('student_feedback_id' => $v[0], 'studentid' => $v[1], 'parameterid' => $v[2]));
                if (count($temp) == 1) {
                    $obj_detail->ratting = $p;
                    $obj_detail->student_feedback_detail_id = $temp[0]->student_feedback_detail_id;
                    $obj_detail->updateData();
                } else {
                    $obj_detail->student_feedback_id = $v[0];
                    $obj_detail->studentid = $v[1];
                    $obj_detail->parameterid = $v[2];
                    $obj_detail->ratting = $p;
                    $obj_detail->insertData();
                }
            }
        }
    }

}
