<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_subject_model extends CI_model {

    public $subjectid;
    public $sid;
    public $subject_name;

    private $table_name = 'sfs_subject';

    function __construct() {
        parent::__construct();
    }

    function convertObject($old) {
        $new = new sfs_course_model();
        $new->subjectid = $old->subjectid;
        $new->sid = $old->sid;
        $new->subject_name = $old->subject_name;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->subjectid != '')
            $arr['subjectid'] = $this->subjectid;
        
        if ($this->sid != '')
            $arr['sid'] = $this->sid;

        if ($this->subject_name != '')
            $arr['subject_name'] = $this->subject_name;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'subjectid';
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
            $orderby = 'subjectid';
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
        unset($array['subjectid']);
        $this->db->where('subjectid', $this->subjectid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        return TRUE;
    }

    function deleteData() {
        $this->db->where('subjectid', $this->subjectid);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>