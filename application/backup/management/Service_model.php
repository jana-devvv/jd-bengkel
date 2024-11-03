<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model
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
                'field' => "price",
                'label' => "Price",
                'rules' => 'required'
            ]
        ];
    }

    public function get_all_services()
    {
        return $this->db->get('services')->result();
    }

    public function get_service_by_id($id)
    {
        return $this->db->get_where('services', array('id' => $id))->row();
    }

    public function insert_service($data)
    {
        return $this->db->insert('services', $data);
    }

    public function update_service($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('services', $data);
    }

    public function destroy_service($id)
    {
        return $this->db->delete('services', array('id' => $id));
    }
}