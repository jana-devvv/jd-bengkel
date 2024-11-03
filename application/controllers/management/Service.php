<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('service_model');
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->library('pdf');
    }
    
    public function index()
    {
        $data['breadcrumbs'] = ['Management', 'Service'];
        $data['title'] = 'Service | JD Bengkel';

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('management/service/index', $data);
        $this->load->view('_layouts/main/main_end');
    }    

    public function pdf()
    {
        $services = $this->service_model->get_all_services();

        $data = [
            'title' => 'PDF | JD Bengkel',
            'services' => $services,
        ];
        
        // Load tampilan sebagai HTML
        $html = $this->load->view('management/service/pdf', $data, TRUE);
        $filename = 'services.pdf';

        $this->pdf->export($html, $filename);
    }

    public function excel()
    {
        $services = $this->service_model->get_all_services();

        $data = [];
        foreach($services as $service) {
            $data[] = [
                $service->name,
                $service->price,
            ];
        }

        $headers = ["NO", "NAME", "PRICE"];
        $title = "DATA SERVICES";
        $filename = "services";

        $this->excel->export($data, $title, $headers, $filename);
    }

    // AJAX
    public function fetch_all()
    {
        $data = $this->service_model->get_all_services();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function insert()
    {
        $rules = $this->service_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'price' => form_error('price'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
            ];

            $this->service_model->insert_service($data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function edit($id)
    {
        $data = $this->service_model->get_service_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $rules = $this->service_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'price' => form_error('price'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $id = $this->input->post('id');
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
            ];

            $this->service_model->update_service($id, $data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function destroy($id)
    {
        $this->service_model->destroy_service($id);
        echo json_encode(array('status', 'success'));
    }
}
