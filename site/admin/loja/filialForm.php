<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$mensagem = "";
$classe_alerta = "alert-danger";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_unidade = trim($_POST['nome_unidade'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = strtoupper(trim($_POST['estado'] ?? ''));
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if (empty($nome_unidade) || empty($cidade) || empty($estado)) {
        $mensagem = "Os campos Nome da Unidade, Cidade e UF são obrigatórios!";
    } else {
        $db = $database->connect();
        $sql = "INSERT INTO filiais (nome_unidade, cidade, estado, telefone, endereco) 
                VALUES (:nome_unidade, :cidade, :estado, :telefone, :endereco)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome_unidade', $nome_unidade);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);

        if ($stmt->execute()) {
            $mensagem = "Nova filial cadastrada com sucesso!";
            $classe_alerta = "alert-success";
        } else {
            $mensagem = "Erro ao tentar salvar a filial.";
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white bg-dark p-3">
                <h5 class="m-0 small fw-bold"><i class="fa-solid fa-building me-2"></i> Cadastrar Nova Filial</h5>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="filialForm.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nome da Unidade</label>
                        <input type="text" class="form-control" name="nome_unidade" placeholder="Ex: Premium Chapecó" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label small fw-bold text-muted">Cidade</label>
                            <input type="text" class="form-control" name="cidade" placeholder="Ex: Chapecó" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">UF</label>
                            <input type="text" class="form-control" name="estado" maxlength="2" placeholder="Ex: SC" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Endereço Completo</label>
                        <input type="text" class="form-control" name="endereco" placeholder="Ex: Av. Getúlio Vargas, 1200 - Centro">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Telefone / Ramal</label>
                        <input type="text" class="form-control" name="telefone" placeholder="Ex: (49) 3333-3333">
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="filialList.php" class="btn btn-sm btn-outline-secondary px-3">Ver Listagem</a>
                        <button type="submit" class="btn btn-sm btn-dark px-4">Salvar Filial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>