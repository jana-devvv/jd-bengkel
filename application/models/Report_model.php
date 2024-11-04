<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model 
{
    protected $table = 'report';

    public function daily_report($date)
    {
        $this->db->select_sum('sale_total');
        $this->db->where('sale_date', $date);

        $total_sales = $this->db->get('sales')->row()->sale_total;

        $expenditure = $this->db->select('items.purchase_price, sales_detail.amount')
        ->from('sales_detail')
        ->join('items', 'items.id = sales_detail.id_item')
        ->join('sales', 'sales.id = sales_detail.id_sale')
        ->where('sales.sale_date', $date)
        ->get();

        $total_expenditure = 0;
        foreach($expenditure->result() as $row) {
            $total_expenditure += $row->amount * $row->purchase_price;
        }

        $data = [
            'report_date' => $date,
            'total_sales' => $total_sales,
            'total_expenditure' => $total_expenditure
        ];

        $this->db->insert($this->table, $data);
    }

    public function get_report_by_date($date)
    {
        return $this->db->get_where($this->table, ['report_date' => $date])->result();
    }

    public function get_report_where($conditions = [])
    {   
        return $this->db->get_where($this->table, $conditions)->row();
    }
}