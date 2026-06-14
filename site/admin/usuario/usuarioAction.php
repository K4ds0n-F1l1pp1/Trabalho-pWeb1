<?php
session_start();
require_once '../../db.class.php';

$database = new DB();
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $id) {
        header("Location: usuarioList.php?error=self_delete");
        exit;
    }

    if ($database->excluirUsuario($id)) {
        header("Location: usuarioList.php?success=deleted");
    } else {
        header("Location: usuarioList.php?error=db_fail");
    }
    exit;
}

header("Location: usuarioList.php");
exit;