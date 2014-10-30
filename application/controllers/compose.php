<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'sendgrid-php/SendGrid_loader.php';

class Compose extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
        // Helpers for this function
        $this->load->helper(array('string', 'file', 'form'));
        // Libraries
        $this->load->library('form_validation');
        // Models
        $this->load->model('Campaign_model');
        $this->load->model('Contacts_model');

        // Validation Rules
        $this->form_validation->set_rules('subject', 'E-mail Subject', 'required');
        $this->form_validation->set_rules('recipientList', 'Recipients', 'required');
        $this->form_validation->set_rules('emailBody', 'E-mail Body', 'required');
        $this->form_validation->set_rules('campaign', 'Campaign ID', 'required|callback_campaignID_check|callback_campaignID_unique');
        $this->form_validation->set_rules('from', 'Send From', 'valid_email');

        // Javascript libraries to load
        $data['js'] = array('ckeditor/ckeditor.js', 'compose.js');
        $data['records'] = $this->Contacts_model->get_lists();
        $data['active'] = 'compose';

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('header_view', $data);
            $this->load->view('compose_view', $data);
            $this->load->view('footer_view', $data);
        }
        else {
            // Gather the POST'ed variables
            $list       = $this->input->post('recipientList');
            $from       = $this->input->post('from');
            $subject    = $this->input->post('subject');
            $emailBody  = $this->input->post('emailBody');
            $campaign   = $this->input->post('campaign');

            // Publish mail body to web page
            $fn = $campaign . '.html';
            if (!write_file('./emails/'.$fn, $emailBody))
                die('Unable to write the file, email not sent. Contact support.');

            // Use sendgrid API to build and send mail
            $sendgrid = new SendGrid($this->config->item('sendgrid_user'), $this->config->item('sendgrid_key'));
            $mail = new SendGrid\Mail();
            //Build Email
            $mail->
                addCategory($campaign)->
                setFrom(is_null($from) ? $this->config->item('default_send_from') : $from)->
                setSubject($subject)->
                setText("Please view this email with your broswer at: ".base_url("/emails/$fn"));


            // Insert campaign data into table and build email address list
            $campaignData = array('list_id'=>$list, 'campaign'=>$campaign, 'subject'=>$subject, 'event_table'=>$campaign.'_events');
            $this->Campaign_model->insert_campaign($campaignData);
            $this->Campaign_model->create_campaign_event_table($campaignData);
            
            foreach ($this->Contacts_model->get_emails($list) as $address)
                $mail->addTo($address->email);

            //Process e-mail body see if subsitutions are needed
            $body = $mail->setHtml($emailBody);
            if (preg_match_all("/%([a-zA-Z0-9_]*)%/", $emailBody, $matches))
            {
                // Subsitutions are needed
                $subs = array_combine($matches[0], $matches[1]);
                foreach($subs as $key => $val){
                    if($this->db->field_exists($val, $list)){
                        $body->addSubstitution($key, $this->Contacts_model->get_subs($list, $val));
                    }
                }
            }

            //Send the email(s)
            $sendgrid->web->send($mail);

            //Show the success page
            $data['raw_email'] = base_url("/emails/$fn");
            $data['campaign'] = $campaign;
            $data['active'] = 'compose';

            //Render views
            $this->load->view('header_view', $data);
            $this->load->view('compose_success_view', $data);
            $this->load->view('footer_view',$data);
        }
    }

    //Ensure campaign ID is alphanum_
    public function campaignID_check($str){
        return !preg_match("/[^a-zA-Z0-9_]/", $str);
    }

    //Ensure campaign ID is unique
    public function campaignID_unique($str){
        return !in_array($str, array_map(function ($campaign) { return $campaign->campaign; }, $this->Campaign_model->get_campaigns()));
    }
}

/* End of file compose.php */
/* Location: ./application/controllers/compose.php */
