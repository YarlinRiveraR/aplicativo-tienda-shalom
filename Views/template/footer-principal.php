<!-- copyright section start -->
<div class="copyright_section">
  <div class="container">
    <!-- Social Media Icons -->
    <div class="social_media_icons text-center mb-3">
      <p>REDES SOCIALES</p>
      <a href="https://www.instagram.com" target="_blank" class="social_icon"><i class="fab fa-instagram"></i></a>
    </div>

    <!-- Divisoria -->
    <hr class="social_divider">

    <div class="footer_content d-flex align-items-center justify-content-start">
    <!-- Logo -->
      <div class="footer_logo">
        <img src="<?php echo BASE_URL . 'assets/images/logo_sistemas.jpg'; ?>" alt="Logo" width="70">
      </div>
      <p class="copyright_text mb-0 ml-3">Shalompijamas © <?php echo date('Y'); ?> TODOS LOS DERECHOS RESERVADOS<a href="#"></a></p>
    </div>
  </div>
</div>
<!-- copyright section end -->

<!-- CSS for social media icons and logo -->
<style>
  .copyright_section {
    padding: 20px 0;
  }

  .social_icon {
    color: #ddd;
    font-size: 50px;
  }

  .social_icon:hover {
    color: #007bff;
  }

  .social_divider {
    margin: 15px 0; 
    border-top: 1px solid #ddd;
  }

  .footer_content {
    display: flex;
  }

  .footer_logo img {
    width: 200px;
    height: auto;
  }  
</style>



<div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mi carrito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover align-middle" id="tableListaCarrito">
            <thead>
              <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Talla</th>
                <th>Cantidad</th>
                <th>SubTotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-flex justify-content-around mb-3">
        <h3 id="totalGeneral"></h3>
        <?php if (!empty($_SESSION['correoCliente'])) { ?>
          <a class="btn btn-outline-primary" href="<?php echo BASE_URL . 'clientes'; ?>">Procesar Pedido</a>
        <?php } else { ?>
          <a class="btn btn-outline-primary" href="#" onclick="abrirModalLogin();">Login</a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

 <!-- Botón de WhatsApp -->
 <div id="whatsapp-button">
      <a href="https://wa.me/+573004413069?text=¡Chatea Conmigo!" target="_blank">
          <img src="<?php echo BASE_URL . 'assets/images/whatsapp.jpg'; ?>">
      </a>
    </div>
    <style>
    #whatsapp-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
    }

    #whatsapp-button img {
      width: 70px; /* Ajusta el tamaño del icono según sea necesario */
      height: 70px;
      border-radius: 50%; /* Hace el icono circular, si el icono es cuadrado */
    }
  </style>


    

<!-- Login directo -->

<div id="modalLogin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login y Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <div class="text-center">
          <img class="img-thumbnail rounded-circle" src="<?php echo BASE_URL . 'assets/img/logo.png'; ?>" alt="" width="100">
        </div>
        <div class="row">
          <div class="col-md-12" id="frmLogin">
            <div class="form-group mb-3">
              <label for="correoLogin"><i class="fas fa-envelope"></i> Correo</label>
              <input id="correoLogin" class="form-control" type="text" name="correoLogin" placeholder="Correo Electrónico">
            </div>
            <div class="form-group mb-3">
              <label for="claveLogin"><i class="fas fa-key"></i> Contraseña</label>
              <input id="claveLogin" class="form-control" type="text" name="claveLogin" placeholder="Contraseña">
            </div>
            <a href="#" id="btnRegister">Todavia no tienes una cuenta?</a>
            <div class="float-right">
              <button class="btn btn-primary" type="button" id="login">Login</button>
            </div>
          </div>
          <!-- formulario de registro -->
          <div class="col-md-12 d-none" id="frmRegister">
            <div class="form-group mb-3">
              <label for="nombreRegistro"><i class="fas fa-list"></i> Nombre</label>
              <input id="nombreRegistro" class="form-control" type="text" name="nombreRegistro" placeholder="Nombre Completo">
            </div>
            <div class="form-group mb-3">
              <label for="correoRegistro"><i class="fas fa-envelope"></i> Correo</label>
              <input id="correoRegistro" class="form-control" type="text" name="correoRegistro" placeholder="Correo Electrónico">
            </div>
            <div class="form-group mb-3">
              <label for="claveRegistro"><i class="fas fa-key"></i> Contraseña</label>
              <input id="claveRegistro" class="form-control" type="text" name="claveRegistro" placeholder="Contraseña">
            </div>
            <a href="#" id="btnLogin">Ya tienes una cuenta?</a>
            <div class="float-right">
              <button class="btn btn-primary" type="button" id="registrarse">Registrarse</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Javascript files-->
<script src="<?php echo BASE_URL; ?>assets/principal/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/js/plugin.js"></script>
<!-- sidebar -->
<script src="<?php echo BASE_URL; ?>assets/principal/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/slick/slick.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/templatemo.js"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/js/custom.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/all.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
  const base_url = '<?php echo BASE_URL; ?>';

  function alertaPerzanalizada(mensaje, type, titulo = '') {
    toastr[type](mensaje, titulo)

    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  }

  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }
</script>
<script src="<?php echo BASE_URL; ?>assets/js/carrito.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/login.js"></script>




