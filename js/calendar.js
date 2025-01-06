document.addEventListener('DOMContentLoaded', function() {
    // Initialize the Bootstrap modal
    const serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'));
    
    // Add click handlers to calendar days
    document.querySelectorAll('.calendar-day:not(.unavailable):not(.full):not(.empty)').forEach(day => {
        day.addEventListener('click', function() {
            const date = this.dataset.date;
            document.getElementById('selected_date').value = date;
            serviceModal.show();
        });
    });
});

// Function to navigate to the previous month
function previousMonth() {
    const currentMonth = new Date(document.getElementById('current-month').textContent);
    currentMonth.setMonth(currentMonth.getMonth() - 1);
    updateCalendar(currentMonth);
}

// Function to navigate to the next month
function nextMonth() {
    const currentMonth = new Date(document.getElementById('current-month').textContent);
    currentMonth.setMonth(currentMonth.getMonth() + 1);
    updateCalendar(currentMonth);
}

// Function to update the calendar display
function updateCalendar(date) {
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    
    fetch(`ajax/get_calendar.php?month=${month}&year=${year}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('appointment-calendar').innerHTML = html;
            document.getElementById('current-month').textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
        })
        .catch(error => console.error('Error updating calendar:', error));
}

// Function to submit the appointment
function submitAppointment() {
    const form = document.getElementById('serviceForm');
    const formData = new FormData(form);
    
    fetch('ajax/book_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Appointment booked successfully!');
            location.reload();
        } else {
            alert(data.message || 'Error booking appointment');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error booking appointment');
    })
    .finally(() => {
        bootstrap.Modal.getInstance(document.getElementById('serviceModal')).hide();
    });
}