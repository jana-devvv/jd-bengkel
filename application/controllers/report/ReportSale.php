<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportSale extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('report_model');
        $this->load->library('excel');
        $this->load->library('pdf');
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
        $date = $this->input->post('date');
        $data = $this->report_model->get_report_by_date($date);

        $result = ['data' => $data];
        echo json_encode($result);
    }

    public function pdf($date)
    {
        $report = $this->report_model->get_report_where(['report_date' => $date]);

        $data = [
            'title' => 'PDF | JD Bengkel',
            'date' => $date,
            'report' => $report,
        ];
        
        $html = $this->load->view('report/sale/pdf', $data, TRUE);
        $filename = 'report.pdf';

        $this->pdf->export($html, $filename);
    }

    public function excel($date)
    {
        $report = $this->report_model->get_report_where(['report_date' => $date]);

        $data = [];
        $data[] = [
            $report->total_sales,
            $report->total_expenditure,
            $report->report_date,
        ];

        $headers = ["NO", "TOTAL SALES", "TOTAL EXPENDITURE", "DATE"];
        $title = "DATA REPORT";
        $filename = "report";

        $this->excel->export($data, $title, $headers, $filename);
    }
}