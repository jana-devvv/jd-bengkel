<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model
{
    protected $table = 'services';

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
        return $this->db->get($this->table)->result();
    }

    public function get_service_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_service($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_service($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_service($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}