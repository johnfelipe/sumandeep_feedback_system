<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_student_feedback_details_model extends CI_model {

    public $student_feedback_detail_id;
    public $student_feedback_id;
    public $studentid;
    public $parameterid;
    public $ratting;
    private $table_name = 'sfs_student_feedback_details';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_student_feedback_details_model();
        $new->student_feedback_detail_id = $old->student_feedback_detail_id;
        $new->student_feedback_id = $old->student_feedback_id;
        $new->studentid = $old->studentid;
        $new->parameterid = $old->parameterid;
        $new->ratting = $old->ratting;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->student_feedback_detail_id != '')
            $arr['student_feedback_detail_id'] = $this->student_feedback_detail_id;

        if ($this->student_feedback_id != '')
            $arr['student_feedback_id'] = $this->student_feedback_id;

        if ($this->studentid != '')
            $arr['studentid'] = $this->studentid;

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
            $orderby = 'student_feedback_detail_id';
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
            $orderby = 'student_feedback_detail_id';
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
        unset($array['student_feedback_detail_id']);
        $this->db->where('student_feedback_detail_id', $this->student_feedback_detail_id);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('student_feedback_detail_id', $this->student_feedback_detail_id);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getDetailFeedback($student_feedback_id){
        $sql = 'SELECT u.fullname, p.parameter_name, f.ratting FROM sfs_student_feedback_details f, sfs_user u, sfs_feedback_parameters p WHERE f.studentid=u.userid AND f.parameterid=p.paramterid AND f.student_feedback_id = ' . $student_feedback_id;
        $res = $this->db->query($sql);
        return $res->result();
    }
    
    static function getFeedbackRate($feedbackid, $studentid, $parameterid){
        $ci = get_instance();
        $ci->db->select(' * ');
        $ci->db->from('sfs_student_feedback_details');
        $ci->db->where(array('student_feedback_id'=>$feedbackid, 'studentid'=>$studentid, 'parameterid'=>$parameterid));
        $res = $ci->db->get()->result();
        
        if(count($res) == 1){
            return $res[0]->ratting;
        }else{
            return 0;
        }
        
    }
    
    function getDistincitFeedbackID($userid){
        $this->db->select('Distinct(student_feedback_id) as student_feedback_id');
        $this->db->from($this->table_name);
        $this->db->where('studentid', $userid);
        $res = $this->db->get()->result();
        return $res;
    }

}

?>