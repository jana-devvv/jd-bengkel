<?php

if(!function_exists('is_logged')) {
    function is_logged() {
        $ci =& get_instance();
        
        if(!$ci->session->userdata('is_auth')) {
            $ci->session->set_flashdata('error', 'Access restricted! Log in to continue.');
            redirect('auth/login');
            exit;
        }
    }
}

if(!function_exists('is_guest')) {
    function is_guest() {
        $ci =& get_instance();
        
        if($ci->session->userdata('is_auth')) {
            $ci->session->set_flashdata("message", "Access denied! You're already logged in.");
            redirect('dashboard');
            exit;
        }
    }
}