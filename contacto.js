document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('send_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert('Mensaje enviado con éxito.');
    })
    .catch(error => {
        console.error('Error:', error);
    });
});