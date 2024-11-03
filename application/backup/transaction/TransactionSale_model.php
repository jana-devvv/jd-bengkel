<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionSale_model extends CI_Model
{
    public function rules()
    {
        return [
            [
                'field' => 'customer',
                'label' => 'Customer',
                'rules' => 'required'
            ],
            [
                'field' => 'sale_date',
                'label' => 'Sale Date',
                'rules' => 'required'
            ],
            [
                'field' => 'sale_total',
                'label' => 'Sale Total',
                'rules' => 'required'
            ],
        ];
    }

    public function get_yearly_sales_summary($year)
    {
        $this->db->select('MONTH(sale_date) as month, SUM(sale_total) as total_sales, COUNT(id) as total_transactions');
        $this->db->from('sales');
        $this->db->where('YEAR(sale_date)', $year);
        $this->db->group_by('MONTH(sale_date)');
        $this->db->order_by('MONTH(sale_date)', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    

    public function get_popular_items()
    {
        $this->db->select('items.id, items.name, SUM(sales_detail.amount) AS total_sold');
        $this->db->from('items');
        $this->db->join('sales_detail', 'sales_detail.id_item = items.id', 'left');
        $this->db->group_by('items.id');
        $this->db->order_by('total_sold', 'DESC');
        return $this->db->get()->row();
    }

    public function get_popular_services()
    {
        $this->db->select('services.id, services.name, SUM(sales_detail.amount) AS total_sold');
        $this->db->from('services');
        $this->db->join('sales_detail', 'sales_detail.id_service = services.id', 'left');
        $this->db->group_by('services.id');
        $this->db->order_by('total_sold', 'DESC');
        return $this->db->get()->row();
    }

    public function get_all_transaction_sales()
    {
        return $this->db->get('sales')->result();
    }

    public function get_total_sales_today($date)
    {
        $this->db->select_sum('sale_total');
        $this->db->where('DATE(sale_date)', $date);
        $query = $this->db->get('sales');
        return $query->row()->sale_total ? $query->row()->sale_total : 0;
    }

    public function get_transaction_sale_by_id($id)
    {
        $this->db->select('customers.name as customer_name, sales.*')
        ->from('sales')
        ->join('customers', 'sales.id_customer = customers.id')
        ->where('sales.id', $id);
        return $this->db->get()->row();
    }

    public function insert_transaction_sale($data)
    {
        return $this->db->insert('sales', $data);
    }

    public function update_transaction_sale($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('sales', $data);
    }

    public function destroy_transaction_sale($id)
    {
        return $this->db->delete('sales', array('id' => $id));
    }
}