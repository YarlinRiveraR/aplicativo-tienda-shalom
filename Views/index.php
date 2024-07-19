<?php include_once 'Views/template/header-principal.php'; ?>


</div>
<!-- banner bg main end -->

<!-- fashion section start -->
<?php foreach ($data['categorias'] as $categoria) { ?>
  <div class="fashion_section">
    <div class="container" id="categoria_<?php echo $categoria['id']; ?>">
      <h1 class="fashion_taital text-uppercase"><?php echo $categoria['categoria']; ?></h1>
      <p><?php echo $categoria['descripcion']; ?></p>
      <div class="row <?php echo (count($categoria['productos']) > 0) ? 'multiple-items' : ''; ?>">
        <?php foreach ($categoria['productos'] as $producto) { ?>  
          <div class="<?php echo (count($categoria['productos']) > 2) ? 'col-lg-4' : 'col-lg-12'; ?>">
          <div class="card-prod mb-4 product-wap rounded-0">
          <div class="box_main card">
              <div class="text-center">
                <img data-lazy="<?php echo BASE_URL . $producto['imagen']; ?>" />
              </div>
              <!-- <div class="btn_main"> -->
                  <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                    <ul class="list-unstyled">
                      <li><a class="btn btn-success text-white mt-2" href="<?php echo BASE_URL . 'principal/detail/' . $producto['id']; ?>"><i class="fas fa-eye"></i></a></li>
                    </ul>
                  </div>
              <!-- </div> -->
            </div>
            <div class="box_main card-body">
              <h4 class="shirt_text"><?php echo $producto['nombre']; ?></h4>
              <p class="text-center mb-0"><span style="color: #262626;">$ <?php echo $producto['precio'] . ' ' . MONEDA; ?></span></p>
            </div>
          </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>

<style>
  /* Ocultar los iconos inicialmente */
  .product-overlay {
    display: none;
  }

  /* Mostrar los iconos cuando se hace hover sobre la tarjeta del producto */
  .card-prod:hover .product-overlay {
    display: flex;
  }

  /* Asegurarse de que los iconos estén centrados */
  .product-overlay {
    position: absolute;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .card-prod {
    height: 350px; /* Ajustar según sea necesario */
  }

  /* Asegurarse de que las imágenes no excedan el tamaño de la tarjeta y estén centradas */
  .card-prod img {
    max-height: 200px; /* Ajustar según sea necesario */
    object-fit: contain;
    width: 100%;
  }

  /* Establecer un tamaño fijo para el cuerpo de la tarjeta */
  .card-prod .card-body {
    height: 100px; /* Ajustar según sea necesario */
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
</style>


<?php include_once 'Views/template/footer-principal.php'; ?>

<script>
  $('.multiple-items').slick({
    lazyLoad: 'ondemand',
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
</script>

</body>

</html>