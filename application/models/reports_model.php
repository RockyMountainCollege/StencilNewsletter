<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all($reportID)
    {
        // $sql = "SELECT id, email, event FROM log WHERE category='$reportID'";
        // $query = $this->db->query($sql);
        $this->db->select('id, email, event');
        $query = $this->db->get_where('log', array('category' => $reportID));
        return $query->result();
    }

    function get_all_list($reportID, $listName)
    {
        // Get all the entries on a per list basis
        // $sql = "SELECT log.id, $listName.email, log.event FROM $listName LEFT JOIN log ON $listName.email = log.email AND log.category='$reportID'";
        $this->db->select("log.id, $listName.email, log.event");
        $this->db->from($listName);
        $this->db->join('log', "$listName.email=log.email AND log.category='$reportID'", 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function get_clicked($reportID, $listName)
    {
        // $sql = "SELECT id, email, event FROM log WHERE category='$reportID' AND event='click' GROUP BY(email)";
        $this->db->select('id, email, event');
        $this->db->from('log');
        $this->db->where(array('category'=>$reportID, 'event'=>'click'));
        $this->db->group_by('email');
        $query = $this->db->get();
        return $query->result();
    }

    function get_opened($reportID, $listName)
    {
        // $sql = "SELECT id, email, event FROM log l1 WHERE category='$reportID' AND event='open' AND NOT EXISTS (SELECT email FROM log l2 WHERE l1.email = l2.email AND category='$reportID' AND event='click') GROUP BY(email)";
        $this->db->select('id, email, event');
        $this->db->from('log');
        $this->db->where(array('category'=>$reportID, 'event'=>'open'));
        // $this->db->where("NOT EXISTS (SELECT email FROM log AS l2 WHERE l1.email = l2.email AND category='$reportID' AND event='open')");
        // $this->db->group_by('email');
        $query = $this->db->get();
        // $query = $this->db->query($sql);
        return $query->result();
    }

    function get_unopened($reportID, $listName)
    {
        // $sql = "SELECT log.id, $listName.email, log.event FROM $listName LEFT JOIN log ON $listName.email = log.email AND log.category='$reportID' WHERE log.event IS NULL";
        // $query = $this->db->query($sql);

        $this->db->select("log.id, $listName.email, log.event");//, log.event");
        $this->db->from("`$listName`");
        $this->db->join('log', "`$listName`.email=log.email AND log.category='$reportID'", 'left');
        $this->db->where(array('log.event !='=>"'open'", 'log.event !='=>"'click'"));
        $query = $this->db->get();
        return $query->result();
    }
}
/* End of file reports_model.php */
/* Location: ./application/models/reports_model.php */
