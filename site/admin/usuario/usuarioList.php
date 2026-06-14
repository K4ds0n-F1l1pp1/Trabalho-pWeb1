<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$pesquisa = trim($_GET['pesquisa'] ?? '');
$filtro_tipo = trim($_GET['tipo'] ?? '');

$usuarios = $database->listarUsuarios($pesquisa, $filtro_tipo);
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container mt-4 pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Gestão de Usuários</h3>
            <p class="text-muted small m-0">Visualize e gerencie os vendedores cadastrados no sistema.</p>
        </div>
        <a href="usuarioForm.php" class="btn btn-porsche-dark fw-bold px-3 py-2">
            <i class="fa-solid fa-user-plus me-2"></i> Adicionar Usuário
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
        <form method="GET" action="usuarioList.php" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted">Pesquisar por Nome ou E-mail</label>
                <input type="text" name="pesquisa" class="form-control form-control-sm bg-light" placeholder="Digite o termo..." value="<?php echo htmlspecialchars($pesquisa); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Filtrar por Tipo</label>
                <select name="tipo" class="form-select form-select-sm bg-light">
                    <option value="">Todos os tipos</option>
                    <option value="Administrador" <?php echo ($filtro_tipo == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="Vendedor" <?php echo ($filtro_tipo == 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-porsche-dark fw-bold flex-grow-1 py-2">Filtrar</button>
                <?php if (!empty($pesquisa) || !empty($filtro_tipo)): ?>
                    <a href="usuarioList.php" class="btn btn-sm btn-light border py-2 text-muted"><i class="fa-solid fa-filter-circle-xmark"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: var(--bg-dark-premium); color: #ffffff;">
                    <tr>
                        <th class="py-3 ps-4" style="width: 80px;">ID</th>
                        <th class="py-3">Nome Completo</th>
                        <th class="py-3">E-mail de Acesso</th>
                        <th class="py-3">Nível</th>
                        <th class="py-3 text-center" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($usuarios) > 0): ?>
                        <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?php echo $user['id']; ?></td>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($user['nome']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge rounded-pill px-2 py-1 <?php echo ($user['tipo'] === 'Administrador') ? 'bg-danger bg-opacity-10 text-danger' : 'bg-secondary bg-opacity-10 text-secondary'; ?>">
                                        <?php echo $user['tipo']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="usuarioForm.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="usuarioAction.php?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir permanentemente o usuário?');"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">Nenhum usuário encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

include '../../footer.php'; 

?>