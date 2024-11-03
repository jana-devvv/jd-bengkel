<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model
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
        return $this->db->get('customers')->result();
    }

    public function get_customer_by_id($id)
    {
        return $this->db->get_where('customers', array('id' => $id))->row();
    }

    public function get_new_customer_count($date) 
    {
        $this->db->where('DATE(created_at)', $date);
        return $this->db->count_all_results('customers');
    }

    public function insert_customer($data)
    {
        return $this->db->insert('customers', $data);
    }

    public function update_customer($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('customers', $data);
    }

    public function destroy_customer($id)
    {
        return $this->db->delete('customers', array('id' => $id));
    }
}