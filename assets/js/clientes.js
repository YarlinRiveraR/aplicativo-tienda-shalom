const tableLista = document.querySelector("#tableListaProductos tbody");
const tableListaPago = document.querySelector("#tableListaProductosPago tbody");
const btnFinalizarPago = document.querySelector("#btnFinalizarPago");
//const accordionMetodosPago = document.querySelector("#accordionMetodosPago");
const tblPendientes = document.querySelector('#tblPendientes');
let productosjson = [];
const estadoEnviado = document.querySelector('#estadoEnviado');
const estadoProceso = document.querySelector('#estadoProceso');
const estadoCompletado = document.querySelector('#estadoCompletado');
document.addEventListener("DOMContentLoaded", function() {
    if (tableLista) {
        getListaProductos();
    }
    // if (tableListaPago) {
    //     getListaProductosPago();
    // }

    btnFinalizarPago.addEventListener('click', function() {
        let mensaje = generarMensajeCarrito();
        let telefono = "+573004413069"; // Reemplaza esto con el número de teléfono destino
        let url = `https://api.whatsapp.com/send?phone=${telefono}&text=${mensaje}`;
        window.open(url, '_blank');
    })

    //cargar datos pendientes con DataTables
    $('#tblPendientes').DataTable({
        ajax: {
            url: base_url + 'clientes/listarPendientes',
            dataSrc: ''
        },
        columns: [
            { data: 'id_transaccion' },
            { data: 'monto' },
            { data: 'fecha' },
            { data: 'accion' }
        ],
        language,
        dom,
        buttons

    });
});

// function getListaMetodosPago() {
//     let html = '';
//     const url = base_url + 'clientes/verMetodoPago';
//     const http = new XMLHttpRequest();
//     http.open('GET', url, true);
//     http.send();
//     http.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             const res = JSON.parse(this.responseText);
//             if (res.total > 0) {
//                 // Reemplazar el forEach con un bucle for
//                 for (let i = 0; i < res.metodosPago.length; i++) {
//                     const metodoPago = res.metodosPago[i];
//                     html += `<div class="card">
//                         <div class="card-header" id="headingOne">
//                             <h2 class="mb-0">
//                                 <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
//                                     ${metodoPago.nombre}
//                                 </button>
//                             </h2>
//                         </div>

//                         <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
//                             <div class="card-body">
//                                 <div>
//                                     <img class="img-thumbnail rounded-circle" src="${metodoPago.imagen}" alt="" width="100">
//                                 </div>
//                                 <h6>Número de Cuenta:</h6>
//                                 <p>${metodoPago.numero_cuenta}</p>
//                             </div>
//                         </div>
//                     </div>`;
//                     // Agregar producto para PayPal
//                     // let json = {
//                     //     "name": producto.nombre,
//                     //     /* Shows within upper-right dropdown during payment approval */
//                     //     "unit_amount": {
//                     //         "currency_code": res.moneda,
//                     //         "value": producto.precio
//                     //     },
//                     //     "quantity": producto.cantidad
//                     // }
//                     //productosjson.push(json);
//                 }
//                 // console.log(res.totalPaypal);
//                 accordionMetodosPago.innerHTML = html;
//                 document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' ' + res.total;
//                 // botonPaypal(res.totalPaypal, res.moneda);
//             } else {
//                 accordionMetodosPago.innerHTML = `
//                 <tr>
//                     <td colspan="5" class="text-center">NO HAY MÉTODOS DE PAGO</td>
//                 </tr>
//                 `;
//             }
//         }
//     }
// }

