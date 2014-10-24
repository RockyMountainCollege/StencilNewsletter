<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form'));
        // Models
        $this->load->model('Contacts_model');
    }

    function _combine($a, $b)
    {
        $acount = count($a);
        $bcount = count($b);
        $size = ($acount > $bcount) ? $bcount : $acount;
        $a = array_slice($a, 0, $size);
        $b = array_slice($b, 0, $size);
        return array_combine($a, $b);
    }

    function render_views_with_error($data, $error='An unknown error occured.'){
        $error = array('error' => $error);
        // Render views
        $this->load->view('header_view', $data);
        $this->load->view('contacts_view', $error);
        $this->load->view('contacts_upload_view');
        $this->load->view('footer_view');
    }


    public function index()
    {
        // Libraries
        $this->load->library('form_validation');

        // Validation Rules
        $this->form_validation->set_rules('listName', 'List Name', 'required');
        $this->form_validation->set_rules('listMembers', 'List Members', 'required');

        $data['lists'] = array();
        foreach ($this->Contacts_model->get_lists() as $list)
            $data['lists'] = $data['lists'] + array($list->list_name=>$this->Contacts_model->count_members($list->list_name));
        $data['active'] = 'contacts';
        $data['js'] = array('contacts.js');

        if ($this->form_validation->run() == FALSE)
        {
            // Render views
            $this->load->view('header_view', $data);
            $this->load->view('contacts_view', $data);
            $this->load->view('contacts_upload_view');
            $this->load->view('footer_view', $data);
        }
        else {
            // Gather the POST'ed variables
            $listName = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('listName'));

            if(!in_array(strtolower($listName), array_map('strtolower', $this->Contacts_model->get_list_names()))) {
                //$listMembers = "email\n";
                $listMembers = explode("\n", $this->input->post('listMembers')); // split on each line
                $listMembers = array_filter($listMembers, 'trim'); // remove any extra \r characters left behind

                $this->Contacts_model->create_list($listName, array('email'=>array('type'=>'VARCHAR', 'constraint' => '255')));

                foreach ($listMembers as $member)
                {
                    // Add each email address to the database
                    if (filter_var($member, FILTER_VALIDATE_EMAIL))
                        $this->Contacts_model->add_member($listName, array('email'=>$member));
                }
                redirect('/contacts/success/'.$listName);
            }
            else{
                $error = "List names must be unique.";
                $this->render_views_with_error($data, $error);
            }
        }
    }

    function upload()
    {
        $error = '';
        // Upload rules
        $config['upload_path'] = getcwd().'/uploads/';
        $config['allowed_types'] = 'csv|txt|text/csv';
        $config['max_size'] = '2000';

        $this->load->library('upload', $config);

        $data['active'] = 'contacts';
        $data['js'] = array('contacts.js');
        $data['lists'] = array();
        foreach ($this->Contacts_model->get_lists() as $list)
            $data['lists'] = $data['lists'] + array($list->list_name=>$this->Contacts_model->count_members($list->list_name));

        if (!$this->upload->do_upload()){
            $error = $this->upload->display_errors();

            $this->render_views_with_error($data, $error);
        }
        else {
            // Success
            $upload_data = $this->upload->data();

            $listName = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('listName'));
            if ($listName == '')
                $listName = preg_replace('/[^A-Za-z0-9_]/', '', $upload_data['raw_name']);

            if(!in_array(strtolower($listName), array_map('strtolower', $this->Contacts_model->get_list_names()))) {

                // Add this info to table
                $row_count = 0;
                $valid_list = false;
                if ($fh = fopen($upload_data['full_path'], "r"))
                {
                    // Process file
                    while (($csv = fgetcsv($fh, 1000, ",")) !== FALSE)
                    {
                        $row_count++;
                        if ($row_count == 1)
                        {
                            // Header row create table based off of this
                            $header = array();
                            $fields = array();
                            foreach ($csv as $field)
                            {
                                $header = $header + array($field=>array('type'=>'VARCHAR', 'constraint' => '255'));
                                array_push($fields, $field);
                            }

                            if(!in_array(strtolower("email"), array_map('strtolower', $fields)))
                                $error = "CSV files must contain email field.";
                            else {
                                $valid_list = true;
                                $this->Contacts_model->create_list($listName, $header);
                            }
                        }
                        else {
                            if($valid_list)
                                $this->Contacts_model->add_member($listName, $this->_combine($fields, $csv));
                        }
                    }
                    fclose($fh);
                }
                if($valid_list)
                    redirect('/contacts/success/'.$listName);
                else {
                    $this->render_views_with_error($data, $error);
                }
            }
            else{
                $this->render_views_with_error($data, 'List names must be unique.');
            }
        }
    }


    function edit($listName='none')
    {
        if($listName == 'none')
            redirect('/contacts');

        // Process $_POST
        if($this->input->post('pk'))
        {
            $id = $this->input->post('pk');
            $name = $this->input->post('name');
            $value = $this->input->post('value');
            $this->Contacts_model->update_member($listName, $id, array($name => $value));
        } elseif($this->input->post('delete')) {
            $this->Contacts_model->delete_member($listName, $this->input->post('delete'));
        } else {
            $header['active'] = 'contacts';
            $data['listID'] = $listName;
            $data['headers'] = $this->Contacts_model->get_fields($listName);
            $data['table'] = $this->Contacts_model->get_table($listName);
            $footer['js'] = array('bootstrap-editable.min.js', 'contacts_edit.js');

            // Render view
            $this->load->view('header_view', $header);
            $this->load->view('contacts_edit_view', $data);
            $this->load->view('footer_view', $footer);
        }
    }

    function delete()
    {
        if($this->input->post('listID'))
            $this->Contacts_model->delete_list($this->input->post('listID'));
        redirect('/contacts');
    }

    function success($listName='none')
    {
        $data['listName'] = $listName;
        $data['active'] = 'contacts';

        //Show the success page
        $this->load->view('header_view', $data);
        $this->load->view('contacts_success_view', $data);
        $this->load->view('footer_view');
    }
}

/* End of file contacts.php */
/* Location: ./application/controllers/contacts.php */
