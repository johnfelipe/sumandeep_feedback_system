<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_feedback_parameters_model extends CI_model {

    public $paramterid;
    public $parameter_name;
    public $role;
    public $status;
    private $table_name = 'sfs_feedback_parameters';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_feedback_parameters_model();
        $new->paramterid = $old->paramterid;
        $new->parameter_name = $old->parameter_name;
        $new->role = $old->role;
        $new->status = $old->status;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->paramterid != '')
            $arr['paramterid'] = $this->paramterid;

        if ($this->parameter_name != '')
            $arr['parameter_name'] = $this->parameter_name;

        if ($this->role != '')
            $arr['role'] = $this->role;

        if ($this->status != '')
            $arr['status'] = $this->status;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'paramterid';
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
            $orderby = 'paramterid';
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
        unset($array['paramterid']);
        $this->db->where('paramterid', $this->paramterid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('paramterid', $this->paramterid);
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