<?php
include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$db = $database->connect();

$mensagem_alerta = "";
$tipo_alerta = "alert-success";
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'deleted') {
        $mensagem_alerta = "Filial removida com sucesso!";
    } elseif ($_GET['status'] === 'error_fk') {
        $mensagem_alerta = "Não é possível excluir esta filial pois existem veículos vinculados a ela!";
        $tipo_alerta = "alert-danger";
    }
}

$sql = "SELECT * FROM filiais ORDER BY nome_unidade ASC";
$stmt = $db->query($sql);
$filiais = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="m-0 fw-bold text-dark">Filiais Cadastradas</h4>
            <p class="text-muted small m-0">Gerencie as unidades e pontos de venda do sistema</p>
        </div>
        <a href="filialForm.php" class="btn btn-sm btn-dark px-3">
            <i class="fa-solid fa-plus me-1"></i> Nova Filial
        </a>
    </div>

    <?php if (!empty($mensagem_alerta)): ?>
        <div class="alert <?php echo $tipo_alerta; ?> text-center small p-2 mb-3" role="alert">
            <?php echo $mensagem_alerta; ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0 text-center small">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="p-3"># ID</th>
                        <th scope="col" class="p-3 text-start">Nome da Unidade</th>
                        <th scope="col" class="p-3 text-start">Endereço</th>
                        <th scope="col" class="p-3">Cidade / UF</th>
                        <th scope="col" class="p-3">Telefone</th>
                        <th scope="col" class="p-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($filiais) > 0): ?>
                        <?php foreach ($filiais as $f): ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?php echo $f['id']; ?></td>
                                <td class="text-start fw-bold text-dark"><?php echo htmlspecialchars($f['nome_unidade']); ?></td>
                                <td class="text-start text-muted"><?php echo !empty($f['endereco']) ? htmlspecialchars($f['endereco']) : '---'; ?></td>
                                <td><?php echo htmlspecialchars($f['cidade'] . " - " . $f['estado']); ?></td>
                                <td><?php echo !empty($f['telefone']) ? htmlspecialchars($f['telefone']) : '---'; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="filialEdit.php?id=<?php echo $f['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="filialDelete.php?id=<?php echo $f['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Tem certeza de que deseja remover esta filial?');" 
                                           title="Excluir">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted p-4">
                                <i class="fa-solid fa-building-circle-exclamation fa-2x d-block mb-2 text-warning"></i>
                                Nenhuma filial cadastrada até o momento.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

include '../../footer.php';

?>