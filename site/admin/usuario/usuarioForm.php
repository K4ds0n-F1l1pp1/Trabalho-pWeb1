<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$mensagem = "";
$classe_alerta = "alert-danger";

$id_edicao = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dados_usuario = null;

if ($id_edicao > 0) {
    $dados_usuario = $database->buscarUsuarioPorId($id_edicao);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $tipo = $_POST['tipo'] ?? 'Vendedor';

    if (empty($nome) || empty($telefone) || empty($email) || empty($login) || ($id === 0 && empty($senha))) {
        $mensagem = "Preencha todos os campos obrigatórios!";
    } else {
        if ($id > 0) {

            if ($database->atualizarUsuario($id, $nome, $telefone, $email, $login, $tipo, $senha)) {
                $mensagem = "Usuário atualizado com sucesso!";
                $classe_alerta = "alert-success";
                $dados_usuario = $database->buscarUsuarioPorId($id);
            }
        } else {

            $db = $database->connect();
            $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (nome, telefone, email, login, senha, tipo) VALUES (:nome, :telefone, :email, :login, :senha, :tipo)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':senha', $senha_cripto);
            $stmt->bindParam(':tipo', $tipo);
            
            if ($stmt->execute()) {
                $mensagem = "Novo membro cadastrado!";
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
                    <i class="fa-solid <?php echo $id_edicao > 0 ? 'fa-user-pen' : 'fa-user-plus'; ?> me-2"></i>
                    <?php echo $id_edicao > 0 ? 'Modificar Registro do Usuário' : 'Novo Membro do Time CarVows'; ?>
                </h5>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="usuarioForm.php<?php echo $id_edicao > 0 ? '?id='.$id_edicao : ''; ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nome Completo</label>
                        <input type="text" class="form-control" name="nome" required value="<?php echo htmlspecialchars($dados_usuario['nome'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Telefone</label>
                            <input type="text" class="form-control" name="telefone" required value="<?php echo htmlspecialchars($dados_usuario['telefone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Nível de Acesso</label>
                            <select class="form-select" name="tipo">
                                <option value="Vendedor" <?php echo (isset($dados_usuario['tipo']) && $dados_usuario['tipo'] == 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                <option value="Administrador" <?php echo (isset($dados_usuario['tipo']) && $dados_usuario['tipo'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">E-mail</label>
                        <input type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($dados_usuario['email'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Login</label>
                            <input type="text" class="form-control" name="login" required value="<?php echo htmlspecialchars($dados_usuario['login'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Senha <?php echo $id_edicao > 0 ? '(Deixe em branco para não alterar)' : ''; ?></label>
                            <input type="password" class="form-control" name="senha" <?php echo $id_edicao > 0 ? '' : 'required'; ?>>
                        </div>
                    </div>

                    <hr class="text-muted my-4">
                    <div class="d-flex justify-content-between">
                        <a href="usuarioList.php" class="btn btn-sm btn-outline-secondary px-3"><i class="fa-solid fa-arrow-left me-1"></i> Voltar</a>
                        <button type="submit" class="btn btn-sm btn-porsche-dark px-4">Salvar Alterações <i class="fa-solid fa-check ms-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>