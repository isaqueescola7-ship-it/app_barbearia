document.addEventListener("DOMContentLoaded", function() {
    const btnStartBooking = document.getElementById("btn-start-booking");
    const stepService = document.getElementById("step-service");
    const stepBarber = document.getElementById("step-barber");
    const stepSchedule = document.getElementById("step-schedule");
    
    const inputServico = document.getElementById("input-servico");
    const inputBarbeiro = document.getElementById("input-barbeiro");
    const inputHorario = document.getElementById("input-horario");

    const closeButtons = document.querySelectorAll(".close-btn");
    const backButton = document.querySelector(".back-btn");

    // 1. Clicar em "Agendar Agora" -> Vai para serviços
    if(btnStartBooking) {
        btnStartBooking.addEventListener("click", function(e) {
            e.preventDefault();
            stepService.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // 2. Selecionar Serviço -> Guarda o ID e abre Barbeiros
    const serviceCards = document.querySelectorAll(".select-service");
    serviceCards.forEach(card => {
        card.addEventListener("click", function() {
            serviceCards.forEach(c => c.style.border = "none");
            this.style.border = "2px solid #2563eb";
            
            inputServico.value = this.getAttribute("data-id");
            
            stepBarber.classList.remove("hidden");
            stepBarber.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // 3. Selecionar Barbeiro -> Guarda o ID e abre Horários
    const barberCards = document.querySelectorAll(".select-barbeiro");
    barberCards.forEach(card => {
        card.addEventListener("click", function() {
            inputBarbeiro.value = this.getAttribute("data-id");
            stepBarber.classList.add("hidden");
            stepSchedule.classList.remove("hidden");
            stepSchedule.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // 4. Selecionar Horário -> Guarda o valor do horário
    const timeSlots = document.querySelectorAll(".time-slot");
    timeSlots.forEach(slot => {
        slot.addEventListener("click", function() {
            timeSlots.forEach(s => s.classList.remove("active"));
            this.classList.add("active");
            
            inputHorario.value = this.getAttribute("data-time");
        });
    });

    // Controlos de Voltar/Fechar
    if(backButton) {
        backButton.addEventListener("click", function(e) {
            e.preventDefault();
            stepSchedule.classList.add("hidden");
            stepBarber.classList.remove("hidden");
        });
    }

    closeButtons.forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            stepBarber.classList.add("hidden");
            stepSchedule.classList.add("hidden");
        });
    });
});