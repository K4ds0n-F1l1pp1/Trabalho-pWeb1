<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$mensagem = "";
$classe_alerta = "alert-danger";

$id_edicao = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dados_cliente = null;

if ($id_edicao > 0) {
    $dados_cliente = $database->buscarClientePorId($id_edicao);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nome_completo = trim($_POST['nome_completo'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $celular = trim($_POST['celular'] ?? '');

    if (empty($nome_completo) || empty($cpf)) {
        $mensagem = "O Nome Completo e o CPF são obrigatórios!";
    } else {
        if ($id > 0) {
            if ($database->atualizarCliente($id, $nome_completo, $cpf, $cidade, $celular)) {
                $mensagem = "Cadastro do cliente atualizado com sucesso!";
                $classe_alerta = "alert-success";
                $dados_cliente = $database->buscarClientePorId($id);
            }
        } else {
            $db = $database->connect();
            $sql = "INSERT INTO cliente (nome_completo, cpf, cidade, celular) VALUES (:nome_completo, :cpf, :cidade, :celular)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nome_completo', $nome_completo);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':celular', $celular);
            
            if ($stmt->execute()) {
                $mensagem = "Cliente cadastrado com sucesso na plataforma!";
                $classe_alerta = "alert-success";
            }
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white p-3" style="background-color: var(--bg-dark-premium);">
                <h5 class="m-0 small fw-bold">
                    <i class="fa-solid fa-user me-2"></i>
                    <?php echo $id_edicao > 0 ? 'Modificar Registro do Cliente #'.$id_edicao : 'Cadastrar Novo Cliente'; ?>
                </h5>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="ClienteForm.php<?php echo $id_edicao > 0 ? '?id='.$id_edicao : ''; ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nome Completo</label>
                        <input type="text" class="form-control" name="nome_completo" placeholder="Ex: Ayrton Senna da Silva" required value="<?php echo htmlspecialchars($dados_cliente['nome_complete'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">CPF</label>
                        <input type="text" class="form-control" name="cpf" placeholder="000.000.000-00" required value="<?php echo htmlspecialchars($dados_cliente['cpf'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Cidade</label>
                            <input type="text" class="form-control" name="cidade" placeholder="Ex: São Paulo" value="<?php echo htmlspecialchars($dados_cliente['cidade'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Celular / WhatsApp</label>
                            <input type="text" class="form-control" name="celular" placeholder="(00) 00000-0000" value="<?php echo htmlspecialchars($dados_cliente['celular'] ?? ''); ?>">
                        </div>
                    </div>

                    <hr class="text-muted my-4">
                    <div class="d-flex justify-content-between">
                        <a href="ClienteList.php" class="btn btn-sm btn-outline-secondary px-3"><i class="fa-solid fa-arrow-left me-1"></i> Voltar</a>
                        <button type="submit" class="btn btn-sm btn-porsche-dark px-4">Salvar Registro <i class="fa-solid fa-check ms-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>