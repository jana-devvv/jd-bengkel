<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function login()
    {
        $data['title'] = 'Sign In | JD Bengkel';
        is_guest();

        if($_POST) {
            $rules = $this->user_model->rules_login();
            $this->form_validation->set_rules($rules);

            if($this->form_validation->run() === FALSE) {
                return $this->load->view('auth/login', $data);
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->user_model->get_user_where(['email' => $email]);

            if($user && password_verify($password, $user->password)) {
                $user_data = [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_auth' => TRUE
                ];

                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('success', 'Logged in successfully! Welcome back!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password');
            }
        }

        $this->load->view('auth/login', $data);
    }

    public function forgot_password()
    {
        $data['title'] = 'Forgot Password | JD Bengkel';
        is_guest();

        if($_POST) {
            $rules = $this->user_model->rules_forgot_password();
            $this->form_validation->set_rules($rules);

            if($this->form_validation->run() === FALSE) {
                return $this->load->view('auth/forgot_password', $data);
            }

            $email = $this->input->post('email');
            $user = $this->user_model->get_user_where(['email' => $email]);

            if($user) {
                $token = bin2hex(random_bytes(50));
                $this->user_model->update_user($user->id, ['reset_token' => $token]);
                $reset_link = base_url('auth/reset-password/' . $token);
                $this->send_email($email, $reset_link);
                $this->session->set_flashdata('message', 'Reset link has been sent to your email.');
            } else {
                $this->session->set_flashdata('error', 'Email not found.');
                redirect('auth/forgot-password');
            }
        }

        $this->load->view('auth/forgot_password', $data);
    }

    public function reset_password($token)
    {
        $data = [
            'title' => 'Reset Password | JD Bengkel',
            'token' => $token
        ];
        
        is_guest();

        if(!$token) {
            $this->session->set_flashdata('error', 'Token invalid');
            redirect('auth/forgot-password');
        }

        if($_POST) {
            $rules = $this->user_model->rules_reset_password();
            $this->form_validation->set_rules($rules);

            if($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('new_password_error', form_error('new_password'));
                $this->session->set_flashdata('confirm_password_error', form_error('confirm_password'));
                redirect('auth/reset-password/' . $token);
            }

            $new_password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
            $confirm_password = $this->input->post('confirm_password');          

            $user = $this->user_model->get_user_where(['reset_token' => $token]);
            if($user) {
                $this->user_model->update_user($user->id, ['password' => $new_password, 'reset_token' => NULL]);
                $this->session->set_flashdata('message', 'Reset password successfully.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Token invalid');
                redirect('auth/forgot-password');
            }
        }

        $user = $this->user_model->get_user_where(['reset_token' => $token]);
        if($user) {
            $this->load->view('auth/reset_password', $data);
        } else {
            $this->session->set_flashdata('error', 'Token invalid');
            redirect('auth/forgot-password');
        }
    }

    public function send_email($to_email, $reset_link) 
    {
        $this->email->from('janagaming935@gmail.com', 'Jana Dev');
        $this->email->to($to_email);
        $this->email->subject('Reset Password');
        $this->email->message('Click this link to reset your password : ' . $reset_link);
        $this->email->send();
    }

    public function logout()
    {
        is_logged();
        $this->session->unset_userdata(['id', 'username', 'email', 'role', 'is_auth']);
        $this->session->set_flashdata('message', 'Logged out successfully!');
        redirect('auth/login');
    }
}
