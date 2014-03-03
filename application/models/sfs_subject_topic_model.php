<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_subject_topic_model extends CI_model {

    public $topicid;
    public $subjectid;
    public $topic_name;
    private $table_name = 'sfs_subject_topic';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_subject_topic_model();
        $new->topicid = $old->topicid;
        $new->subjectid = $old->subjectid;
        $new->topic_name = $old->topic_name;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->topicid != '')
            $arr['topicid'] = $this->topicid;

        if ($this->subjectid != '')
            $arr['subjectid'] = $this->subjectid;

        if ($this->topic_name != '')
            $arr['topic_name'] = $this->topic_name;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'topicid';
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
            $orderby = 'topicid';
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
        unset($array['topicid']);
        $this->db->where('topicid', $this->topicid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('topicid', $this->topicid);
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