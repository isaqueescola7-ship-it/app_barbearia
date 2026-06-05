<?php
// Iniciar a sessão para saber se o cliente está logado
session_start();
include('conexao.php');

// Se o cliente não estiver logado, manda para a página de login
if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

// Mensagens de sucesso ou erro no agendamento
$mensagem = "";
if (isset($_GET['sucesso'])) {
    $mensagem = "<div style='background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin: 20px auto; max-width: 1200px; text-align: center; font-weight: 600;'>🎉 Agendamento realizado com sucesso! Verifique no seu phpMyAdmin.</div>";
}
if (isset($_GET['erro'])) {
    $mensagem = "<div style='background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 8px; margin: 20px auto; max-width: 1200px; text-align: center; font-weight: 600;'>❌ Erro ao realizar agendamento. Tente novamente.</div>";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isaque Cortes - Barbearia</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <?php echo $mensagem; ?>

    <div style="width: 100%; max-width: 1200px; text-align: right; padding: 10px 40px;">
        <span style="color: #64748b;">Olá, <strong><?php echo htmlspecialchars($_SESSION['nome_cliente']); ?></strong>!</span>
        <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-weight: 600;">Sair</a>
    </div>

    <form id="booking-form" action="gravar_agendamento.php" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        
        <input type="hidden" name="id_servico" id="input-servico" required>
        <input type="hidden" name="id_barbeiro" id="input-barbeiro" required>
        <input type="hidden" name="data_agendamento" id="input-data" value="<?php echo date('Y-m-d'); ?>" required>
        <input type="hidden" name="horario" id="input-horario" required>

        <section class="hero-container">
            <div class="hero-content">
                <h3 class="brand-name">ISAQUE CORTES</h3>
                <h1 class="hero-title">Estilo e <span class="highlight">Elegância</span> em Cada Corte</h1>
                <p class="hero-description">Transforme o seu visual com a experiência de profissionais especializados em cortes modernos e clássicos.</p>
                <div class="hero-buttons">
                    <a href="#" id="btn-start-booking" class="btn-primary">📅 Agendar Agora</a>
                </div>
            </div>
            <div class="hero-image-container">
                <img src="barbearia.jpg" alt="Interior da Barbearia" class="main-img">
            </div>
        </section>

        <section id="step-service" class="services-container">
            <div class="services-header">
                <h2>Nossos Serviços</h2>
                <p>Selecione um serviço para começar o agendamento</p>
            </div>
            <div class="services-grid">
                <?php
                $res_servicos = $mysqli->query("SELECT * FROM servico");
                while($servico = $res_servicos->fetch_assoc()) {
                    ?>
                    <div class="service-card select-service" data-id="<?php echo $servico['id_servico']; ?>" style="cursor: pointer;">
                        <div class="service-icon"><span>✂️</span></div>
                        <h3><?php echo htmlspecialchars($servico['nome_servico']); ?></h3>
                        <p class="service-desc">Duração: <?php echo $servico['duracao_minutes']; ?> min.</p>
                        <div class="service-meta"><span class="service-price">€<?php echo number_format($servico['preco'], 2, ',', '.'); ?></span></div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>

        <section id="step-barber" class="barber-selection-container hidden">
            <div class="barber-header">
                <span class="brand-subtext">ISAQUE CORTES</span>
                <h2>Escolha o Barbeiro</h2>
                <p>Selecione o profissional preferido</p>
                <button type="button" class="close-btn">&times;</button>
            </div>
            <div class="barbers-list">
                <?php
                $res_barbeiros = $mysqli->query("SELECT * FROM barbeiro");
                while($barbeiro = $res_barbeiros->fetch_assoc()) {
                    ?>
                    <div class="barber-card select-barbeiro" data-id="<?php echo $barbeiro['id_barbeiro']; ?>">
                        <div class="barber-avatar"><span>🧔</span></div>
                        <div class="barber-info">
                            <h3><?php echo htmlspecialchars($barbeiro['nome_barbeiro']); ?></h3>
                            <p>Profissional Oficial</p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>

        <section id="step-schedule" class="schedule-container hidden">
            <div class="selection-header">
                <button type="button" class="back-btn" style="border:none; background:none; cursor:pointer;">‹ Voltar</button>
                <span class="brand-subtext">ISAQUE CORTES</span>
                <h2>Agendar Horário</h2>
                <p>Escolha o momento ideal</p>
                <button type="button" class="close-btn">&times;</button>
            </div>
            <div class="schedule-content">
                <div class="calendar-section">
                    <span class="input-label">📅 Dia do Agendamento</span>
                    <div class="days-carousel">
                        <div class="day-card active">
                            <span><?php echo date('D'); ?></span>
                            <span class="day-number"><?php echo date('d'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="time-section">
                    <span class="input-label">🕒 Selecione o horário</span>
                    <div class="times-grid">
                        <div class="time-slot" data-time="09:00:00">09:00</div>
                        <div class="time-slot" data-time="09:30:00">09:30</div>
                        <div class="time-slot" data-time="10:00:00">10:00</div>
                        <div class="time-slot" data-time="11:00:00">11:00</div>
                        <div class="time-slot" data-time="14:30:00">14:30</div>
                        <div class="time-slot" data-time="15:00:00">15:00</div>
                        <div class="time-slot" data-time="16:30:00">16:30</div>
                    </div>
                </div>
                <button type="submit" class="btn-confirm">Confirmar Agendamento Final</button>
            </div>
        </section>
    </form>

    <script src="script.js"></script>
</body>
</html>