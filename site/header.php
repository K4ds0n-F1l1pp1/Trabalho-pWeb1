<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pagina_atual = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['usuario_id']) && $pagina_atual != 'login.php' && $pagina_atual != 'registro.php') {
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    header("Location: " . $protocolo . "://" . $_SERVER['HTTP_HOST'] . "//Trabalho-pWeb1/site/login.php");
    exit();
}

$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Trabalho-pWeb1/site/";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVows - Sistema de Gestão Automotiva</title>
    <link rel="icon" type="image/png" href="/assets/images/carroIcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $base_url; ?>index.php">
            <i class="fa-solid fa-car-side text-warning"></i> CAR<span class="text-warning">VOWS</span>
        </a>
        <button class="navbar-dark navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isset($_SESSION['usuario_id'])): ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>index.php"><i class="fa-solid fa-chart-pie"></i> Painel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/admin/loja/filialList.php"><i class="fa-solid fa-shop"></i> Lojas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/admin/veiculo/veiculoList.php"><i class="fa-solid fa-gauge"></i> Estoque</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/admin/cliente/clienteList.php"><i class="fa-solid fa-users"></i> Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/admin/venda/vendaList.php"><i class="fa-solid fa-handshake"></i> Vendas</a>
                </li>
            </ul>
            <div class="d-flex align-items-center text-light">
                <span class="me-3 small"><i class="fa-solid fa-user text-warning"></i> Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong> (<?php echo $_SESSION['usuario_tipo']; ?>)</span>
                <a href="<?php echo $base_url; ?>logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container pb-5">