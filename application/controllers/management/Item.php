<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Item extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged();
        $this->load->model('item_model');
        $this->load->library('form_validation');
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

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output file PDF
        $dompdf->stream("test.pdf", array("Attachment" => TRUE));
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
          'font' => ['bold' => true], 
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
          ],
          'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] 
          ]
        ];

        $style_row = [
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
          ],
          'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
          ]
        ];

        $sheet->setCellValue('A1', "DATA ITEM");
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true); 

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "NAME"); 
        $sheet->setCellValue('C3', "CATEGORY"); 
        $sheet->setCellValue('D3', "STOCK");
        $sheet->setCellValue('E3', "PURCHASE (Rp)");
        $sheet->setCellValue('F3', "SELLING (Rp)");
        $sheet->setCellValue('G3', "DATE");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        $items = $this->item_model->get_all_items();
        $no = 1; 
        $numrow = 4;
        foreach($items as $item){
          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $item->name);
          $sheet->setCellValue('C'.$numrow, $item->category);
          $sheet->setCellValue('D'.$numrow, $item->stock);
          $sheet->setCellValue('E'.$numrow, $item->purchase_price);
          $sheet->setCellValue('F'.$numrow, $item->selling_price);
          $sheet->setCellValue('G'.$numrow, $item->date_in);
          
          $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
          
          $no++; 
          $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5); 
        $sheet->getColumnDimension('B')->setWidth(25); 
        $sheet->getColumnDimension('C')->setWidth(20); 
        $sheet->getColumnDimension('D')->setWidth(10); 
        $sheet->getColumnDimension('E')->setWidth(15); 
        $sheet->getColumnDimension('F')->setWidth(15); 
        $sheet->getColumnDimension('G')->setWidth(10); 

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Item");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Items.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
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
