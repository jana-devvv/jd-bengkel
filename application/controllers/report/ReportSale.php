<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportSale extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('report_model');
    }

    public function index()
    {
        $data['breadcrumbs'] = ['Report', 'Sale'];
        $data['title'] = 'Report | JD Bengkel';

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('report/sale/index', $data);
        $this->load->view('_layouts/main/main_end');
    }

    public function fetch_data()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if(empty($start_date))
        {
            $start_date = date('Y-m-d') . ' 00:00:00';
        }

        if(empty($end_date)) {
            $end_date = date('Y-m-d') . ' 00:00:00';
        }

        $data = $this->report_model->get_sales_report_by_date($start_date, $end_date);

        $result = array('data' => $data);
        echo json_encode($result);
    }
}