function getListaProductos() {
    const miTalla = JSON.parse(localStorage.getItem('listaCarrito'));
    let html = '';
    const url = base_url + 'principal/listaProductos';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.send(JSON.stringify(listaCarrito));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.total > 0) {
                // Reemplazar el forEach con un bucle for
                for (let i = 0; i < res.productos.length; i++) {
                    const producto = res.productos[i];
                    html += `<tr>
                        <td>
                            <img class="img-thumbnail rounded-circle" src="${producto.imagen}" alt="" width="100">
                        </td>
                        <td>${producto.nombre}</td>
                        <td><span class="badge bg-warning">${res.moneda + ' ' + producto.precio}</span></td>
                        <td>${miTalla[i].talla}</td>
                        <td><span class="badge bg-primary"><h3>${producto.cantidad}</h3></span></td>
                        <td>${producto.subTotal}</td>
                    </tr>`;
                    // Agregar producto para PayPal
                    // let json = {
                    //     "name": producto.nombre,
                    //     /* Shows within upper-right dropdown during payment approval */
                    //     "unit_amount": {
                    //         "currency_code": res.moneda,
                    //         "value": producto.precio
                    //     },
                    //     "quantity": producto.cantidad
                    // }
                    //productosjson.push(json);
                }
                // console.log(res.totalPaypal);
                tableLista.innerHTML = html;
                document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' ' + res.total;
                // botonPaypal(res.totalPaypal, res.moneda);
            } else {
                tableLista.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">CARRITO VACIO</td>
                </tr>
                `;
            }
        }
    }
}

function generarMensajeCarrito() {
    let listaCarrito = JSON.parse(localStorage.getItem("listaCarrito"));
    if (!listaCarrito || listaCarrito.length === 0) {
        return "El carrito está vacío.";
    }

    let mensaje = "Hola! 👋\n\nAquí está tu carrito de compras:\n\n";


    for (let i = 0; i < listaCarrito.length; i++) {
        let producto = listaCarrito[i];
        mensaje += `${i + 1}. ${producto.nombre}\n`;
        mensaje += `Cantidad: ${producto.cantidad}\n`;
        mensaje += `Talla: ${producto.talla}\n`;
        mensaje += `Precio: ${producto.subTotal} c/u\n\n`;
    }

    mensaje += "¿Cuál es el siguiente paso? Por favor, indícanos la dirección de entrega y el método de pago que prefieres. ¡Gracias! 😊";
    console.log(mensaje);
    return encodeURIComponent(mensaje);

    // const miTalla = JSON.parse(localStorage.getItem('listaCarrito'));
    // let html = '';
    // const url = base_url + 'principal/listaProductos';
    // const http = new XMLHttpRequest();
    // http.open('POST', url, true);
    // http.send(JSON.stringify(listaCarrito));
    // http.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         const res = JSON.parse(this.responseText);
    //         if (res.total > 0) {
    //             // Reemplazar el forEach con un bucle for
    //             for (let i = 0; i < res.productos.length; i++) {
    //                 const producto = res.productos[i];
    //                 html += `<tr>
    //                     <td>${producto.nombre}</td>
    //                     <td>${res.moneda + ' ' + producto.precio}</td>
    //                     <td>${miTalla[i].talla}</td>
    //                     <td><h3>${producto.cantidad}</h3></td>
    //                     <td>${producto.subTotal}</td>
    //                 </tr>`;
    //             }
    //             tableListaPago.innerHTML = html;
    //             document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' ' + res.total;
    //         } else {
    //             tableListaPago.innerHTML = `
    //             <tr>
    //                 <td colspan="5" class="text-center">ERROR</td>
    //             </tr>
    //             `;
    //         }
    //     }
    // }
}
//link boton
// https://developer.paypal.com/docs/checkout/

//https://developer.paypal.com/api/rest/reference/currency-codes/

// function botonPaypal(total, moneda) {
//     paypal.Buttons({
//         // Sets up the transaction when a payment button is clicked
//         createOrder: (data, actions) => {
//             return actions.order.create({
//                 "purchase_units": [{
//                     "amount": {
//                         "currency_code": moneda,
//                         "value": total,
//                         "breakdown": {
//                             "item_total": { /* Required when including the `items` array */
//                                 "currency_code": moneda,
//                                 "value": total
//                             }
//                         }
//                     },
//                     "items": productosjson
//                 }]
//             });
//         },
//         // Finalize the transaction after payer approval
//         onApprove: (data, actions) => {
//             return actions.order.capture().then(function(orderData) {
//                 registrarPedido(orderData)
//             });
//         }
//     }).render('#paypal-button-container');
// }

function registrarPedido(datos) {
    const url = base_url + 'clientes/registrarPedido';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.send(JSON.stringify({
        pedidos: datos,
        productos: listaCarrito
    }));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            Swal.fire("Aviso?", res.msg, res.icono);
            if (res.icono == 'success') {
                localStorage.removeItem('listaCarrito');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        }
    }
}

function verPedido(idPedido) {
    estadoEnviado.classList.remove('bg-info');
    estadoProceso.classList.remove('bg-info');
    estadoCompletado.classList.remove('bg-info');
    const mPedido = new bootstrap.Modal(document.getElementById('modalPedido'));
    const url = base_url + 'clientes/verPedido/' + idPedido;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            if (res.pedido.proceso == 1) {
                estadoEnviado.classList.add('bg-info');
            } else if (res.pedido.proceso == 2) {
                estadoProceso.classList.add('bg-info');
            } else {
                estadoCompletado.classList.add('bg-info');
            }
            res.productos.forEach(row => {
                let subTotal = parseFloat(row.precio) * parseInt(row.cantidad);
                html += `<tr>
                    <td>${row.producto}</td>
                    <td><span class="badge bg-warning">${res.moneda + ' ' + row.precio}</span></td>
                    <td><span class="badge bg-primary">${row.cantidad}</span></td>
                    <td>${subTotal.toFixed(2)}</td>
                </tr>`;
            });
            document.querySelector('#tablePedidos tbody').innerHTML = html;
            mPedido.show();
        }
    }

}

// sb-j6jdb7896999@personal.example.com
// e8O2lR-I


//sb-y3jfn7901325@business.example.com
//Amqes3]/