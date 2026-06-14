<?php
include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$db = $database->connect();
$mensagem = "";

$clientes = $db->query("SELECT id, nome_completo FROM cliente ORDER BY nome_completo ASC")->fetchAll(PDO::FETCH_ASSOC);
$carros = $db->query("SELECT id, marca, modelo FROM veiculo WHERE status = 'Disponivel' ORDER BY modelo ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $veiculo_id = intval($_POST['veiculo_id'] ?? 0);
    $data_visita = $_POST['data_visita'] ?? '';
    $horario_visita = $_POST['horario_visita'] ?? '';
    $obs = trim($_POST['obs'] ?? '');
    $status = $_POST['status'] ?? 'Pendente';

    if ($cliente_id === 0 || $veiculo_id === 0 || empty($data_visita) || empty($horario_visita)) {
        $mensagem = "Preencha todos os campos obrigatórios!";
    } else {
        $sql = "INSERT INTO visita (data_visita, horario_visita, obs, status, cliente_id, veiculo_id) 
                VALUES (:data_visita, :horario_visita, :obs, :status, :cliente_id, :veiculo_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':data_visita', $data_visita);
        $stmt->bindParam(':horario_visita', $horario_visita);
        $stmt->bindParam(':obs', $obs);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>window.location.href='VisitaCalendar.php';</script>";
            exit;
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white bg-dark p-3">
                <h5 class="m-0 small fw-bold"><i class="fa-solid fa-calendar-plus me-2"></i> Novo Agendamento</h5>
            </div>
            <div class="card-body p-4 bg-white">
                <?php if(!empty($mensagem)): ?>
                    <div class="alert alert-danger text-center small p-2"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="VisitaForm.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Cliente</label>
                        <select class="form-select" name="cliente_id" required>
                            <option value="">Selecione o cliente...</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nome_completo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Veículo</label>
                        <select class="form-select" name="veiculo_id" required>
                            <option value="">Selecione o veículo...</option>
                            <?php foreach ($carros as $car): ?>
                                <option value="<?php echo $car['id']; ?>"><?php echo htmlspecialchars($car['marca'] . " " . $car['modelo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Data</label>
                            <input type="date" class="form-control" name="data_visita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Horário</label>
                            <input type="time" class="form-control" name="horario_visita" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Status Inicial</label>
                        <select class="form-select" name="status">
                            <option value="Pendente">Pendente</option>
                            <option value="Concluída">Concluída</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Observações</label>
                        <textarea class="form-control" name="obs" rows="3" placeholder="Detalhes da visita..."></textarea>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="VisitaCalendar.php" class="btn btn-sm btn-outline-secondary px-3">Voltar</a>
                        <button type="submit" class="btn btn-sm btn-dark px-4">Agendar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>