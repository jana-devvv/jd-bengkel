<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model
{
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
        return $this->db->get('items')->result();
    }

    public function get_item_by_id($id)
    {
        return $this->db->get_where('items', array('id' => $id))->row();
    }

    public function insert_item($data)
    {
        return $this->db->insert('items', $data);
    }

    public function update_item($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('items', $data);
    }

    public function destroy_item($id)
    {
        return $this->db->delete('items', array('id' => $id));
    }
}