<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Excel
{
    public function export($data, $title, $headers, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Styles
        $style_col = $this->getColumnStyle();
        $style_row = $this->getRowStyle();

        // Set title
        $lastColumn = chr(ord('A') + count($headers) - 1);
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells("A1:{$lastColumn}1"); 
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set headers
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $sheet->getStyle($col . '3')->applyFromArray($style_col);
            $col++;
        }

        // Fill data
        $numrow = 4;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $numrow, $index + 1);
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            
            $col = 'B'; 
            foreach ($item as $value) {
                $sheet->setCellValue($col . $numrow, $value);
                $sheet->getStyle($col . $numrow)->applyFromArray($style_row);
                $col++;
            }
            $numrow++;
        }

        // Set column widths dynamically
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Page settings
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle($title);

        // Output
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    private function getColumnStyle()
    {
        return [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => $this->getBorders()
        ];
    }

    private function getRowStyle()
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => $this->getBorders()
        ];
    }

    private function getBorders()
    {
        return [
            'top' => ['borderStyle' => Border::BORDER_THIN],
            'right' => ['borderStyle' => Border::BORDER_THIN],
            'bottom' => ['borderStyle' => Border::BORDER_THIN],
            'left' => ['borderStyle' => Border::BORDER_THIN]
        ];
    }
}
