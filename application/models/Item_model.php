<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model 
{
    protected $table = 'items';

    public function rules()
    {
        return [
            [
                'field' => "name",
                'label' => "Name",
                'rules' => 'required'
            ],
            [
                'field' => "category",
                'label' => "Category",
                'rules' => 'required'
            ],
            [
                'field' => "stock",
                'label' => "Stock",
                'rules' => 'required'
            ],
            [
                'field' => "purchase",
                'label' => "Purchase Price",
                'rules' => 'required'
            ],
            [
                'field' => "selling",
                'label' => "Selling Price",
                'rules' => 'required'
            ],
            [
                'field' => "date",
                'label' => "Date In",
                'rules' => 'required'
            ],
        ];
    }

    public function get_all_items()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_all_items_by_category()
    {
        return $this->db->distinct()
        ->select('category')
        ->get('items')
        ->result();
    }

    public function get_items_by_category($category)
    {
        return $this->db->get_where($this->table, ['category' => $category])->result();
    }

    public function get_item_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_item_where($conditions = [])
    {
        return $this->db->get_where($this->table, $conditions)->row();
    }

    public function insert_item($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_item($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_item($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}