<?php

include("../devicehub/devicehub.php"); // API's path

$sensor1 = new Sensor(Device_UUID, "paste_your_SENSOR_NAME_here");
$sensor1->sendData(40);
print_r($sensor1->getData(2));

$actuator1 = new Actuator(Device_UUID, "paste_your_ACTUATOR_NAME_here");
$actuator1->sendState(0);
print_r($actuator1->getStates());

?>