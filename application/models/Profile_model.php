<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model 
{
    protected $table = 'profiles';

    public function rules()
    {
        return [
            [
                'field' => "id_user",
                'label' => "User ID",
                'rules' => 'required'
            ]
        ];
    }

    public function get_all_profile()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_profile_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_profile_where($conditions = [])
    {
        if(!empty($conditions)) {
            return $this->db->get_where($this->table, $conditions)->row();
        }
    }

    public function insert_profile($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_profile($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_profile($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}