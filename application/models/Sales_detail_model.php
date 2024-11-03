<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_detail_model extends CI_Model 
{
    protected $table = 'sales_detail';

    public function get_sales_detail_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_sales_detail_where($conditions = [])
    {
        return $this->db->select('items.name as item_name, items.selling_price as item_price, services.name as service_name, services.price as service_price, sales.*, sales_detail.*')
        ->from('sales')
        ->join('sales_detail', 'sales.id = sales_detail.id_sale')
        ->join('services', 'sales_detail.id_service = services.id', 'left')
        ->join('items', 'sales_detail.id_item = items.id', 'left')
        ->where($conditions)
        ->get()
        ->result();
    }

    public function insert_sales_detail($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    public function update_sales_detail($data)
    {
        return $this->db->update_batch($this->table, $data, 'id');
    }

    public function destroy_sales_detail($data)
    {
        return $this->db->where_in('id', $data)->delete($this->table);
    }
}