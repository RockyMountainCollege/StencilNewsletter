<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        // Models
        $this->load->model('Campaign_model');
    }

    public function index()
    {
        // Helpers for this function
        $this->load->helper(array('form'));

        if($this->input->post('action') == 'view')
        {
            $campaign = $this->input->post('campaign');
            redirect("/reports/campaign/$campaign");
        }

        if($this->input->post('action') == 'delete')
        {
            $campaign = $this->input->post('campaign');
            $this->Campaign_model->delete_campaign($campaign);
            // Remove email file
            $fn = $campaign . '.html';
            if(!unlink ('./emails/'.$fn))
                die("Could not delete file, please contact ".$this->config->item("support_email"));
            redirect("/reports");
        }

        $data['records'] = $this->Campaign_model->get_campaigns();
        $data['active'] = 'reports';
        $footer['js'] = array('reports.js');

        // Render Views
        $this->load->view('header_view', $data);
        $this->load->view('reports_view', $data);
        $this->load->view('footer_view', $footer);
    }

    public function campaign($id)
    {
        $data['id'] = $id;
        $data['js'] = array('campaign.js');
        $data['active'] = 'reports';

        // Render Views
        $this->load->view('header_view', $data);
        $this->load->view('campaign_view', $data);
        $this->load->view('footer_view');
    }

    public function all($id)
    {
        // Models
        $this->load->model('Reports_model');
        $this->load->model('Campaign_model');

        // Stub view for report of all
        $data['log'] = $this->Reports_model->get_all($id);

        //Render Views
        $this->load->view('report_all_view', $data);
    }

    public function all_list($id)
    {
        // Get all events for specific list(s)
        // Models
        $this->load->model('Reports_model');
        $this->load->model('Campaign_model');

        // Stub view for report of all
        $data['log'] = array();
        foreach ($this->Campaign_model->get_recipients($id) as $list)
            $data['log'] = $data['log'] + $this->Reports_model->get_all($id, $list->list_id);

        //Render Views
        $this->load->view('report_all_view', $data);
    }

    public function clicked($id)
    {
        // Models
        $this->load->model('Reports_model');
        $this->load->model('Campaign_model');

        // Stub view for report of all
        $data['log'] = array();
        foreach ($this->Campaign_model->get_recipients($id) as $list)
            $data['log'] = $data['log'] + $this->Reports_model->get_clicked($id, $list->list_id);

        //Render Views
        $this->load->view('report_clicked_view', $data);
    }

    public function opened($id)
    {
        // Models
        $this->load->model('Reports_model');
        $this->load->model('Campaign_model');

        // Stub view for report of all
        $data['log'] = array();
        foreach ($this->Campaign_model->get_recipients($id) as $list)
            $data['log'] = $data['log'] + $this->Reports_model->get_opened($id, $list->list_id);

        //Render Views
        $this->load->view('report_opened_view', $data);
    }

    public function unopened($id)
    {
        // Models
        $this->load->model('Reports_model');
        $this->load->model('Campaign_model');

        // Stub view for report of all
        $data['log'] = array();
        foreach ($this->Campaign_model->get_recipients($id) as $list)
            $data['log'] = $data['log'] + $this->Reports_model->get_unopened($id, $list->list_id);
        //Render Views
        $this->load->view('report_unopened_view', $data);
    }

    public function export($id)
    {
        $this->load->model('Reports_model');
        $this->load->helper('download');

        $dlFile = tmpfile();

        fputcsv($dlFile, array("ID","E-Mail","Event"));
        foreach($this->Reports_model->get_all($id) as $event)
            fputcsv($dlFile, array($event->id, $event->email, $event->event));

        $meta = stream_get_meta_data($dlFile);
        $tempContents = file_get_contents($meta['uri']);
        
        force_download($id.'.csv', $tempContents);
        fclose($dlFile);
    }
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */
