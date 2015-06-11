<?php

namespace Api\Util;

class Request {

    private $_requestData = [];
    private $_requestType;
    private $_path;

    public function __construct() {
        $this->_path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:"";
        $this->_requestType = isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:"";
        switch ($this->_requestType) {
            case "GET":
                $this->_requestData = $_GET;
                break;
            case "POST":
                $this->_requestData = $_POST;
                break;
            case "DELETE":
            case "PUT":
                parse_str(file_get_contents("php://input"), $this->_requestData);
        }
    }
    
    public function getData(){
        return $this->_requestData;
    }

    public function getType(){
        return $this->_requestType;
    }
    
    public function getPath(){
        return $this->_path;
    }
    
    public function setData($data){
        $this->_requestData = $data;
    }
}
