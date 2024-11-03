<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionSale extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('sales_model');
        $this->load->model('sales_detail_model');
        $this->load->model('service_model');
        $this->load->model('customer_model');
        $this->load->model('item_model');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $data['breadcrumbs'] = ['Transaction', 'Sale'];
        $data['title'] = 'Transaction | JD Bengkel';
        $data['customers'] = $this->customer_model->get_all_customers();
        $data['items_services'] = [$this->service_model->get_all_services(), $this->item_model->get_all_items()];

        $this->load->view('_layouts/main/main_start', $data);
        $this->load->view('transaction/sale/index', $data);
        $this->load->view('_layouts/main/main_end');
    }    

    // AJAX
    public function fetch_all()
    {
        $data = $this->sales_model->get_all_sales();
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetch_data()
    {
        $type = $this->input->post('type');
        if($type == 'service') {
            $data = $this->service_model->get_all_services();
        }
        
        if ($type == 'item') {
            $data = $this->item_model->get_all_items();
        }

        echo json_encode($data);
    }

    public function show() 
    {
        $id = $this->input->post('id');
        $data = $this->sales_detail_model->get_sales_detail_where(['id_sale' => $id]);
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function insert()
    {
        $rules = $this->sales_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = array(
                'customer' => form_error('customer'),
                'sale_date' => form_error('sale_date'),
                'sale_total' => form_error('sale_total'),
            );

            echo json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
        } else {
            $data = array(
                'id_customer' => $this->input->post('customer'),
                'sale_date' => $this->input->post('sale_date'),
                'sale_total' => $this->input->post('sale_total'),
            );

            $this->sales_model->insert_sales($data);
            $id_sale = $this->sales_model->get_insert_id();

            $transaction = $this->input->post('transaction');
            $data_detail = [];

            foreach($transaction as $key => $value) {
                if($value['type'] === 'service') {
                    $data_detail[$key] = array(
                        'id_sale' => $id_sale,
                        'id_service' => intval($value['name']),
                        'id_item' => null,
                        'amount' => $value['quantity'],
                        'subtotal' => $value['subtotal']
                    );
                } else if($value['type'] === 'item') {
                    $data_detail[$key] = array(
                        'id_sale' => $id_sale,
                        'id_item' => intval($value['name']),
                        'id_service' => null,
                        'amount' => $value['quantity'],
                        'subtotal' => $value['subtotal']
                    );

                    $item = $this->item_model->get_item_by_id($value['name']);
                    $stock = $item->stock - $value['quantity'];

                    $this->item_model->update_item($value['name'], ['stock' => $stock]);
                }
            }

            $this->sales_detail_model->insert_sales_detail($data_detail);
    
            echo json_encode(array('status' => 'success'));
        }
    }

    public function edit($id)
    {
        $sale = $this->sales_model->get_sales_by_id($id);
        $detail = $this->sales_detail_model->get_sales_detail_where(['id_sale' => $id]);

        foreach($detail as $d) {
            if($d->id_service !== null) {
                $type = $this->service_model->get_all_services();
            }
            
            if($d->id_item !== null) {
                $type = $this->item_model->get_all_items();
            }
        }

        $data = array('sale' => $sale, 'detail' => $detail, 'type' => $type);
        echo json_encode($data);
    }

    public function update()
    {
        $rules = $this->sales_model->rules();
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE) {
            $errors = array(
                'customer' => form_error('customer'),
                'sale_date' => form_error('sale_date'),
                'sale_total' => form_error('sale_total'),
            );

            echo json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
        } else {
            $id = $this->input->post('id');
            $deletedId = $this->input->post('deletedRows');

            if(!empty($deletedId)) {
                $this->sales_detail_model->destroy_sales_detail($deletedId);
            }

            $data = array(
                'id_customer' => $this->input->post('customer'),
                'sale_date' => $this->input->post('sale_date'),
                'sale_total' => $this->input->post('sale_total'),
            );

            $this->sales_model->update_sales($id, $data);

            $transaction = $this->input->post('transaction');
            $data_insert = [];
            $data_update = [];

            if (!empty($transaction)) {
                foreach ($transaction as $value) {
                    if ($value['type'] === 'service') {
                        $detail = array(
                            'id_sale' => $id,
                            'id_service' => intval($value['name']),
                            'id_item' => null,
                            'amount' => $value['quantity'],
                            'subtotal' => $value['subtotal']
                        );
                    } else if ($value['type'] === 'item') {
                        $detail = array(
                            'id_sale' => $id,
                            'id_item' => intval($value['name']),
                            'id_service' => null,
                            'amount' => $value['quantity'],
                            'subtotal' => $value['subtotal']
                        );
                    }

                    if (empty($value['id_detail'])) {
                        $data_insert[] = $detail;
                    } else {
                        $detail['id'] = $value['id_detail'];
                        $data_update[] = $detail;
                    }
                }

                if (!empty($data_insert)) {
                    $this->sales_detail_model->insert_sales_detail($data_insert);
                }

                if (!empty($data_update)) {
                    $this->sales_detail_model->update_sales_detail($data_update);
                }
            }
    
            echo json_encode(array('status' => 'success'));
        }
    }

    public function destroy($id)
    {
        $this->sales_model->destroy_sales($id);
        echo json_encode(array('status' => 'success'));
    }
}