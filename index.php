<?php
require __DIR__ . "/inc/bootstrap.php";
require ROOT . "/controller/AppointmentController.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

switch($uri[1]){
    case "appointment": 
        $objFeedController = new AppointmentController();
        $strMethodName = $uri[2] . 'Action';
        $objFeedController->{$strMethodName}();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}
?>