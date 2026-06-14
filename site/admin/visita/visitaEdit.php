<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$db = $database->connect();

$id = intval($_GET['id'] ?? 0);

$stmt = $db->prepare("SELECT * FROM visita WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$visita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$visita) {
    echo "<div class='alert alert-danger text-center mt-4'>Agendamento não encontrado!</div>";
    include '../../footer.php';
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'deletar') {
    $stmtDelete = $db->prepare("DELETE FROM visita WHERE id = :id");
    $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmtDelete->execute()) {
        echo "<script>window.location.href='VisitaCalendar.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $veiculo_id = intval($_POST['veiculo_id'] ?? 0);
    $data_visita = $_POST['data_visita'] ?? '';
    $horario_visita = $_POST['horario_visita'] ?? '';
    $obs = trim($_POST['obs'] ?? '');
    $status = $_POST['status'] ?? 'Pendente';

    $sql = "UPDATE visita SET data_visita = :data_visita, horario_visita = :horario_visita, 
            obs = :obs, status = :status, cliente_id = :cliente_id, veiculo_id = :veiculo_id WHERE id = :id";
    $stmtUpdate = $db->prepare($sql);
    $stmtUpdate->bindParam(':data_visita', $data_visita);
    $stmtUpdate->bindParam(':horario_visita', $horario_visita);
    $stmtUpdate->bindParam(':obs', $obs);
    $stmtUpdate->bindParam(':status', $status);
    $stmtUpdate->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmtUpdate->execute()) {
        echo "<script>window.location.href='VisitaCalendar.php';</script>";
        exit;
    }
}

$clientes = $db->query("SELECT id, nome_complete FROM cliente ORDER BY nome_complete ASC")->fetchAll(PDO::FETCH_ASSOC);
$carros = $db->query("SELECT id, marca, modelo FROM veiculo ORDER BY modelo ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white bg-dark p-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 small fw-bold"><i class="fa-solid fa-calendar-check me-2"></i> Editar Compromisso</h5>
                <a href="VisitaEdit.php?id=<?php echo $id; ?>&acao=deletar" class="btn btn-xs btn-danger py-1 px-2 small fw-bold" onclick="return confirm('Remover esta visita do calendário?');">
                    <i class="fa-solid fa-trash me-1"></i> Desmarcar
                </a>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="VisitaEdit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Cliente</label>
                        <select class="form-select" name="cliente_id" required>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?php echo $c['id']; ?>" <?php echo $visita['cliente_id'] == $c['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['nome_complete']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Veículo</label>
                        <select class="form-select" name="veiculo_id" required>
                            <?php foreach ($carros as $car): ?>
                                <option value="<?php echo $car['id']; ?>" <?php echo $visita['veiculo_id'] == $car['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($car['marca'] . " " . $car['modelo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Data</label>
                            <input type="date" class="form-control" name="data_visita" value="<?php echo $visita['data_visita']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Horário</label>
                            <input type="time" class="form-control" name="horario_visita" value="<?php echo $visita['horario_visita']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Status</label>
                        <select class="form-select" name="status">
                            <option value="Pendente" <?php echo $visita['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Concluída" <?php echo $visita['status'] === 'Concluída' ? 'selected' : ''; ?>>Concluída</option>
                            <option value="Cancelada" <?php echo $visita['status'] === 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Observações</label>
                        <textarea class="form-control" name="obs" rows="3"><?php echo htmlspecialchars($visita['obs'] ?? ''); ?></textarea>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="VisitaCalendar.php" class="btn btn-sm btn-outline-secondary px-3">Voltar</a>
                        <button type="submit" class="btn btn-sm btn-dark px-4">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>