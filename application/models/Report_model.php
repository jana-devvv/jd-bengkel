<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model 
{
    public function get_sales_report_by_date($start_date = NULL, $end_date = NULL)
    {   
        $this->db->select('sales.*, customers.name as customer_name');
        $this->db->from('sales');
        $this->db->join('customers', 'sales.id_customer = customers.id');
        $this->db->where('sales.sale_date >=', $start_date);
        $this->db->where('sales.sale_date <=', $end_date);

        $query = $this->db->get();
        return $query->result();
    }
}