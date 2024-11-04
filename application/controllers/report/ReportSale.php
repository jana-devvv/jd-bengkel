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
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d H:i:s', strtotime($this->input->post('end_date')));

        $data = $this->report_model->get_sales_report_by_date($start_date, $end_date);

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function pdf($start_date, $end_date)
    {
        $report = $this->report_model->get_sales_report_by_date($start_date, $end_date);

        $data = [
            'title' => 'PDF | JD Bengkel',
            'report' => $report,
        ];
        
        // Load tampilan sebagai HTML
        $html = $this->load->view('report/sale/pdf', $data, TRUE);
        $filename = 'report.pdf';

        $this->pdf->export($html, $filename);
    }

    public function excel()
    {
        $items = $this->item_model->get_all_items();

        $data = [];
        foreach($items as $item) {
            $data[] = [
                $item->name,
                $item->category,
                $item->stock,
                $item->purchase_price,
                $item->selling_price,
                $item->date_in,
            ];
        }

        $headers = ["NO", "NAME", "CATEGORY", "STOCK", "PURCHASE (Rp)", "SELLING (Rp)", "DATE"];
        $title = "DATA ITEM";
        $filename = "items";

        $this->excel->export($data, $title, $headers, $filename);
    }
}