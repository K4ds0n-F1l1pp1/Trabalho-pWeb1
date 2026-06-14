<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$mensagem = "";
$classe_alerta = "alert-danger";

$vendedores = $database->buscarVendedoresCombo();
$clientes = $database->buscarClientesCombo();
$carros_disponiveis = $database->listarVeiculosDisponiveis();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_venda = $_POST['data_venda'] ?? '';
    $valor_final = floatval(str_replace(['.', ','], ['', '.'], $_POST['valor_final'] ?? 0));
    $comissao = floatval(str_replace(['.', ','], ['', '.'], $_POST['comissao'] ?? 0));
    $usuario_id = intval($_POST['usuario_id'] ?? 0);
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $veiculo_id = intval($_POST['veiculo_id'] ?? 0);

    if (empty($data_venda) || $valor_final <= 0 || $usuario_id <= 0 || $cliente_id <= 0 || $veiculo_id <= 0) {
        $mensagem = "Certifique-se de preencher todos os campos da proposta de venda!";
    } else {
        if ($database->salvarVenda($data_venda, $valor_final, $comissao, $usuario_id, $cliente_id, $veiculo_id)) {
            $mensagem = "Venda realizada com sucesso! Nota de comissão gerada e veículo retirado do pátio.";
            $classe_alerta = "alert-success";
            $carros_disponiveis = $database->listarVeiculosDisponiveis();
        } else {
            $mensagem = "Erro crítico ao processar transação no banco de dados.";
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white p-3 bg-dark">
                <h5 class="m-0 small fw-bold">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i> Fechamento de Proposta Comercial
                </h5>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="vendaForm.php" method="POST">
                    
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-people-arrows me-1"></i> Partes Envolvidas</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Vendedor Responsável</label>
                            <select class="form-select" name="usuario_id" required>
                                <option value="">Selecione o vendedor...</option>
                                <?php foreach ($vendedores as $vended): ?>
                                    <option value="<?php echo $vended['id']; ?>"><?php echo htmlspecialchars($vended['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Cliente Comprador</label>
                            <select class="form-select" name="cliente_id" required>
                                <option value="">Selecione o comprador...</option>
                                <?php foreach ($clientes as $clie): ?>
                                    <option value="<?php echo $clie['id']; ?>"><?php echo htmlspecialchars($clie['nome_completo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mt-3 mb-3"><i class="fa-solid fa-car me-1"></i> Escolha do Veículo em Estoque</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Selecione o Carro Disponível</label>
                        <select class="form-select" name="veiculo_id" required>
                            <option value="">Selecione um carro do pátio...</option>
                            <?php foreach ($carros_disponiveis as $carro): ?>
                                <option value="<?php echo $carro['id']; ?>">
                                    <?php echo htmlspecialchars($carro['marca'] . " " . $carro['modelo'] . " (" . $carro['ano_fabricacao'] . ") - R$ " . number_format($carro['preco'], 2, ',', '.')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text small text-muted">Apenas carros não vendidos aparecem nesta lista.</div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mt-4 mb-3"><i class="fa-solid fa-coins me-1"></i> Fechamento Financeiro</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Data da Venda</label>
                            <input type="date" class="form-control" name="data_venda" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Valor de Negociação (R$)</label>
                            <input type="text" class="form-control" name="valor_final" placeholder="Ex: 450000.00" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Comissão Gerada (R$)</label>
                            <input type="text" class="form-control" name="comissao" placeholder="Ex: 5000.00" value="0.00">
                        </div>
                    </div>

                    <hr class="text-muted my-4">
                    <div class="d-flex justify-content-between">
                        <a href="vendaList.php" class="btn btn-sm btn-outline-secondary px-3"><i class="fa-solid fa-arrow-left me-1"></i> Voltar</a>
                        <button type="submit" class="btn btn-sm btn-success px-4">Concluir Negócio <i class="fa-solid fa-handshake ms-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>