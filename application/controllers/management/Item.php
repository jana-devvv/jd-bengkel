<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('item_model');
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['breadcrumbs'] = ['Management', 'Item'];
        $data['title'] = 'Item | JD Bengkel';

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('management/item/index', $data);
        $this->load->view('_layouts/main/main_end');
    }    

    public function pdf()
    {
        $items = $this->item_model->get_all_items();

        $data = [
            'title' => 'PDF | JD Bengkel',
            'items' => $items,
        ];
        
        // Load tampilan sebagai HTML
        $html = $this->load->view('management/item/pdf', $data, TRUE);
        $filename = 'items.pdf';

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

    // AJAX
    public function fetch_all()
    {
        $data = $this->item_model->get_all_items();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetch_categories()
    {
        $data = $this->item_model->get_all_items_by_category();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function insert()
    {
        $rules = $this->item_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'category' => form_error('category'),
                'stock' => form_error('stock'),
                'purchase' => form_error('purchase'),
                'selling' => form_error('selling'),
                'date' => form_error('date'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'stock' => $this->input->post('stock'),
                'purchase_price' => $this->input->post('purchase'),
                'selling_price' => $this->input->post('selling'),
                'date_in' => $this->input->post('date'),
            ];

            $this->item_model->insert_item($data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function edit($id)
    {
        $data = $this->item_model->get_item_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $rules = $this->item_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = [
                'name' => form_error('name'),
                'category' => form_error('category'),
                'stock' => form_error('stock'),
                'purchase' => form_error('purchase'),
                'selling' => form_error('selling'),
                'date' => form_error('date'),
            ];

            echo json_encode(array('status' => 'error', 'errors' => $errors));
        } else {
            $id = $this->input->post('id');
            $data = [
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'stock' => $this->input->post('stock'),
                'purchase_price' => $this->input->post('purchase'),
                'selling_price' => $this->input->post('selling'),
                'date_in' => $this->input->post('date'),
            ];

            $this->item_model->update_item($id, $data);
            echo json_encode(array('status' =>'success' ));
        }
    }

    public function destroy($id)
    {
        $this->item_model->destroy_item($id);
        echo json_encode(array('status', 'success'));
    }
}
