<?php
/*
Created by Mihai Macarie
Email: yo2mno@yahoo.ro
*/

require_once "config.php";

class Sensor
{
    public $sensor_name;
    public $device;
    public $meta = array();

    public function __construct($uuid, $name)
    {
        $this->sensor_name = $name;
        $this->device = $uuid;
    }

    public function sendData($value, $timestamp = 0, $include_meta = false)
    {
        $data = array();
        $data['value'] = $value;

        if($timestamp != 0)
            $data['timestamp'] = $timestamp;
        if($include_meta)
            $data['meta'] = $this->meta;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ApiKey: '.API_KEY,'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, "https://api.devicehub.net/v2/project/".PROJECT_ID."/device/".$this->device."/sensor/".$this->sensor_name."/data");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getData($limit = 1, $from = 0, $to = 0)
    {
        $url = "https://api.devicehub.net/v2/project/".PROJECT_ID."/device/".$this->device."/sensor/".$this->sensor_name."/data?limit=".$limit;
        
        if($from != 0 && $to != 0) 
            $url += "&from=".$from."&to=".$to;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ApiKey: '.API_KEY,'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $test = curl_exec($ch);
        curl_close($ch);
        return json_decode($test,1);
    }

    public function addMeta($meta_name, $meta_value)
    {
        $this->meta[$meta_name] = $meta_value;
    }
    public function setMetaProtocol($protocol)
    {
        $this->meta['protocol'] = $protocol;
    }
}

class Actuator
{
    public $actuator_name;
    public $device;
    public $meta = array();

    public function __construct($uuid, $name)
    {
        $this->actuator_name = $name;
        $this->device = $uuid;
    }

    public function sendState($state, $timestamp = 0, $include_meta = false)
    {
        $data = array();
        $data['state'] = $state;

        if($timestamp != 0)
            $data['timestamp'] = $timestamp;
        if($include_meta)
            $data['meta'] = $this->meta;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ApiKey: '.API_KEY,'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, "https://api.devicehub.net/v2/project/".PROJECT_ID."/device/".$this->device."/actuator/".$this->actuator_name."/state");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getStates($limit = 1)
    {
        $url = "https://api.devicehub.net/v2/project/".PROJECT_ID."/device/".$this->device."/actuator/".$this->actuator_name."/state";
        
        if($limit > 1)
            $url += "/history?limit=".$limit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ApiKey: '.API_KEY,'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $test = curl_exec($ch);
        curl_close($ch);
        return json_decode($test,1);
    }

    public function addMeta($meta_name, $meta_value)
    {
        $this->meta[$meta_name] = $meta_value;
    }

    public function setMetaProtocol($protocol)
    {
        $this->meta['protocol'] = $protocol;
    }
}
?>