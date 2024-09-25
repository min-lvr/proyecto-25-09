document.addEventListener('DOMContentLoaded', () => {
    const carritoContainer = document.getElementById('carrito-container');
    const totalElement = document.getElementById('total');

    function actualizarTotal() {
        let total = 0;
        const productos = JSON.parse(sessionStorage.getItem('carrito') || '[]');
        productos.forEach(item => {
            total += item.precio;
        });
        totalElement.textContent = total.toFixed(2);
    }

    function mostrarCarrito() {
        const carrito = JSON.parse(sessionStorage.getItem('carrito') || '[]');
        carritoContainer.innerHTML = '';
    
        if (carrito.length === 0) {
            carritoContainer.innerHTML = '<p>Tu carrito está vacío.</p>';
            return;
        }
    
        carrito.forEach((item, index) => {
            const div = document.createElement('div');
            div.className = 'item-carrito';
            div.innerHTML = `
                <img src="${item.imagen}" alt="${item.modelo}"> <!-- Usa la imagen del producto aquí -->
                <div class="info">
                    <h3>${item.modelo}</h3>
                    <p>Talla: ${item.size}</p>
                    <p class="precio">$ ${item.precio.toLocaleString()}</p>
                    <button onclick="eliminarProducto(${index})">Eliminar</button>
                </div>
            `;
            carritoContainer.appendChild(div);
        });
    
        actualizarTotal();
    }
    
    

    mostrarCarrito();
    window.mostrarCarrito = mostrarCarrito;

    document.querySelector('.finalizar').addEventListener('click', finalizarCompra);
});

function eliminarProducto(index) {
    const carrito = JSON.parse(sessionStorage.getItem('carrito') || '[]');
    carrito.splice(index, 1);
    sessionStorage.setItem('carrito', JSON.stringify(carrito));
    mostrarCarrito();
}

function finalizarCompra() {
    const carrito = JSON.parse(sessionStorage.getItem('carrito') || '[]');
    if (carrito.length === 0) {
        alert('Tu carrito está vacío.');
        return;
    }

    // Aquí puedes obtener el usuario_id de alguna manera, por ejemplo, de una variable de sesión o cookie
    const usuario_id = 1; // Cambia esto con el ID del usuario real

    fetch('guardar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            usuario_id: usuario_id,
            productos: carrito
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Compra finalizada. ¡Gracias por tu compra!');
            sessionStorage.removeItem('carrito');
            mostrarCarrito();
        } else {
            alert('Error al guardar el carrito: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el carrito. Por favor, inténtalo de nuevo.');
    });
}
