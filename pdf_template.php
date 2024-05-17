<?php
session_start();
require_once('vendor/tecnickcom/tcpdf/tcpdf.php'); // Make sure TCPDF is correctly included

class PDF extends TCPDF {
    public function Header() {
       
    }

    public function Footer() {
       
    }
}


$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('PDF Template');
$pdf->SetSubject('PDF Template');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->SetFont('helvetica', '', 12);


$pages = isset($_SESSION['pages']) ? $_SESSION['pages'] : [];

// Added front cover
$pdf->AddPage();
$frontpage = [
    'text' => 'Yadlapalli Akhil Book',
    'backgroundImage' => 'background1.jpg',
    'author' => 'Yadlapalli Akhil'
];

$pdf->Image($frontpage['backgroundImage'], 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
$pdf->SetXY(10, 10);
$pdf->MultiCell(0, 0, $frontpage['text'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(100, 240);
$pdf->MultiCell(0, 0, 'Written By ' . $frontpage['author'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);

// Added pages
foreach ($pages as $page) {
    $pdf->AddPage();
    
    $bgImage = $page['backgroundImage'];
    $text = $page['text'];
    
    // Added background image
    $pdf->Image($bgImage, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), '', '', '', true, 300, '', false, false, 0);

    // Added text
    $pdf->SetXY(10, 10);
    $pdf->MultiCell(0, 0, $text, 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
}

// Added back cover
$pdf->AddPage();
$backpage = [
    'text' => 'Yadlapalli Akhil Book',
    'backgroundImage' => 'background2.jpg',
    'author' => 'Yadlapalli Akhil'
];
$pdf->Image($backpage['backgroundImage'], 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), '', '', '', true, 300, '', false, false, 0);
$pdf->SetXY(10, 10);
$pdf->MultiCell(0, 0, $backpage['text'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 20);
$pdf->MultiCell(0, 0, "Written by ".$backpage['author'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);


//PDF document
$pdf->Output('pdf_template.pdf', 'I');
?>
