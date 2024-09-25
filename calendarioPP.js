document.addEventListener("DOMContentLoaded", function() {
    const calendar = document.getElementById('calendar');
    const monthYear = document.getElementById('month-year');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const appointmentForm = document.getElementById('appointment-form');
    const fechaInput = document.getElementById('fecha');
    const horaInput = document.getElementById('hora');
    const horarioSelect = document.getElementById('horario');
    const cancelarBtn = document.getElementById('cancelar');
    const formCita = document.getElementById('form-cita');

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let unavailableTimes = {}; // Para almacenar las horas ya seleccionadas

    function loadCalendar(month, year) {
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        let table = '<table>';
        table += '<tr><th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th></tr><tr>';

        // Rellenar días en blanco hasta el primer día del mes
        for (let i = 0; i < firstDay; i++) {
            table += '<td></td>';
        }

        // Rellenar los días del mes
        for (let day = 1; day <= lastDate; day++) {
            if ((day + firstDay - 1) % 7 === 0) {
                table += '</tr><tr>';
            }
            let dateKey = `${year}-${month + 1}-${day}`;
            let isUnavailable = unavailableTimes[dateKey] ? 'unavailable' : '';
            table += `<td data-day="${day}" data-month="${month + 1}" data-year="${year}" data-date="${dateKey}" class="${isUnavailable}">${day}</td>`;
        }

        table += '</tr></table>';
        calendar.innerHTML = table;

        // Mostrar el mes y el año actual
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        monthYear.textContent = `${monthNames[month]} ${year}`;

        // Evento para manejar clics en los días del calendario
        document.querySelectorAll('#calendar td').forEach(td => {
            td.addEventListener('click', function() {
                if (this.textContent !== '' && !this.classList.contains('unavailable')) {
                    handleDayClick(this.dataset.day, this.dataset.month, this.dataset.year, this);
                }
            });
        });
    }

    function handleDayClick(day, month, year, element) {
        // Quitar la clase 'selected' de cualquier día previamente seleccionado
        document.querySelectorAll('#calendar td.selected').forEach(td => {
            td.classList.remove('selected');
        });
    
        // Añadir la clase 'selected' al día actual
        element.classList.add('selected');
    
        // Mostrar el formulario
        appointmentForm.style.display = 'block';
        fechaInput.value = `${year}-${month}-${day}`;
    
        // Vaciar y configurar el horario
        horarioSelect.innerHTML = '<option value="">Seleccione una hora</option>';
        ['11:00', '13:00', '14:00', '15:00', '16:00', '17:00'].forEach(hora => {
            if (!unavailableTimes[`${fechaInput.value}-${hora}`]) {
                horarioSelect.innerHTML += `<option value="${hora}">${hora}</option>`;
            }
        });
    }
    

    horarioSelect.addEventListener('change', function() {
        horaInput.value = this.value;
    });

    cancelarBtn.addEventListener('click', function() {
        appointmentForm.style.display = 'none';
    });

    formCita.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(formCita);

        fetch('procesar_cita.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            // Marcar la hora como no disponible
            unavailableTimes[`${fechaInput.value}-${horaInput.value}`] = true;
            // Ocultar el formulario
            appointmentForm.style.display = 'none';
            // Recargar el calendario
            loadCalendar(currentMonth, currentYear);
        })
        .catch(error => console.error('Error:', error));
    });

    prevMonthBtn.addEventListener('click', function() {
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        currentYear = currentMonth === 11 ? currentYear - 1 : currentYear;
        loadCalendar(currentMonth, currentYear);
    });

    nextMonthBtn.addEventListener('click', function() {
        currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
        currentYear = currentMonth === 0 ? currentYear + 1 : currentYear;
        loadCalendar(currentMonth, currentYear);
    });

    loadCalendar(currentMonth, currentYear);
});

