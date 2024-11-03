<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model 
{
    protected $table = 'customers';

    public function rules()
    {
        return [
            [
                'field' => "name",
                'label' => "Name",
                'rules' => 'required'
            ],
            [
                'field' => "phone",
                'label' => "Phone Number",
                'rules' => 'required'
            ],
            [
                'field' => "address",
                'label' => "Address",
                'rules' => 'required'
            ],
        ];
    }

    public function get_all_customers()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_customer_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_customer($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_customer($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_customer($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_customer_count($date) 
    {
        return $this->db->where('DATE(created_at)', $date)->count_all_results($this->table);
    }
}