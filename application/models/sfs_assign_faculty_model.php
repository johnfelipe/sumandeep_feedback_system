<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_assign_faculty_model extends CI_model {

    public $assign_faculty_id;
    public $facultyid;
    public $sid;
    private $table_name = 'sfs_assign_faculty';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_assign_faculty_model();
        $new->assign_faculty_id = $old->assign_faculty_id;
        $new->facultyid = $old->facultyid;
        $new->sid = $old->sid;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->assign_faculty_id != '')
            $arr['assign_faculty_id'] = $this->assign_faculty_id;

        if ($this->facultyid != '')
            $arr['facultyid'] = $this->facultyid;

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
            $orderby = 'assign_faculty_id';
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
            $orderby = 'assign_faculty_id';
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
        unset($array['assign_faculty_id']);
        $this->db->where('assign_faculty_id', $this->assign_faculty_id);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('assign_faculty_id', $this->assign_faculty_id);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getSemesterFaculty($sid){
        $sql = 'SELECT sfs_user.fullname, sfs_user.userid FROM sfs_assign_faculty, sfs_user WHERE sfs_user.role= "F" AND sfs_assign_faculty.facultyid = sfs_user.userid AND sfs_assign_faculty.sid =  '. $sid;
        return $this->db->query($sql)->result();
    }

}

?>