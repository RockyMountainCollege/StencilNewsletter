<?php

class ApiReportBack extends CI_Controller {
     function __construct(){
        parent::__construct();
    }

    function logIt($data) {
        $fn = 'log/log.txt';
        $message = date(DATE_RFC822);
        $message .= ' '.$data;
        // Write out the log message
        file_put_contents($fn, $message, FILE_APPEND | LOCK_EX);
    }

    public function index(){

        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = file_get_contents("php://input");

            $json = json_decode($result);

            foreach($json as $key => $value) {
                if($value) {
                    switch ($value->event) {
                        case "open":
                        case "delivered":
                        case "spamreport":
                        case "unsubscribe":
                            if (isset($value->category) && is_array($value->category)) {
                                foreach($value->category as $k => $category){
                                    $insert_values = array(
                                        'ts'        =>  $value->timestamp,
                                        'event'     =>  $value->event,
                                        'email'     =>  $value->email,
                                        'category'  =>  $category
                                    );

                                    if(!$this->db->table_exists($category."_events")){
                                        $this->load->model('Campaign_model');
                                        $this->Campaign_model->migrate_to_separate_event_table($category);
                                    }

                                    $this->db->insert($category."_events", $insert_values);
                                }
                            }
                            break;
                        case "click":
                            if (isset($value->category) && is_array($value->category)) {
                                foreach($value->category as $k => $category){
                                    $insert_values = array(
                                        'ts'        =>  $value->timestamp,
                                        'event'     =>  $value->event,
                                        'email'     =>  $value->email,
                                        'url'       =>  $value->url,
                                        'category'  =>  $category
                                    );

                                    if(!$this->db->table_exists($category."_events")){
                                        $this->load->model('Campaign_model');
                                        $this->Campaign_model->migrate_to_separate_event_table($category);
                                    }

                                    $this->db->insert($category."_events", $insert_values);
                                }
                            }
                            break;
                        case "bounce":
                            if (isset($value->category) && is_array($value->category)) {
                                foreach($value->category as $k => $category){
                                    $insert_values = array(
                                        'ts'        =>  $value->timestamp,
                                        'event'     =>  $value->event,
                                        'email'     =>  $value->email,
                                        'status'    =>  $value->status,
                                        'reason'    =>  $value->reason,
                                        'type'      =>  $value->type,
                                        'category'  =>  $category
                                    );

                                    if(!$this->db->table_exists($category."_events")){
                                        $this->load->model('Campaign_model');
                                        $this->Campaign_model->migrate_to_separate_event_table($category);
                                    }

                                    $this->db->insert($category."_events", $insert_values);
                                }
                            }
                            break;
                        default:
                            // Unknown event log it
                            $this->logIt($result);
                    }
                }
            }
        }
    }
}
?>
