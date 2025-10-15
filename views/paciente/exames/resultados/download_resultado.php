<?php
    session_start();
    require_once "../../../../controllers/ResultadoExameController.php";

    $idResultado = $_GET['idResultado'];
    $controller = new ResultadoExameController($conn);
    $arquivo = $controller->buscarArquivoResultado($idResultado);

    if ($arquivo && $arquivo['arquivo']) {
        header('Content-Type: application/pdf'); // ou use $arquivo['tipo_arquivo']
        header('Content-Disposition: attachment; filename="resultado_' . $idResultado . '.pdf"');
        echo $arquivo['arquivo'];
        exit;
    } else {
        die("Arquivo não encontrado.");
    }
?>
