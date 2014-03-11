<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_faculty_feedback_details_model extends CI_model {

    public $faculty_feedback_detail_id;
    public $faculty_feedback_id;
    public $parameterid;
    public $ratting;
    private $table_name = 'sfs_faculty_feedback_details';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_faculty_feedback_details_model();
        $new->faculty_feedback_detail_id = $old->faculty_feedback_detail_id;
        $new->faculty_feedback_id = $old->faculty_feedback_id;
        $new->parameterid = $old->parameterid;
        $new->ratting = $old->ratting;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->faculty_feedback_detail_id != '')
            $arr['faculty_feedback_detail_id'] = $this->faculty_feedback_detail_id;

        if ($this->faculty_feedback_id != '')
            $arr['faculty_feedback_id'] = $this->faculty_feedback_id;

        if ($this->parameterid != '')
            $arr['parameterid'] = $this->parameterid;

        if ($this->ratting != '')
            $arr['ratting'] = $this->ratting;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'faculty_feedback_detail_id';
        }
        if (is_null($ordertype)) {
            $ordertype = 'desc;';
        }
        $this->db->order_by($orderby, $ordertype);
        if ($limit != null) {
            $this->db->limit($limit);
        }
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $obj = $this->convertObject($row);
            $objects[] = $obj;
        }
        return $objects;
    }

    function getAll($limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        if (is_null($orderby)) {
            $orderby = 'faculty_feedback_detail_id';
        }
        if (is_null($ordertype)) {
            $ordertype = 'desc';
        }
        $this->db->order_by($orderby, $ordertype);
        if ($limit != null) {
            $this->db->limit($limit);
        }
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $obj = $this->convertObject($row);
            $objects[] = $obj;
        }
        return $objects;
    }

    function insertData() {
        $array = $this->toArray();
        $this->db->insert($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateData() {
        $array = $this->toArray();
        unset($array['faculty_feedback_detail_id']);
        $this->db->where('faculty_feedback_detail_id', $this->faculty_feedback_detail_id);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('faculty_feedback_detail_id', $this->faculty_feedback_detail_id);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getDetailFeedback($faculty_feedback_id){
        $sql = 'SELECT u.fullname, p.parameter_name, f.ratting FROM sfs_student_feedback_details f, sfs_user u, sfs_feedback_parameters p WHERE f.studentid=u.userid AND f.parameterid=p.paramterid AND f.student_feedback_id = ' . $faculty_feedback_id;
        $res = $this->db->query($sql);
        return $res->result();
    }

    static function getFeedbackRate($feedbackid, $parameterid) {
        $ci = get_instance();
        $ci->db->select(' * ');
        $ci->db->from('sfs_faculty_feedback_details');
        $ci->db->where(array('faculty_feedback_id' => $feedbackid, 'parameterid' => $parameterid));
        $res = $ci->db->get()->result();

        if (count($res) == 1) {
            return $res[0]->ratting;
        } else {
            return 0;
        }
    }
    
    function getAverageOfSingleFaculty($feedbackid, $facultyid) {
        $where = $this->table_name .'.faculty_feedback_id IN (' . $feedbackid . ') AND m.facultyid=' . $facultyid;
        $this->db->select_avg('ratting');
        $this->db->from($this->table_name);
        $this->db->join('sfs_faculty_feedback_master m', $this->table_name.'.faculty_feedback_id = m.faculty_feedback_id');
        $this->db->where($where, NULL, FALSE);
        $res = $this->db->get()->result();
        return round($res[0]->ratting, 1);
    }

    function getMedianOfSingleFaculty($feedbackid, $facultyid) {
        $where = $this->table_name .'.faculty_feedback_id IN (' . $feedbackid . ') AND m.facultyid=' . $facultyid;
        $this->db->select('ratting');
        $this->db->from($this->table_name);
        $this->db->join('sfs_faculty_feedback_master m', $this->table_name.'.faculty_feedback_id = m.faculty_feedback_id');
        $this->db->where($where, NULL, FALSE);
        $res = $this->db->get()->result();
        $temp = array();
        $i = 1;
        foreach ($res as $r) {
            $temp[$i] = $r->ratting;
            $i++;
        }

        sort($temp, 1);

        $count = count($temp) / 2;

        if (is_float($count)) {
            $count = floor($count);
            $median = $temp[$count];
        } else if(is_int($count) && $count !=0){
            $median = ($temp[$count - 1] + $temp[$count]) / 2;
        } else {
            $median = 0;
        }

        return $median;
    }

}

?>