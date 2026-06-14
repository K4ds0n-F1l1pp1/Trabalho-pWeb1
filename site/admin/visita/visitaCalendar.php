<?php

include '../../header.php';
require_once '../../db.class.php';

$database = new DB();
$db = $database->connect();

$sql = "SELECT v.id, CONCAT(v.data_visita, ' ', v.horario_visita) AS momento, 
               c.nome_completo AS nome_cliente, car.modelo AS carro, v.status
        FROM visita v
        INNER JOIN cliente c ON v.cliente_id = c.id
        INNER JOIN veiculo car ON v.veiculo_id = car.id";
$stmt = $db->query($sql);
$visitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$eventos = [];
foreach ($visitas as $vis) {
    $cor = ($vis['status'] === 'Concluída') ? '#198754' : '#ffc107'; 
    $textoCor = ($vis['status'] === 'Concluída') ? '#ffffff' : '#212529';

    $eventos[] = [
        'id'    => $vis['id'],
        'title' => $vis['nome_cliente'] . " - " . $vis['carro'],
        'start' => $vis['momento'], 
        'url'   => 'VisitaEdit.php?id=' . $vis['id'],
        'color' => $cor,
        'textColor' => $textoCor
    ];
}
?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="m-0 fw-bold text-dark"><i class="fa-solid fa-calendar-days me-2 text-warning"></i> Controle de Visitas</h4>
            <p class="text-muted small m-0">Clique em qualquer compromisso para editar ou cancelar</p>
        </div>
        <a href="VisitaForm.php" class="btn btn-sm btn-dark px-3"><i class="fa-solid fa-plus me-1"></i> Agendar Visita</a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 bg-white p-4">
        <div id="calendar"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: { today: 'Hoje', month: 'Mês', week: 'Semana' },
            events: <?php echo json_encode($eventos); ?>
        });
        calendar.render();
    });
</script>

<style>
    .fc .fc-button-primary { background-color: #212529; border-color: #212529; }
    .fc .fc-button-primary:hover { background-color: #424649; border-color: #424649; }
    .fc-event { cursor: pointer; padding: 4px; font-size: 0.85em; border-radius: 4px; border: none; }
</style>

<?php

include '../../footer.php';

?>