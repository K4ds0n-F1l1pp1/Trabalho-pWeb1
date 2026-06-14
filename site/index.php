<?php

include 'header.php';

?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="p-5 mb-5 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, var(--bg-dark-premium) 0%, var(--bg-card-dark) 100%); border-left: 6px solid var(--accent-porsche);">
    <div class="container-fluid py-2">
        <h1 class="display-6 fw-bold mb-2 tracking-wide text-dark">
            COCKPIT DE GESTÃO CARVOWS
        </h1>
        <p class="fs-6 mb-0 text-dark" style="max-width: 750px; line-height: 1.6;">
            Painel interno integrado para administração de unidades, controle de estoque de veículos premium, monitoramento de comissões e gestão do time de vendas.
        </p>
    </div>
</div>

<div class="row g-4 mb-5">

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 bg-white p-3 card-hover-modern shadow-sm rounded-3 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: rgba(10, 25, 47, 0.06); color: var(--bg-dark-premium);">
                        <i class="fa-solid fa-car fs-4"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">Estoque de Carros</h5>
                    <p class="card-text text-muted small px-2">Acompanhe a frota global, especificações técnicas dos veículos e mídias das unidades.</p>
                </div>
                <div class="mt-3">
                    <a href="admin/veiculo/VeiculoList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Gerenciar Estoque</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 bg-white p-3 card-hover-modern shadow-sm rounded-3 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: rgba(107, 29, 35, 0.06); color: var(--accent-porsche);">
                        <i class="fa-solid fa-handshake fs-4"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">Vendas</h5>
                    <p class="card-text text-muted small px-2">Lance novos relatórios de fechamento, comissões de vendedores e histórico de transações.</p>
                </div>
                <div class="mt-3">
                    <a href="admin/venda/VendaList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Histórico de Vendas</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 bg-white p-3 card-hover-modern shadow-sm rounded-3 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: rgba(145, 142, 133, 0.1); color: var(--slate-gray);">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">Clientes</h5>
                    <p class="card-text text-muted small px-2">Base de dados unificada de compradores, leads interessados e histórico de contato.</p>
                </div>
                <div class="mt-3">
                    <a href="admin/cliente/ClienteList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Ver Clientes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="card h-100 bg-white p-3 card-hover-modern shadow-sm rounded-3 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: rgba(10, 25, 47, 0.06); color: var(--bg-card-dark);">
                        <i class="fa-solid fa-store fs-4"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">Filiais</h5>
                    <p class="card-text text-muted small px-3">Administre as diferentes concessionárias da rede, localizações geográficas e metas por loja.</p>
                </div>
                <div class="mt-3">
                    <a href="admin/loja/LojaList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Configurar Lojas</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="card h-100 bg-white p-3 card-hover-modern shadow-sm rounded-3 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: rgba(43, 61, 47, 0.08); color: #2B3D2F;">
                        <i class="fa-solid fa-user-gear fs-4"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">Usuários</h5>
                    <p class="card-text text-muted small px-3">Controle de credenciais de login, criação de novos vendedores e níveis hierárquicos do sistema.</p>
                </div>
                <div class="mt-3">
                    <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Administrador'): ?>
                        <a href="admin/usuario/usuarioForm.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Registrar Novo Usuário</a>
                    <?php else: ?>
                        <button class="btn btn-sm btn-light w-100 py-2 text-muted fw-bold" disabled style="background-color: #f1f5f9;"><i class="fa-solid fa-lock me-1"></i> Restrito para Administrador</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php

include 'footer.php';

?>