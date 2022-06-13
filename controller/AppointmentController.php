<?php

require ROOT . "/services/AppointmentService.php";

class AppointmentController extends ControllerTemplate
{
    /**
     * "/appointment/list?doctor_id=*" Endpoint - Get list of appointments for a given doctor
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET' && isset($_GET['doctor_id'])) {
            try {
                $appointmentService = new AppointmentService();

                $limit = 10;
                if (isset($_GET['limit']) && $_GET['limit']) {
                    $limit = $_GET['limit'];
                }
 
                $appointments = $appointmentService->findFromToday($_GET['doctor_id'], $limit);
                $responseData = json_encode($appointments);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/appointment/create" Endpoint - creates a new appointment
     */
    public function createAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'POST') {
            try {
                if(isset($_POST['doctor_id']) && 
                    isset($_POST['patient_id']) &&
                    isset($_POST['start_date'])
                ){
                    $appointmentService = new AppointmentService();
                    $appointment = $appointmentService->create(
                        $_POST['doctor_id'], 
                        $_POST['patient_id'], 
                        $_POST['start_date']
                    );
                    $responseData = json_encode($appointment);
                }
                else{
                    $strErrorDesc = 'Missing data';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/appointment/accept" Endpoint - accepts or declines a new appointment
     */
    public function acceptAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'POST') {
            try {
                if(isset($_POST['appointment_id'])){
                    $appointmentService = new AppointmentService();
                    $appointment = $appointmentService->accept(
                        $_POST['appointment_id'],
                        isset($_POST['decision'])?$_POST['decision']:1
                    );
                    $responseData = json_encode($appointment);
                }
                else{
                    $strErrorDesc = 'Missing data';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}