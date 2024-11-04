<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('sales_model');
        $this->load->model('item_model');
        $this->load->model('customer_model');
        $this->load->model('user_model');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Dashboard | JD Bengkel';
        $data['breadcrumbs'] = ['Dashboard'];

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('_layouts/main/main_end');
    }

    public function get_sales_data()
    {
        $year = $this->input->get('year');
        if(!$year){
            $year = date('Y');
        }

        $data = $this->sales_model->get_yearly_sales($year);
        $result = ['data' => $data];
        echo json_encode($result);
    }

    public function total_sales_today()
    {
        $today = date('Y-m-d');
        $total = $this->sales_model->get_total_sales($today);

        echo json_encode(['total_sales_today' => $total]);
    }

    public function new_customers_count()
    {
        $today = date('Y-m-d');
        $count = $this->customer_model->get_customer_count($today);

        echo json_encode(['new_customers_count' => $count]);
    }

    public function popular_sales()
    {
        $popular = $this->sales_model->get_popular_sales();
        $result = ['data' => $popular];
        echo json_encode($result);
    }

    public function total_user()
    {
        $total_user = $this->user_model->count();
        $result = ['total' => $total_user];
        echo json_encode($result);
    }

    public function total_stock()
    {
        $category = $this->input->post('category');
        
        $data = $this->item_model->get_items_by_category($category);
        $result = ['data' => $data];
        echo json_encode($result);
    }
}