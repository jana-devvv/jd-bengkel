<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('customer_model');
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->library('pdf');
    }
    
    public function index()
    {
        $data['breadcrumbs'] = ['Management', 'Customer'];
        $data['title'] = "Customer | JD Bengkel";

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('management/customer/index', $data);
        $this->load->view('_layouts/main/main_end');
    }    

    public function pdf()
    {
        $customers = $this->customer_model->get_all_customers();

        $data = [
            'title' => 'PDF | JD Bengkel',
            'customers' => $customers,
        ];
        
        // Load tampilan sebagai HTML
        $html = $this->load->view('management/customer/pdf', $data, TRUE);
        $filename = 'customers.pdf';

        $this->pdf->export($html, $filename);
    }

    public function excel()
    {
        $customers = $this->customer_model->get_all_customers();

        $data = [];
        foreach($customers as $customer) {
            $data[] = [
                $customer->name,
                $customer->phone_number,
                $customer->address,
                $customer->created_at,
            ];
        }

        $headers = ["NO", "NAME", "PHONE NUMBER", "ADDRESS", "DATE"];
        $title = "DATA CUSTOMER";
        $filename = "customers";

        $this->excel->export($data, $title, $headers, $filename);
    }

    // AJAX
    public function fetch_all()
    {
        $data = $this->customer_model->get_all_customers();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function insert()
    {
        $rules = $this->customer_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'phone' => form_error('phone'),
                'address' => form_error('address'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'phone_number' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
            ];

            $this->customer_model->insert_customer($data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function edit($id)
    {
        $data = $this->customer_model->get_customer_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $rules = $this->customer_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'phone' => form_error('phone'),
                'address' => form_error('address'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $id = $this->input->post('id');
            $data = [
                'name' => $this->input->post('name'),
                'phone_number' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
            ];

            $this->customer_model->update_customer($id, $data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function destroy($id)
    {
        $this->customer_model->destroy_customer($id);
        echo json_encode(array('status', 'success'));
    }
}
