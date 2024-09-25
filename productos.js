/// Variables para la selección del producto
let mostrador = document.getElementById("mostrador");
let seleccion = document.getElementById("seleccion");
let imgSeleccionada = document.getElementById("img");
let modeloSeleccionado = document.getElementById("modelo");
let descripSeleccionada = document.getElementById("descripcion");
let precioSeleccionado = document.getElementById("precio");

function cargar(item) {
    quitarBordes();
    mostrador.style.width = "60%";
    seleccion.style.width = "40%";
    seleccion.style.opacity = "1";
    item.style.border = "2px solid red";

    imgSeleccionada.src = item.getElementsByTagName("img")[0].src;
    modeloSeleccionado.innerHTML = item.getElementsByTagName("p")[0].innerHTML;
    descripSeleccionada.innerHTML = "Descripción del modelo ";
    precioSeleccionado.innerHTML = item.getElementsByTagName("span")[0].innerHTML;
}

function cerrar() {
    mostrador.style.width = "100%";
    seleccion.style.width = "0%";
    seleccion.style.opacity = "0";
    quitarBordes();
}

function quitarBordes() {
    var items = document.getElementsByClassName("item");
    for (let i = 0; i < items.length; i++) {
        items[i].style.border = "none";
    }
}

function agregarAlCarrito() {
    const modelo = modeloSeleccionado.textContent;
    const precio = parseFloat(precioSeleccionado.textContent.replace(/[$,.]/g, ''));
    const size = document.querySelector('.size select').value;
    const imagen = imgSeleccionada.src; // Agrega esta línea

    if (size === '') {
        alert('Por favor, selecciona una talla.');
        return;
    }

    let carrito = sessionStorage.getItem('carrito');
    if (carrito) {
        carrito = JSON.parse(carrito);
    } else {
        carrito = [];
    }

    carrito.push({ modelo, precio, size, imagen }); // Incluye la imagen aquí
    sessionStorage.setItem('carrito', JSON.stringify(carrito));

    alert('Producto agregado al carrito');
    cerrar();
}



document.querySelector('.info button').addEventListener('click', agregarAlCarrito);

