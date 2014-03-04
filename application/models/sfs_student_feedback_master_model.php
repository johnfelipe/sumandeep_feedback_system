<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_student_feedback_master_model extends CI_model {

    public $student_feedback_id;
    public $facultyid;
    public $subjectid;
    public $topicid;
    public $feedback_date;
    public $topic_time_from;
    public $topic_time_to;
    private $table_name = 'sfs_student_feedback_master';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_student_feedback_master_model();
        $new->student_feedback_id = $old->student_feedback_id;
        $new->facultyid = $old->facultyid;
        $new->subjectid = $old->subjectid;
        $new->topicid = $old->topicid;
        $new->feedback_date = $old->feedback_date;
        $new->topic_time_from = $old->topic_time_from;
        $new->topic_time_to = $old->topic_time_to;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->student_feedback_id != '')
            $arr['student_feedback_id'] = $this->student_feedback_id;

        if ($this->facultyid != '')
            $arr['facultyid'] = $this->facultyid;

        if ($this->subjectid != '')
            $arr['subjectid'] = $this->subjectid;

        if ($this->topicid != '')
            $arr['topicid'] = $this->topicid;

        if ($this->feedback_date != '')
            $arr['feedback_date'] = $this->feedback_date;

        if ($this->topic_time_from != '')
            $arr['topic_time_from'] = $this->topic_time_from;

        if ($this->topic_time_to != '')
            $arr['topic_time_to'] = $this->topic_time_to;

        return $arr;
    }

    function getWhere($where, $limit = null, $orderby = null, $ordertype = null) {
        $objects = array();
        $this->db->select(' * ');
        $this->db->from($this->table_name);
        $this->db->where($where);
        if (is_null($orderby)) {
            $orderby = 'student_feedback_id';
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
            $orderby = 'student_feedback_id';
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
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function updateData() {
        $array = $this->toArray();
        unset($array['student_feedback_id']);
        $this->db->where('student_feedback_id', $this->student_feedback_id);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData() {
        $this->db->where('student_feedback_id', $this->student_feedback_id);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getMasterFeedback($student_feedback_id){
        $sql = 'SELECT s.subject_name, t.topic_name, f.*,f.student_feedback_id, c.course_name, sem.semester_name, sem.batch, sem.sid FROM sfs_student_feedback_master f, sfs_subject s, sfs_subject_topic t, sfs_course c, sfs_semester sem WHERE f.subjectid=s.subjectid AND f.topicid=t.topicid AND c.cid=sem.cid AND sem.sid=s.sid AND f.student_feedback_id = ' . $student_feedback_id;
        $res = $this->db->query($sql);
        return $res->result();
    }

}

?>