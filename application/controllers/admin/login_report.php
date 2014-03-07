<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_report extends CI_Controller {

    function __construct() {
        parent::__construct();

        $session = $this->session->userdata('feedback_session');
        if (empty($session) && $session->type != 'admin') {
            $this->session->set_flashdata('error', 'Login First');
            redirect(base_url() . 'login', 'refresh');
        }

        $this->load->model('sfs_user_model');
    }

    public function index($role) {
        if ($role == 'student') {
            $data['role'] = 'S';
            $data['user_details'] = $this->sfs_user_model->getWhere(array('role' => 'S'));
            $this->admin_layout->view('admin/reports/login', $data);
        } else if ($role == 'no_student') {
            $data['role'] = 'S';
            $data['user_details'] = $this->sfs_user_model->getWhere(array('role' => 'S'));
            $this->admin_layout->view('admin/reports/no_login', $data);
        } else if ($role == 'faculty') {
            $data['role'] = 'F';
            $data['user_details'] = $this->sfs_user_model->getWhere(array('role' => 'F'));
            $this->admin_layout->view('admin/reports/login', $data);
        } else if ($role == 'no_faculty') {
            $data['role'] = 'F';
            $data['user_details'] = $this->sfs_user_model->getWhere(array('role' => 'F'));
            $this->admin_layout->view('admin/reports/no_login', $data);
        } else {
            redirect(ADMIN_URL . 'dashboard', 'refresh');
        }
    }

    function getJson($role, $userid, $date_from, $date_to) {
        $condition = '';

        if ($role != '') {
            $condition = 'sfs_user.role =  "' . $role . '"';
        }

        if ($userid != 'null' && $userid !== NULL) {
            $condition .= ' AND sfs_user.userid =  "' . $userid . '"';
        }

        if (($date_from != 'null' && $date_from !== NULL) && ($date_to != 'null' && $date_to !== NULL)) {
            $condition .= ' AND date(sfs_login_log.date_time) BETWEEN "' . date('Y-m-d', strtotime($date_from)) . '" AND "' . date('Y-m-d', strtotime($date_to)) . '"';
        }




        $this->load->library('datatable');
        $this->datatable->aColumns = array('date(sfs_login_log.date_time) AS date', 'sfs_user.fullname', 'count(sfs_login_log.login_log_id) AS count_total', 'GROUP_CONCAT(DATE_FORMAT(date_time,"%H:%i:%s")) AS time');
        $this->datatable->eColumns = array('sfs_user.userid');
        $this->datatable->sIndexColumn = "sfs_user.userid";
        $this->datatable->sTable = " sfs_user, sfs_login_log";
        $this->datatable->myWhere = 'WHERE sfs_user.userid = sfs_login_log.userid AND ' . $condition;
        $this->datatable->groupBy = ' GROUP BY date(sfs_login_log.date_time), sfs_login_log.userid';
        //$this->datatable->sOrder = ' sfs_login_log.date_time desc';
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['fullname'];
            $temp_arr[] = $aRow['count_total'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['date']));
            $time = explode(',', $aRow['time']);
            $temp_time = null;
            foreach ($time as $t) {
                $temp_time .= date('H:i a', strtotime($t)) . '<br />';
            }
            $temp_arr[] = $temp_time;
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function getJsonForNoLogin($role, $userid, $date_from) {
        $condition = '';

        if ($role == 'S') {
            $select = array('fullname', 'semester_name', 'batch', 'course_name');
            $table = " sfs_user, sfs_semester, sfs_course, sfs_assign_student";
            $condition = 'WHERE sfs_user.userid = sfs_assign_student.studentid AND sfs_assign_student.sid = sfs_semester.sid  AND sfs_semester.cid = sfs_course.cid AND sfs_user.role = "S"';
        } else if ($role == 'F') {
            $select = array('fullname');
            $table = " sfs_user";
            $condition = 'WHERE sfs_user.role = "F"';
        }


        if ($userid != 'null' && $userid !== NULL) {
            $condition .= ' AND sfs_user.userid =  "' . $userid . '"';
        }

        if ($date_from != 'null' && $date_from !== NULL) {
            $res = $this->db->query('select IFNULL(GROUP_CONCAT(distinct(userid)),0) as userid from sfs_login_log where date(date_time) BETWEEN "' . date('Y-m-d', strtotime($date_from)) . '" AND "' . date('Y-m-d', strtotime($date_from)) . '"');
            $r = $res->result();
            $condition .= ' AND sfs_user.userid not in ('.$r[0]->userid.')';
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = $select;
        $this->datatable->eColumns = array('sfs_user.userid');
        $this->datatable->sIndexColumn = "sfs_user.userid";
        $this->datatable->sTable = $table;
        $this->datatable->myWhere = $condition;
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['fullname'];
            if ($role == 'S') {
                $temp_arr[] = $aRow['semester_name'] . ' (' . $aRow['batch'] . ')';
                $temp_arr[] = $aRow['course_name'];
            }
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

}
