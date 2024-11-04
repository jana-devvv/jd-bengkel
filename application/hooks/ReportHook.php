<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportHook {
    protected $CI;
    protected $table = 'report';

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('report_model');
    }

    public function generate_report()
    {
        $date = date('Y-m-d');
        $this->CI->db->where('report_date', $date);
        $report_exists = $this->CI->db->get($this->table)->num_rows() > 0;

        if(!$report_exists) {
            $this->CI->report_model->daily_report($date);
        }
    }
}