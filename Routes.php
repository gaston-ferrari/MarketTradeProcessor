<?php

class Routes {
    private $endpoints = [];
    
    public function get($endpoint, $handler){
        $this->endpoints["GET"][$endpoint] = $handler;
    }
    
    public function post($endpoint, $handler){
        $this->endpoints["POST"][$endpoint] = $handler;
    }
    
    public function put($endpoint, $handler){
        $this->endpoints["PUT"][$endpoint] = $handler;
    }
    
    public function del($endpoint, $handler){
        $this->endpoints["DELETE"][$endpoint] = $handler;
    }
    
    public function getHandler($endpoint, $requestType){
        if(isset($this->endpoints[$requestType]) && isset($this->endpoints[$requestType][$endpoint])){
            return $this->endpoints[$requestType][$endpoint];
        }else{
            throw new Exception("call to nonexistent endpoint.");
        }
    }
}
