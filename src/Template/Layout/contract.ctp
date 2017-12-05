<?php
$domPdf = new \Dompdf\Dompdf();

$domPdf->setPaper('A4', 'portrait');

$domPdf->loadHtml($this->fetch('content'));

$domPdf->render();

echo $domPdf->output();

unset($domPdf);
?>