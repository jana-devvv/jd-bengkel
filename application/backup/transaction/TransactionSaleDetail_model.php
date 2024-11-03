<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionSaleDetail_model extends CI_Model
{
    public function rules()
    {
        return [
            
        ];
    }

    public function get_all_transaction_sales_detail()
    {
        return $this->db->get('sales_detail')->result();
    }

    public function get_transaction_sale_detail_by_id($id)
    {
        return $this->db->get_where('sales_detail', array('id' => $id))->row();
    }

    public function get_transaction_sale_detail_by_id_sale($id)
    {
        $this->db->select('items.name as item_name, items.selling_price as item_price, services.name as service_name, services.price as service_price, sales.*, sales_detail.*')
        ->from('sales_detail')
        ->join('sales', 'sales_detail.id_sale = sales.id')
        ->join('services', 'sales_detail.id_service = services.id', 'left')
        ->join('items', 'sales_detail.id_item = items.id', 'left')
        ->where('id_sale', $id);

        return $this->db->get()->result();
    }

    public function insert_transaction_sale_detail($data)
    {
        return $this->db->insert_batch('sales_detail', $data);
    }

    public function update_transaction_sale_detail($data)
    {
        return $this->db->update_batch('sales_detail', $data, 'id');
    }

    public function destroy_transaction_sale_detail($id)
    {
        return $this->db->delete('sales_detail', array('id' => $id));
    }

    public function destroy_transaction_sale_detail_by_id_sale($id)
    {
        return $this->db->delete('sales_detail', array('id_sale' => $id));
    }
    
    public function destroy_transaction_sale_detail_by_id_row($rows)
    {
        $this->db->where_in('id', $rows);
        return $this->db->delete('sales_detail');
    }
}