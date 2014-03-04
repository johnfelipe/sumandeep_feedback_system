<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_assign_student_model extends CI_model {

    public $assign_student_id;
    public $studentid;
    public $sid;
    private $table_name = 'sfs_assign_student';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_assign_student_model();
        $new->assign_student_id = $old->assign_student_id;
        $new->studentid = $old->studentid;
        $new->sid = $old->sid;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->assign_student_id != '')
            $arr['assign_student_id'] = $this->assign_student_id;

        if ($this->studentid != '')
            $arr['studentid'] = $this->studentid;

        if ($this->sid != '')
            $arr['sid'] = $this->sid;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'assign_student_id';
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
            $orderby = 'assign_student_id';
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
        unset($array['assign_student_id']);
        $this->db->where('assign_student_id', $this->assign_student_id);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('assign_student_id', $this->assign_student_id);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getSemesterStudent($sid){
        $sql = 'SELECT sfs_user.fullname, sfs_user.userid FROM sfs_assign_student, sfs_user WHERE sfs_user.role = "S" AND sfs_assign_student.studentid = sfs_user.userid AND sfs_assign_student.sid =  '. $sid;
        return $this->db->query($sql)->result();
    }

}

?>