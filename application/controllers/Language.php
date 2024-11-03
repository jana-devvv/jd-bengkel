<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller 
{
    public function switch($language = "english") 
    {
        $this->session->set_userdata('site_lang', $language);

        redirect($_SERVER['HTTP_REFERRER']);
    }
}