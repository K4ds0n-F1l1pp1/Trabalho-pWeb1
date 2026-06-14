<?php

include 'header.php';

?>

<link rel="stylesheet" href="assets/css/style.css">

<!-- Seção do Topo: Cockpit com Agenda de Visitas Integrada no Lado Direito -->
<div class="p-5 mb-5 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, var(--bg-dark-premium) 0%, var(--bg-card-dark) 100%); border-left: 6px solid var(--accent-porsche);">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            
            <!-- Coluna da Esquerda: Informações de Gestão -->
            <div class="col-xl-8 col-md-7 text-start">
                <h1 class="display-6 fw-bold mb-2 tracking-wide text-dark">
                    COCKPIT DE GESTÃO CARVOWS
                </h1>
                <p class="fs-6 mb-0 text-dark" style="max-width: 750px; line-height: 1.6;">
                    Painel interno integrado para administração de unidades, controle de estoque de veículos premium, monitoramento de comissões e gestão do time de vendas.
                </p>
            </div>
            
            <!-- Coluna da Direita: Card Compacto de Acesso Rápido à Agenda -->
            <div class="col-xl-4 col-md-5 mt-4 mt-md-0">
                <div class="card border-0 rounded-3 p-3 text-center shadow-sm" style="background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(5px);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center text-start">
                            <!-- Ícone Amarelo com Opacidade Elegante -->
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background-color: rgba(255, 193, 7, 0.15); color: #b28900;">
                                <i class="fa-solid fa-calendar-days fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark m-0" style="font-size: 0.95rem;">Agenda de Visitas</h6>
                                <p class="text-muted small m-0" style="font-size: 0.75rem;">Horários de clientes no pátio</p>
                            </div>
                        </div>
                        <!-- Botão Dinâmico que segue a identidade visual -->
                        <a href="admin/visita/VisitaCalendar.php" class="btn btn-sm btn-porsche-dark px-3 fw-bold small" style="font-size: 0.8rem;">
                            Abrir <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
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
                    <a href="admin/loja/filialList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Configurar Lojas</a>
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
                        <a href="admin/usuario/usuarioList.php" class="btn btn-sm btn-porsche-dark w-100 py-2 fw-bold">Gerenciar Usuários</a>
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