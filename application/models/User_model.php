<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
    protected $table = 'users';

    public function rules_create()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required'
            ]
        ];        
    }

    public function rules_update()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required'
            ]
        ];
    }

    public function rules_login()
    {
        return [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
    }

    public function rules_forgot_password()
    {
        return [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ]
        ];
    }

    public function rules_reset_password()
    {
        return [
            [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[new_password]'
            ],
        ];
    }

    public function rules_change_password()
    {
        return [
            [
                'field' => 'old_password',
                'label' => 'Old Passsword',
                'rules' => 'required|callback_check_password'
            ],
            [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[new_password]'
            ],
        ];
    }

    public function get_all_users()
    {
        return $this->db->select('id, username, email, role')
        ->get($this->table)
        ->result();
    }

    public function count()
    {
        return $this->db->count_all($this->table);
    }

    public function get_user_by_id($id)
    {
        return $this->db->select('id, username, email, role')
        ->get_where($this->table, ['id' => $id])
        ->row();
    }

    public function get_user_where($conditions = [])
    {
        if(!empty($conditions)) {
            return $this->db->get_where($this->table, $conditions)->row();
        }
    }

    public function insert_user($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_user($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy_user($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}