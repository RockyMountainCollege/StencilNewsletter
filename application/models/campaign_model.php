<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_campaigns()
    {
        $this->db->select('campaign');
        $query = $this->db->get('campaigns');
        return $query->result();
    }

    function get_recipients($campaign)
    {
        $this->db->select('list_id');
        $query = $this->db->get_where('campaigns', array('campaign'=>$campaign));
        return $query->result();
    }

    function insert_campaign($data)
    {
        $this->db->insert('campaigns', $data);
    }

    /*
    $data consists of an array containing:
      list_id => the name of the contact list (and that list's table)
      campaign_id => the name of the campaign
      event_table => the name of the event table for this campaign
    */
    function create_campaign_event_table($data){
      $event_fields = array(
          'ts'        =>  array(
            'type'        =>  'INT',
            'constraint'  =>  '11'
          ),
          'event'     =>  array(
            'type'        =>  'VARCHAR',
            'constraint'  =>  '25'
          ),
          'status'    =>  array(
            'type'        =>  'VARCHAR',
            'constraint'  =>  '255'
          ),
          'reason'    =>  array(
            'type'        =>  'VARCHAR',
            'constraint'  =>  '255'
          ),
          'type'      =>  array(
            'type'        =>  'VARCHAR',
            'constraint'  =>  '255'
          ),
      );

      $contact_fields = array();
      foreach($this->db->field_data($data['list_id']) as $field){
        $contact_fields[$field->name] = array(
              'type'        =>  $field->type,
              'constraint'  =>  $field->max_length
            );
      }

      $this->load->dbforge();
      $this->dbforge->add_field($contact_fields + $event_fields);
      $this->dbforge->create_table($data['event_table']);

      $query = $this->db->get($data['list_id']);
      $res_array = $query->result_array();

      $this->db->insert_batch($data['event_table'], $res_array);
    }

    function delete_campaign($campaign)
    {
        // Delete from the campaigns table
        $this->db->where('campaign', $campaign);
        $this->db->delete('campaigns');

        // Remove from log
        $this->db->where('category', $campaign);
        $this->db->delete('log');
    }

}
/* End of file campaign_model.php */
/* Location: ./application/models/campaign_model.php */
