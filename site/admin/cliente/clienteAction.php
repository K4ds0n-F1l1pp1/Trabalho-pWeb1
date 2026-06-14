<?php

session_start();
require_once '../../db.class.php';

$database = new DB();
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    if ($database->excluirCliente($id)) {
        header("Location: ClienteList.php?success=deleted");
    } else {
        header("Location: ClienteList.php?error=db_fail");
    }
    exit;
}

header("Location: ClienteList.php");
exit;