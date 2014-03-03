<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class faculty_layout {

    var $obj;
    var $layout;
    var $page_title;
    var $page_name;
    var $is_index;

    function faculty_layout($layout = "faculty/template/layout_main") {
        $this->obj = & get_instance();
        $this->layout = $layout;
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

    function setField($key, $val) {
        $this->$key = $val;
    }

    function view($view, $data = null, $return = false) {

        $loadedData = array();
        $loadedData['page_title'] = $this->page_title;
        $loadedData['page_name'] = $this->page_name;
        $loadedData['is_index'] = $this->is_index;
        $loadedData['content_for_layout'] = $this->obj->load->view($view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }

}

?>