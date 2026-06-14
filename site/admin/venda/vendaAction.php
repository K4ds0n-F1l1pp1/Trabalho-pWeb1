<?php

session_start();
require_once '../../db.class.php';

$database = new DB();
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    if ($database->excluirVenda($id)) {
        header("Location: vendaList.php?success=restored");
    } else {
        header("Location: vendaList.php?error=db_fail");
    }
    exit;
}

header("Location: vendaList.php");
exit;