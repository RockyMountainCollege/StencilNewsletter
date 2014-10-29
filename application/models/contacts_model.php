<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create_list($listName, $data)
    {
        // Helpers
        $this->load->dbforge();
        // Create table
        $this->dbforge->add_field('id');
        $this->dbforge->add_field($data);
        $this->dbforge->create_table($listName);
        // Register table
        $this->db->insert('contactLists', array('list_name'=>$listName));
    }

    function add_member($listName, $data)
    {
        $this->db->insert($listName, $data);
    }

    function delete_member($listName, $id)
    {
        $this->db->delete($listName, array('id' => $id));
    }

    function update_member($listName, $id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($listName, $data);
    }

    function get_lists()
    {
        $this->db->select('list_name');
        $query = $this->db->get('contactLists');
        return $query->result();
    }


    function get_list_names(){
        return array_map(
            function($list){
                return $list->list_name;
            },
            $this->get_lists()
        );
    }

    function delete_list($listID)
    {
        // Helpers
        $this->load->dbforge();

        // Delete from the campaigns tables
        $this->db->where('list_id', $listID);
        $this->db->delete('campaigns');

        // Delete from the contactLists table
        $this->db->where('list_name', $listID);
        $this->db->delete('contactLists');

        // Drop list table
        $this->dbforge->drop_table($listID);
    }

    function get_emails($listName)
    {
        $this->db->select('email');
        $query = $this->db->get($listName);
        return $query->result();
    }

    function get_fields($listName)
    {
        return $this->db->list_fields($listName);
    }

    function get_table($listName)
    {
        $query = $this->db->get($listName);
        return $query->result();
    }

    function get_subs($listName, $col)
    {
        $arr = array();
        $this->db->select($col);
        $query = $this->db->get($listName);
        foreach ($query->result() as $row)
            array_push($arr, $row->$col);
        return $arr;
    }

    function count_members($tableName)
    {
        return $this->db->count_all($tableName);
    }
}
/* End of file contacts_model.php */
/* Location: ./application/models/contacts_model.php */
