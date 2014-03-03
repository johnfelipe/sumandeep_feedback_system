<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_semester_model extends CI_model {

    public $sid;
    public $cid;
    public $semester_name;
    public $batch;

    private $table_name = 'sfs_semester';

    function __construct() {
        parent::__construct();
    }

    function convertObject($old) {
        $new = new sfs_course_model();
        $new->sid = $old->sid;
        $new->cid = $old->cid;
        $new->semester_name = $old->semester_name;
        $new->batch = $old->batch;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->sid != '')
            $arr['sid'] = $this->sid;
        
        if ($this->cid != '')
            $arr['cid'] = $this->cid;

        if ($this->semester_name != '')
            $arr['semester_name'] = $this->semester_name;
        
        if ($this->batch != '')
            $arr['batch'] = $this->batch;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'sid';
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
            $orderby = 'sid';
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
        unset($array['sid']);
        $this->db->where('sid', $this->sid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        return TRUE;
    }

    function deleteData() {
        $this->db->where('sid', $this->sid);
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