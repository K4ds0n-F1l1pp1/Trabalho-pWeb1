<?php
include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$mensagem = "";
$classe_alerta = "alert-danger";

$id_edicao = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dados_veiculo = null;

if ($id_edicao > 0) {
    $dados_veiculo = $database->buscarVeiculoPorId($id_edicao);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $modelo = trim($_POST['modelo'] ?? '');
    $marca = trim($_POST['marca'] ?? ''); 
    $ano_fabricacao = intval($_POST['ano_fabricacao'] ?? 0);
    $preco = floatval(str_replace(['.', ','], ['', '.'], $_POST['preco'] ?? 0));
    $cor = trim($_POST['cor'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $potencia = trim($_POST['potencia'] ?? '');
    $torque = trim($_POST['torque'] ?? '');
    $velocidade_maxima = trim($_POST['velocidade_maxima'] ?? '');

    if (empty($modelo) || empty($marca) || $ano_fabricacao <= 0 || $preco <= 0) {
        $mensagem = "Preencha os dados fundamentais (Modelo, Marca, Ano e Preço)!";
    } else {
        if ($id > 0) {
            if ($database->atualizarVeiculo($id, $modelo, $marca, $ano_fabricacao, $preco, $cor, $descricao, $potencia, $torque, $velocidade_maxima)) {
                $mensagem = "Dados da unidade atualizados com sucesso!";
                $classe_alerta = "alert-success";
                $dados_veiculo = $database->buscarVeiculoPorId($id);
            }
        } else {

            $db = $database->connect();
            $sql = "INSERT INTO veiculo (modelo, marca, ano_fabricacao, preco, cor, descricao, potencia, torque, velocidade_maxima) 
                    VALUES (:modelo, :marca, :ano_fabricacao, :preco, :cor, :descricao, :potencia, :torque, :velocidade_maxima)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':potencia', $potencia);
            $stmt->bindParam(':torque', $torque);
            $stmt->bindParam(':velocidade_maxima', $velocidade_maxima);
            
            if ($stmt->execute()) {
                $mensagem = "Novo veículo adicionado com sucesso!";
                $classe_alerta = "alert-success";
            }
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header text-white p-3" style="background-color: var(--bg-dark-premium);">
                <h5 class="m-0 small fw-bold">
                    <i class="fa-solid fa-car me-2"></i>
                    <?php echo $id_edicao > 0 ? 'Modificar Veículo #'.$id_edicao : 'Adicionar Novo Veículo'; ?>
                </h5>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($mensagem)): ?>
                    <div class="alert <?php echo $classe_alerta; ?> text-center small p-2" role="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form action="VeiculoForm.php<?php echo $id_edicao > 0 ? '?id='.$id_edicao : ''; ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
                    
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-info me-1"></i> Identificação</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Marca</label>
                            <input type="text" class="form-control" name="marca" placeholder="Ex: Honda" required value="<?php echo htmlspecialchars($dados_veiculo['marca'] ?? ''); ?>">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label small fw-bold text-muted">Modelo</label>
                            <input type="text" class="form-control" name="modelo" placeholder="Ex: Prelude" required value="<?php echo htmlspecialchars($dados_veiculo['modelo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small fw-bold text-muted">Cor</label>
                            <input type="text" class="form-control" name="cor" placeholder="Ex: Preto Vinil" value="<?php echo htmlspecialchars($dados_veiculo['cor'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Ano de Fabricação</label>
                            <input type="number" class="form-control" name="ano_fabricacao" placeholder="Ex: 1995" required value="<?php echo htmlspecialchars($dados_veiculo['ano_fabricacao'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Preço (R$)</label>
                            <input type="text" class="form-control" name="preco" placeholder="Ex: 450000.00" required value="<?php echo htmlspecialchars($dados_veiculo['preco'] ?? ''); ?>">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mt-4 mb-3"><i class="fa-solid fa-gauge-high me-1"></i> Desempenho</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Potência</label>
                            <input type="text" class="form-control" name="potencia" placeholder="Ex: 160 cv" value="<?php echo htmlspecialchars($dados_veiculo['potencia'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Torque</label>
                            <input type="text" class="form-control" name="torque" placeholder="Ex: 212 Nm" value="<?php echo htmlspecialchars($dados_veiculo['torque'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">Vel. Máxima</label>
                            <input type="text" class="form-control" name="velocidade_maxima" placeholder="Ex: 210 km/h" value="<?php echo htmlspecialchars($dados_veiculo['velocidade_maxima'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Descrição / Observações</label>
                        <textarea class="form-control" name="descricao" rows="3" placeholder="Detalhes opcionais..."><?php echo htmlspecialchars($dados_veiculo['descricao'] ?? ''); ?></textarea>
                    </div>

                    <hr class="text-muted my-4">
                    <div class="d-flex justify-content-between">
                        <a href="VeiculoList.php" class="btn btn-sm btn-outline-secondary px-3"><i class="fa-solid fa-arrow-left me-1"></i> Voltar</a>
                        <button type="submit" class="btn btn-sm btn-porsche-dark px-4">Salvar <i class="fa-solid fa-check ms-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include '../../footer.php';

?>