<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos obrigatórios!";
    } else {

        require_once 'db.class.php';
        
        $database = new DB();
        $db = $database->connect();

        try {
            $sql = "SELECT * FROM usuario WHERE login = :login LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];

                header("Location: index.php");
                exit();
            } else {
                $erro = "Usuário ou senha incorretos.";
            }
        } catch (PDOException $e) {
            $erro = "Erro interno no sistema de autenticação: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVows - Login</title>

    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>assets/images/carroIcon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: var(--marmore);">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="text-center mb-4">
                <h2 class="font-porsche-header text-dark m-0">
                    <i class="fa-solid fa-car-side" style="color: var(--arenarot);"></i> CAR<span style="color: var(--modegrau);">VOWS</span>
                </h2>
                <p class="text-muted small font-monospace mt-1">THE CARS ENVIRONMENT</p>
            </div>

            <div class="card card-login p-4 rounded-3 border-0">
                <h4 class="text-center mb-4 font-porsche-header text-dark" style="font-size: 1.1rem;">Acesso</h4>

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger p-2 small text-center" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $erro; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="login" class="form-label small fw-bold">Usuário</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 py-2" id="login" name="login" required placeholder="Login">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="senha" class="form-label small fw-bold">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 py-2" id="senha" name="senha" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-porsche w-100 py-2.5 shadow-sm rounded-2">
                        ENTRAR <i class="fa-solid fa-chevron-right ms-1 small"></i>
                    </button>
                </form>
            </div>
            
            <div class="text-center mt-3">
                <p class="text-muted small">Leia nosso termo de privacidade e acessibilidade.</p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>