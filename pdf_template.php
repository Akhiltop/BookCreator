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
$pdf->SetAuthor('Akhil Yadlapalli');
$pdf->SetTitle('My Book');
$pdf->SetSubject('My Book');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);

$pdf->SetFont('helvetica', '', 12);


$pages = isset($_SESSION['pages']) ? $_SESSION['pages'] : [];

// Added front cover
$pdf->AddPage();
$frontpage = $_SESSION['frontpage'];


$pdf->Image($frontpage['backgroundImage'], 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

$pdf->SetFont('helvetica', '', 95);
$pdf->SetXY(10, 10);
$pdf->MultiCell(0, 0, $frontpage['text'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetFont('helvetica', '', 32);
$pdf->SetXY(40, 255);
$pdf->MultiCell(0, 0, 'Written By ' . $frontpage['author'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);

// Added pages


foreach ($pages as $page) {
    $pdf->AddPage('L');
    
    $bgImage = $page['backgroundImage'];
    $text = $page['text'];
    
    // Added background image
    $pdf->Image($bgImage, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), '', '', '', true, 300, '', false, false, 0);

    // Added text
    $pdf->SetXY(10, 10);
    $pdf->MultiCell(0, 0, $text, 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
}

// Added back cover
$pdf->AddPage('P');
$backpage = $_SESSION['backpage'];
$pdf->Image($backpage['backgroundImage'], 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), '', '', '', true, 300, '', false, false, 0);
$pdf->SetFont('helvetica', '', 42);
$pdf->SetXY(10, 10);
$pdf->MultiCell(0, 0, $backpage['text'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetFont('helvetica', '', 24);
$pdf->SetXY(10, 30);
$pdf->MultiCell(0, 0, "Written by ".$backpage['author'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetFont('helvetica', '', 15);
$pdf->SetXY(10, 100);
$pdf->MultiCell(0, 0,$backpage['author'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->Image($backpage['authorImage'], 10, 60, 30, 30, '', '', '', true, 300, '', false, false, 0);

$pdf->SetFont('helvetica', '', 15);
$pdf->SetXY(60, 60);
$pdf->MultiCell(0, 0,$backpage['authorMessage'], 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 120);
$pdf->MultiCell(0, 0,"Published by BriBooks", 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 135);
$pub_text="BriBooks is the world's leading children creative writing platform,enabling children to learn creative writing and publish their books on global outlets such as Amazon. Powered by a cutting-edge AI system, BriBooks combines the complete process of ideation,creativity,book writing,publishing,and selling on one single platform.";
$pdf->MultiCell(0, 0,$pub_text, 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 190);
$pdf->MultiCell(0, 0,"© BriBooks", 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 215);
$pdf->MultiCell(0, 0,"www.bribooks.com", 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->SetXY(10, 225);
$pdf->MultiCell(0, 0,"Preview copy for limited distribution", 0, 'L', 0, 1, '', '', true, 0, true, true, 0, 'T', true);
$pdf->Image($backpage['backgroundImage'], 150, 225, 30, 30, '', '', '', true, 300, '', false, false, 0);
$pdf->Line(10, 50, 200, 50);
$pdf->Line(10, 115, 200, 115);
$pdf->Line(10, 205, 200, 205);


//PDF document
$pdf->Output('pdf_template.pdf', 'I');
?>
