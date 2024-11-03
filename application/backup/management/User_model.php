<?php

class Backup_User_model extends CI_Model 
{
    public function rules($update = false)
    {
        $rules = [
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
            ],
        ];

        if(!$update) {
            $rules[] = [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ];
        }
        
        return $rules;
    }

    public function login($email, $password)
    {
        return $user = $this->db->get_where('users', ['email' => $email])->row();
    }

    public function get_all_users()
    {
        $this->db->select('id, username, email, role');
        return $this->db->get('users')->result();
    }   
    
    public function get_user_by_id($id)
    {
        $this->db->select('id, username, email, role');
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function get_user_by_username($username)
    {
        $this->db->select('id, username, email, password, role');
        return $this->db->get_where('users', array('username' => $username))->row();
    }

    public function get_user_by_email($email)
    {
        return $this->db->get_where('users', array('email' => $email))->row();
    }

    public function get_user_by_token($token)
    {
        return $this->db->get_where('users', array('reset_token' => $token))->row();
    }

    public function set_reset_token($user_id, $token)
    {
        $this->db->update('users', ['reset_token' => $token], ['id' => $user_id]);
    }

    public function update_password($user_id, $new_password)
    {
        $this->db->update('users', ['password' => $new_password], ['id' => $user_id]);
    }

    public function clear_reset_token($user_id)
    {
        $this->db->update('users', ['reset_token' => NULL], ['id' => $user_id]);
    }

    public function insert_user($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data)
    {
        if(!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        $this->db->where('id', $id);

        return $this->db->update('users', $data);
    }

    public function destroy_user($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }
} 