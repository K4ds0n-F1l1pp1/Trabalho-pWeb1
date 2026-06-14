<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$db = $database->connect();
$mensagem = "";
$classe_alerta = "alert-danger";

$id = intval($_GET['id'] ?? 0);

$stmt = $db->prepare("SELECT * FROM filiais WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$filial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$filial) {
    echo "<div class='alert alert-danger text-center mt-4'>Filial não encontrada!</div>";
    include '../../footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_unidade = trim($_POST['nome_unidade'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = strtoupper(trim($_POST['estado'] ?? ''));
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if (empty($nome_unidade) || empty($cidade) || empty($estado)) {
        $mensagem = "Nome, Cidade e UF são obrigatórios!";
    } else {
        $sql = "UPDATE filiais SET nome_unidade = :nome_unidade, cidade = :cidade, estado = :estado, 
                telefone = :telefone, endereco = :endereco WHERE id = :id";
        $stmtUpdate = $db->prepare($sql);
        $stmtUpdate->bindParam(':nome_unidade', $nome_unidade);
        $stmtUpdate->bindParam(':cidade', $cidade);
        $stmtUpdate->bindParam(':estado', $estado);
        $stmtUpdate->bindParam(':telefone', $telefone);
        $stmtUpdate->bindParam(':endereco', $endereco);
        $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            $mensagem = "Filial atualizada com sucesso!";
            $classe_alerta = "alert-success";
            
            $filial['nome_unidade'] = $nome_unidade;
            $filial['cidade'] = $cidade;
            $filial['estado'] = $estado;
            $filial['telefone'] = $telefone;
            $filial['endereco'] = $endereco;
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white bg-dark p-3">
                <h5 class="m-0 small fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Editar Filial</h5>
            </div>
            <div class="card-body p-4 bg-white">
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="filialEdit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nome da Unidade</label>
                        <input type="text" class="form-control" name="nome_unidade" value="<?php echo htmlspecialchars($filial['nome_unidade']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label small fw-bold text-muted">Cidade</label>
                            <input type="text" class="form-control" name="cidade" value="<?php echo htmlspecialchars($filial['cidade']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">UF</label>
                            <input type="text" class="form-control" name="estado" maxlength="2" value="<?php echo htmlspecialchars($filial['estado']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Endereço Completo</label>
                        <input type="text" class="form-control" name="endereco" value="<?php echo htmlspecialchars($filial['endereco'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Telefone</label>
                        <input type="text" class="form-control" name="telefone" value="<?php echo htmlspecialchars($filial['telefone']); ?>">
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="filialList.php" class="btn btn-sm btn-outline-secondary px-3">Voltar</a>
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