<?php
require_once ROOT . "/services/TemplateService.php";
 
class AppointmentService extends TemplateService
{

    public function create($doctor_id, $patient_id, $start_date)
    {
        //check if doctor and patient exist
        if($this->exists('users', $doctor_id) && $this->exists('users', $patient_id)){
            $data = [];
            $data[] = $doctor_id;
            $data[] = $patient_id;
            $data[] = strtotime($start_date);
            $data[] = strtotime('+1 hour', strtotime($start_date));
            return $this->query(
                "insert into appointments(doctor_id, patient_id, start_date, end_date) values (?,?,?,?)",
                'iiss', 
                $data
            );
        }
        return false;
    }

    public function findFromToday($doctor_id, $limit)
    {
        return $this->select(
            'select * from appointments where DATE(CURRENT_TIMESTAMP()) = DATE(FROM_UNIXTIME(start_date)) and doctor_id = ? limit ?', 
            'ii', 
            [$doctor_id, $limit]);
    }

    public function accept($appointment_id, $accept=true)
    {
        //check if doctor and patient exist
        if($this->exists('appointments', $appointment_id) && (!$accept || !$this->isConflicting($appointment_id))){
            $data = [];
            $data[] = $accept?'Accepted':'Declined';
            $data[] = $appointment_id;
            return $this->query(
                "update appointments set status = ? where id = ?",
                'si', 
                $data
            );
        }
        return false;
    }

    private function isConflicting($appointment_id){
        $result = $this->select(
            'select count(a.id) as count, comp_start_date, comp_end_date
            from appointments a, 
                (select start_date as comp_start_date, end_date as comp_end_date
                 from appointments where id = ?) comp
            where status = "Accepted" and start_date >= comp_start_date and end_date <= comp_end_date', 
            'i', 
            [$appointment_id]);
        if($result[0]['count'] > 0)
            return true;
        return false;
    }
}