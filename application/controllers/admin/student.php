<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class student extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->admin_layout->setField('page_title', 'Student');
        $this->load->model('sfs_user_model');
        $this->load->model('sfs_course_model');
        $this->load->model('sfs_semester_model');
        $this->load->model('sfs_assign_student_model');
        
        $session = $this->session->userdata('feedback_session');
        if (empty($session)) {
            $this->session->set_flashdata('error', 'Login First');
           redirect(base_url() .'login', 'refresh');
        }
    }

    public function index() {
        $this->admin_layout->setField('page_title', 'Student Managment');
        $this->admin_layout->view('admin/student/list');
    }

    function getSemesterDetails($cid, $userid) {
        $records = $this->sfs_semester_model->getWhere(array('cid' => $cid));
        $assign_detail = $this->sfs_assign_student_model->getWhere(array('studentid' => $userid));
        echo '<option value="">Select Semester</option>';
        foreach ($records as $value) {
            if (is_array($assign_detail) && count($assign_detail) == 1) {
                if ($value->sid == $assign_detail[0]->sid) {
                    $sel = 'selected="selected"';
                } else {
                    $sel = '';
                }
            } else {
                $sel = '';
            }
            echo '<option value="' . $value->sid . '" ' . $sel . '>' . $value->semester_name . ' (' . $value->batch . ')' . '</option>';
        }
    }

    public function manage($userid = null) {
        $this->admin_layout->setField('page_title', 'Manage Student');

        $data['course_details'] = $this->sfs_course_model->getAll();
        if ($userid != null) {
            $assign_detail = $this->sfs_assign_student_model->getWhere(array('studentid' => $userid));
            $data['semester_detail'] = $this->sfs_semester_model->getWhere(array('sid' => $assign_detail[0]->sid));
            $data['student_detail'] = $this->sfs_user_model->getWhere(array('userid' => $userid));
        } else {
            $data['student_detail'] = null;
        }

        $this->admin_layout->view('admin/student/manage', $data);
    }

    public function mangedata() {
        $obj = new sfs_user_model();

        $obj->username = $this->input->post('student_username');
        $obj->fullname = $this->input->post('student_name');
        $obj->status = $this->input->post('status');
        $obj->role = 'S';

        if ($this->input->post('password') != '') {
            $obj->password = md5($this->input->post('password'));
        }

        if ($this->input->post('userid') != '') {
            $obj->userid = $this->input->post('userid');
            $check = $obj->updateData();

            $obj_assign = new sfs_assign_student_model();
            $check_assign = $obj_assign->getWhere(array('studentid' => $obj->userid));

            $obj_assign->studentid = $this->input->post('userid');
            $obj_assign->sid = $this->input->post('sid');
            if (is_array($check_assign) && count($check_assign) == 1) {
                $obj_assign->assign_student_id = $check_assign[0]->assign_student_id;
                $obj_assign->updateData();
            } else if (is_array($check_assign) && count($check_assign) == 0) {
                $obj_assign->insertData();
            }
            
            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Editing the Data');
            }
        } else {
            $check = $obj->insertData();

            $obj_assign = new sfs_assign_student_model();
            $obj_assign->studentid = $check;
            $obj_assign->sid = $this->input->post('sid');
            $obj_assign->insertData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Added the Data Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Adding the Data');
            }
        }

        redirect(ADMIN_URL . 'student', 'refresh');
    }

    function deleteListener($id) {
        $obj = new sfs_user_model();
        $res = $obj->getWhere(array('userid' => $id));

        if (is_array($res) && count($res) == 1) {
            $obj->userid = $id;

            if ($res[0]->status == 'A') {
                $obj->status = 'D';
            } else {
                $obj->status = 'A';
            }

            $check = $obj->updateData();

            if ($check == true) {
                $this->session->set_flashdata('success', 'Update the Student Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error while Updating the Student');
            }
        } else {
            $this->session->set_flashdata('error', 'Error while Updating the Student');
        }
    }

    function getJson() {
        $records = $this->sfs_user_model->getWhere(array('role' => 'S'));
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
            $temp_arr[] = '<a href="' . ADMIN_URL . 'student/manage/' . $value->userid . '">' . $value->fullname . '</a>';
            $temp_arr[] = '<a href="' . ADMIN_URL . 'student/feedback/' . $value->userid . '">View Feedback</a>';
            if ($value->status == 'A') {
                $status = '<span class="label label-success">Active</span>';
            } else {
                $status = '<span class="label label-danger">Deactive</span>';
            }
            $temp_arr[] = '<a href="javascript:;" onclick="deleteRow(this)" class="student-status" id="' . $value->userid . '">' . $status . '</a>';
            $arra[] = $temp_arr;
        }
        return $arra;
    }

    function feedback($userid) {
        $this->load->model('sfs_student_feedback_details_model');
        $this->load->model('sfs_student_feedback_master_model');
        $this->load->model('sfs_assign_student_model');
        $this->load->model('sfs_user_model');
        $this->load->model('sfs_feedback_parameters_model');

        $feedbackids = $this->sfs_student_feedback_details_model->getDistincitFeedbackID($userid);
        $main = array();
        foreach ($feedbackids as $id) {
            $temp = array();
            $feedback_master = $this->sfs_student_feedback_master_model->getMasterFeedback($id->student_feedback_id);
            $user = $this->sfs_user_model->getWhere(array('userid' => $feedback_master[0]->facultyid));
            $temp['facultyid'] = $user[0]->userid;
            $temp['faculty_name'] = $user[0]->fullname;
            $temp['studentid'] = $userid;
            $temp['feedback_master'] = $feedback_master[0];
            $main[] = $temp;
        }
        $data['student_detail'] = $this->sfs_user_model->getWhere(array('userid' => $userid));
        $data['parameters'] = $this->sfs_feedback_parameters_model->getWhere(array('role' => 'S'));

        $data['details'] = $main;
        $this->admin_layout->view('admin/student/view_feedback', $data);
    }

}

?>
