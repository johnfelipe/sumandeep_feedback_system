<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_user_model extends CI_model {

    public $userid;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $role;
    public $status;
    private $table_name = 'sfs_user';

    function __construct() {
        parent::__construct();
    }

    function validationRules() {
        $validation_rules = array();
        return $validation_rules;
    }

    function convertObject($old) {
        $new = new sfs_user_model();
        $new->userid = $old->userid;
        $new->username = $old->username;
        $new->password = $old->password;
        $new->fullname = $old->fullname;
        $new->email = $old->email;
        $new->role = $old->role;
        $new->status = $old->status;
        return $new;
    }

    function toArray() {
        $arr = array();
        if ($this->userid != '')
            $arr['userid'] = $this->userid;

        if ($this->username != '')
            $arr['username'] = $this->username;

        if ($this->password != '')
            $arr['password'] = $this->password;

        if ($this->fullname != '')
            $arr['fullname'] = $this->fullname;

        if ($this->email != '')
            $arr['email'] = $this->email;

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
            $orderby = 'userid';
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
            $orderby = 'userid';
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
        unset($array['userid']);
        $this->db->where('userid', $this->userid);
        $this->db->update($this->table_name, $array);
        return TRUE;
    }

    function deleteData() {
        $this->db->where('userid', $this->userid);
        $this->db->delete($this->table_name);
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_login() {
        $this->db->where('username', $this->input->post('email_address'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get($this->table_name);
        $query->result();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            $this->insertLog($result);
            return $result;
        } else {
            return false;
        }
    }

    function insertLog($user_detail) {
        if ($user_detail[0]->role == 'F' || $user_detail[0]->role == 'S') {
            $this->load->model('sfs_login_log_model');
            $obj = new sfs_login_log_model();
            $obj->userid = $user_detail[0]->userid;
            $obj->date_time = get_current_date_time()->get_date_time_for_db();
            $obj->insertData();
        }
        return true;
    }

    public function check_mail($randid, $email_address) {
        $check = $this->getWhere(array('email_address' => $email_address));
        if (count($check) == 1) {
            if ($check[0]->status == 'A') {
                $this->password = $randid;
                $this->consumerid = $check[0]->consumerid;
                $this->updateData();
                return $email_address;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

}

?>