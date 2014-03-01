<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class sfs_user_model extends CI_model {

    public $userid;
    public $username;
    public $password;
    public $fullname;
    public $role;
    private $table_name = 'user';

    function __construct() {
        parent::__construct();
    }

    function convertObject($old) {
        $new = new sfs_user_model();
        $new->userid = $old->userid;
        $new->username = $old->username;
        $new->password = $old->password;
        $new->fullname = $old->fullname;
        $new->role = $old->role;
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

        if ($this->role != '')
            $arr['role'] = $this->role;

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
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateData() {
        $array = $this->toArray();
        unset($array['userid']);
        $this->db->where('userid', $this->userid);
        $this->db->update($this->table_name, $array);
        $check = $this->db->affected_rows();
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
        $this->db->or_where('username', $this->input->post('email_address'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get($this->table_name);
        $query->result();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
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