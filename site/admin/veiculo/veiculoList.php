<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();

$termo = trim($_GET['termo'] ?? '');
$campo_filtro = trim($_GET['campo_filtro'] ?? 'modelo');

$veiculos = $database->listarVeiculos($termo, $campo_filtro);
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container mt-4 pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Estoque de Veículos</h3>
            <p class="text-muted small m-0">Administre o catálogo de supercarros disponíveis.</p>
        </div>
        <a href="VeiculoForm.php" class="btn btn-porsche-dark fw-bold px-3 py-2">
            <i class="fa-solid fa-plus me-2"></i> Adicionar Veículo
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
        <form method="GET" action="VeiculoList.php" class="row g-2 align-items-end">
            
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Buscar por:</label>
                <select name="campo_filtro" class="form-select form-select-sm bg-light">
                    <option value="modelo" <?php echo ($campo_filtro == 'modelo') ? 'selected' : ''; ?>>Modelo</option>
                    <option value="marca" <?php echo ($campo_filtro == 'marca') ? 'selected' : ''; ?>>Marca</option>
                    <option value="cor" <?php echo ($campo_filtro == 'cor') ? 'selected' : ''; ?>>Cor</option>
                    <option value="ano_fabricacao" <?php echo ($campo_filtro == 'ano_fabricacao') ? 'selected' : ''; ?>>Ano de Fab.</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Digite o termo da pesquisa</label>
                <input type="text" name="termo" class="form-control form-control-sm bg-light" placeholder="O que você procura?..." value="<?php echo htmlspecialchars($termo); ?>">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-porsche-dark fw-bold flex-grow-1 py-2">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                </button>
                <?php if (!empty($termo)): ?>
                    <a href="VeiculoList.php" class="btn btn-sm btn-light border py-2 text-muted" title="Limpar Filtro">
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
                        <th class="py-3">Marca / Modelo</th>
                        <th class="py-3">Ano Fab.</th>
                        <th class="py-3">Cor</th>
                        <th class="py-3">Potência</th>
                        <th class="py-3">Preço</th>
                        <th class="py-3 text-center" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($veiculos) > 0): ?>
                        <?php foreach ($veiculos as $car): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?php echo $car['id']; ?></td>
                                <td>
                                    <span class="badge bg-dark text-white rounded-1 small me-1"><?php echo htmlspecialchars($car['marca'] ?? ''); ?></span>
                                    <strong class="text-dark d-block"><?php echo htmlspecialchars($car['modelo'] ?? ''); ?></strong>
                                </td>
                                <td><?php echo intval($car['ano_fabricacao'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($car['cor'] ?? 'Não informada'); ?></td>
                                <td><?php echo htmlspecialchars($car['potencia'] ?? ''); ?></td>
                                <td class="fw-bold text-success">R$ <?php echo number_format($car['preco'] ?? 0, 2, ',', '.'); ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="VeiculoForm.php?id=<?php echo $car['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="VeiculoAction.php?action=delete&id=<?php echo $car['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja remover este veículo?');"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted">Nenhum carro correspondente encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>