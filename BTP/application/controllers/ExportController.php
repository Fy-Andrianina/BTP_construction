<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'third_party/PHPExcel.php';
class ExportController extends CI_Controller {
    function __construct()
    {
        parent::__construct();  
        date_default_timezone_set('Europe/Moscow');

    }
    public function index(){

    }
    public function ExportPDF(){
        $this->load->library("tcpdf");
        $pdf = new TCPDF();
        $pdf->AddPage();
        $num=2;
        $html = '<h3>Bon de commande</h3>';
        $html .= '<p>Numero : ' .$num. '</p>';
        $html .= '
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Designation</th>
                   
                </tr>
            </thead>
            <tbody>';

            for($i =0;$i<6;$i++) {
                $html .= '
                        <tr>
                            <th></th>
                            <td style="text-align:center">' . $i . '</td>
                            <td>' .$i . '</td>
                            </tr>';
            }
            $html .= '</tbody>
            </table>';
    
            $pdf->writeHTML($html, true, false, true, false, '');
            
            $file='my_file'.$num.'.pdf';
            $pdf->Output($file, 'D');
            $pdfFilePath = FCPATH . 'assets/pdf/'.$file.'.pdf';
            $pdf->Output($pdfFilePath, 'F');
            $pdf->Output($pdfFilePath, 'D');
        
    }
    public function exportExcel(){
         // Créer un nouvel objet PHPExcel
         $objPHPExcel = new PHPExcel();

         // Ajouter des données
         $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nom');
         $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Âge');

         $objPHPExcel->getActiveSheet()->setCellValue('A2', 'John');
         $objPHPExcel->getActiveSheet()->setCellValue('B2', '30');
         $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Jane');
         $objPHPExcel->getActiveSheet()->setCellValue('B3', '25');
 
         // Enregistrer le fichier Excel
         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
         $file_path = FCPATH . '/assets/csv/output.xls'; // Chemin de sauvegarde du fichier Excel
         $objWriter->save($file_path);
 
         // Télécharger le fichier Excel
         header('Content-Type: application/vnd.ms-excel');
         header('Content-Disposition: attachment;filename="output.xls"');
         header('Cache-Control: max-age=0');
         readfile($file_path);
         exit;
    }
}
?>