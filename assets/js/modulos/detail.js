const btnAddCart =  document.querySelector('#btnAddCart');
const cantidad =  document.querySelector('#product-quanity');
const idProducto =  document.querySelector('#idProducto');
const talla =  document.querySelector('#idTalla');
document.addEventListener("DOMContentLoaded", function () {
    btnAddCart.addEventListener('click', function () {
        agregarCarrito(idProducto.value, cantidad.value, talla.value);
    })
});