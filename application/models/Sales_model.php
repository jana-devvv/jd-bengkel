<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model 
{
    protected $table = 'sales';

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

    public function get_all_sales()
    {
        return $this->db->select('sales.id, customers.name as customer_name, sales.sale_date, sales.sale_total')
        ->from($this->table)
        ->join('customers', 'sales.id_customer = customers.id')
        ->get()
        ->result();
    }

    public function get_sales_by_id($id)
    {
        return $this->db->select('customers.name as customer_name, sales.*')
        ->from($this->table)
        ->join('customers', 'sales.id_customer = customers.id')
        ->where('sales.id', $id)
        ->get()
        ->row();
    }

    public function get_insert_id()
    {
        return $this->db->insert_id();
    }

    public function insert_sales($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_sales($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_sales($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_total_sales($date)
    {
        $query = $this->db->select_sum('sale_total')
        ->from($this->table)
        ->where('DATE(sale_date)', $date)
        ->get();

        return $query->row()->sale_total ? $query->row()->sale_total : 0;
    }

    public function get_popular_sales()
    {
        return $this->db->select('services.name as service_name, items.name as item_name, COUNT(sales_detail.id) as total_sales')
        ->from('sales_detail')
        ->join('services', 'sales_detail.id_service = services.id', 'left')
        ->join('items', 'sales_detail.id_item = items.id', 'left')
        ->group_by(['services.name', 'items.name'])
        ->order_by('total_sales', 'DESC')
        ->limit(5)
        ->get()
        ->result();
    }

    public function get_yearly_sales($year)
    {
        return $this->db->select('MONTH(sale_date) as month, SUM(sale_total) as total_sales, COUNT(id) as total_transactions')
        ->from($this->table)
        ->where('YEAR(sale_date)', $year)
        ->group_by('MONTH(sale_date)')
        ->order_by('MONTH(sale_date)', 'ASC')
        ->get()
        ->result();
    }
}