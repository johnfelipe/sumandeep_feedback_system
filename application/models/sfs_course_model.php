<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_course_model extends CI_model {

    public $cid;
    public $course_name;

    private $table_name = 'sfs_course';

    function __construct() {
        parent::__construct();
    }

    function convertObject($old) {
        $new = new sfs_course_model();
        $new->cid = $old->cid;
        $new->course_name = $old->course_name;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->cid != '')
            $arr['cid'] = $this->cid;

        if ($this->course_name != '')
            $arr['course_name'] = $this->course_name;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'cid';
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
            $orderby = 'cid';
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
        unset($array['cid']);
        $this->db->where('cid', $this->cid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        return TRUE;
    }

    function deleteData() {
        $this->db->where('cid', $this->cid);
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