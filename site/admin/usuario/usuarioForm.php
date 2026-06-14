<?php

include '../../header.php';
require_once '../../db.class.php';

$mensagem = "";
$classe_alerta = "alert-danger";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $tipo = $_POST['tipo'] ?? 'Vendedor';

    if (empty($nome) || empty($telefone) || empty($email) || empty($login) || empty($senha))
        {
            $mensagem = "Por favor, preencha todos os campos obrigatórios!";
        } else {
            $database = new DB();
            $db = $database->connect();

            try {
                $stmt = $db->prepare("SELECT id FROM usuario WHERE login = :login OR email = :email");
                $stmt->bindParam(':login', $login);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) 
                {
                    $mensagem = "Este nome de usuário ou e-mail já está em uso!";
                } {
                    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO usuario (nome, telefone, email, login, senha, tipo) 
                            VALUES (:nome, :telefone, :email, :login, :senha, :tipo)";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':telefone', $telefone);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':login', $login);
                    $stmt->bindParam(':senha', $senha_cripto);
                    $stmt->bindParam(':tipo', $tipo);

                    if ($stmt->execute()) {
                        $mensagem = "Usuário cadastrado com sucesso no MySQL!";
                        $classe_alerta = "alert-success";
                    }
                }
        } catch (PDOException $e) {
            $mensagem = "Erro no banco de dados: " . $e->getMessage();
        }
    }
}
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-6">
        
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white p-3" style="background-color: var(--arenarot);">
                <h5 class="m-0 font-porsche-header" style="font-size: 1rem;">
                    <i class="fa-solid fa-user-plus"></i> Novo Membro do Time CarVows
                </h5>
            </div>
            
            <div class="card-body p-4">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <form action="UsuarioForm.php" method="POST" class="needs-validation" novalidate>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nome Completo</label>
                        <input type="text" class="form-control" name="nome" required placeholder="Ex: Kadson Silva">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Telefone / Celular</label>
                            <input type="text" class="form-control" name="telefone" required placeholder="(49) 99999-0000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Nível de Acesso</label>
                            <select class="form-select" name="tipo">
                                <option value="Vendedor">Vendedor (Padrão)</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">E-mail Corporativo</label>
                        <input type="email" class="form-control" name="email" required placeholder="nome@carvows.com">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Nome de Usuário (Login)</label>
                            <input type="text" class="form-control" name="login" required placeholder="Ex: kadson.vendas">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Senha de Acesso</label>
                            <input type="password" class="form-control" name="senha" required placeholder="Crie uma senha">
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-between">
                        <a href="../../index.php" class="btn btn-sm btn-outline-secondary px-3">
                            <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
                        </a>
                        <button type="submit" class="btn btn-sm btn-porsche px-4">
                            Salvar Usuário <i class="fa-solid fa-check ms-1"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<?php

include '../../footer.php';

?>