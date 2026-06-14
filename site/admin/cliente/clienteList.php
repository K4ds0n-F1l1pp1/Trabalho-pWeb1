<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();

$termo = trim($_GET['termo'] ?? '');
$campo_filtro = trim($_GET['campo_filtro'] ?? 'nome_completo');

$clientes = $database->listarClientes($termo, $campo_filtro);
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container mt-4 pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Gestão de Clientes</h3>
            <p class="text-muted small m-0">Consulte e gerencie a base de compradores e interessados da CarVows.</p>
        </div>
        <a href="ClienteForm.php" class="btn btn-porsche-dark fw-bold px-3 py-2">
            <i class="fa-solid fa-plus me-2"></i> Adicionar Cliente
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
        <form method="GET" action="ClienteList.php" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Buscar por:</label>
                <select name="campo_filtro" class="form-select form-select-sm bg-light">
                    <option value="nome_completo" <?php echo ($campo_filtro == 'nome_completo') ? 'selected' : ''; ?>>Nome</option>
                    <option value="cpf" <?php echo ($campo_filtro == 'cpf') ? 'selected' : ''; ?>>CPF</option>
                    <option value="cidade" <?php echo ($campo_filtro == 'cidade') ? 'selected' : ''; ?>>Cidade</option>
                    <option value="celular" <?php echo ($campo_filtro == 'celular') ? 'selected' : ''; ?>>Celular</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Digite o termo da pesquisa</label>
                <input type="text" name="termo" class="form-control form-control-sm bg-light" placeholder="Procurar cliente..." value="<?php echo htmlspecialchars($termo); ?>">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-porsche-dark fw-bold flex-grow-1 py-2">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                </button>
                <?php if (!empty($termo)): ?>
                    <a href="ClienteList.php" class="btn btn-sm btn-light border py-2 text-muted">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </a>
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
                        <th class="py-3">CPF</th>
                        <th class="py-3">Cidade</th>
                        <th class="py-3">Celular</th>
                        <th class="py-3 text-center" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cli): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?php echo $cli['id']; ?></td>
                                <td><strong class="text-dark"><?php echo htmlspecialchars($cli['nome_completo'] ?? ''); ?></strong></td>
                                <td><?php echo htmlspecialchars($cli['cpf'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($cli['cidade'] ?? 'Não informada'); ?></td>
                                <td><i class="fa-brands fa-whatsapp text-success me-1"></i> <?php echo htmlspecialchars($cli['celular'] ?? ''); ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="ClienteForm.php?id=<?php echo $cli['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="ClienteAction.php?action=delete&id=<?php echo $cli['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?');"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">Nenhum cliente encontrado na base de dados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>