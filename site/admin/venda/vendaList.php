<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$vendas = $database->listarVendas();

$total_faturado = 0;
$total_comissoes = 0;
foreach ($vendas as $v) {
    $total_faturado += $v['valor_final'];
    $total_comissoes += $v['comissao'];
}
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container mt-4 pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Histórico de Vendas</h3>
            <p class="text-muted small m-0">Acompanhe as negociações fechadas, faturamento e comissões.</p>
        </div>
        <a href="vendaForm.php" class="btn btn-success fw-bold px-3 py-2">
            <i class="fa-solid fa-cart-shopping me-2"></i> Nova Venda
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-success border-4">
                <span class="text-muted small fw-bold text-uppercase d-block">Receita Total Bruta</span>
                <h4 class="fw-bold text-success m-0">R$ <?php echo number_format($total_faturado, 2, ',', '.'); ?></h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-primary border-4">
                <span class="text-muted small fw-bold text-uppercase d-block">Total em Comissões</span>
                <h4 class="fw-bold text-primary m-0">R$ <?php echo number_format($total_comissoes, 2, ',', '.'); ?></h4>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: var(--bg-dark-premium); color: #ffffff;">
                    <tr>
                        <th class="py-3 ps-4" style="width: 80px;">Ref.</th>
                        <th class="py-3">Data</th>
                        <th class="py-3">Veículo</th>
                        <th class="py-3">Vendedor</th>
                        <th class="py-3">Cliente</th>
                        <th class="py-3">Comissão</th>
                        <th class="py-3">Valor Final</th>
                        <th class="py-3 text-center" style="width: 100px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($vendas) > 0): ?>
                        <?php foreach ($vendas as $v): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?php echo $v['id']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($v['data_venda'])); ?></td>
                                <td>
                                    <strong class="text-dark"><?php echo htmlspecialchars($v['modelo']); ?></strong>
                                    <span class="text-muted small d-block"><?php echo htmlspecialchars($v['marca']); ?></span>
                                </td>
                                <td><i class="fa-solid fa-user-tie text-muted me-1 small"></i> <?php echo htmlspecialchars($v['vendedor']); ?></td>
                                <td><i class="fa-solid fa-user text-muted me-1 small"></i> <?php echo htmlspecialchars($v['cliente']); ?></td>
                                <td class="text-primary fw-bold">R$ <?php echo number_format($v['comissao'], 2, ',', '.'); ?></td>
                                <td class="text-success fw-bold">R$ <?php echo number_format($v['valor_final'], 2, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="vendaAction.php?action=delete&id=<?php echo $v['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja estornar esta venda? O histórico será removido.');" title="Estornar Venda"><i class="fa-solid fa-arrow-rotate-left"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center py-5 text-muted"><i class="fa-solid fa-handshake fs-2 mb-3 d-block text-light"></i> Nenhuma venda realizada até o momento.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>