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
