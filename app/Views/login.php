<?php 
    $user_session = session();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
    
       <link rel="icon" href="<?php echo base_url();?>/images/icono.png" sizes="32x32"/>
        <title>Login restaurante</title>
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
        <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
        <style>
            body {
                background-image: url("<?php echo base_url(); ?>/images/fondo.jpg");
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main> <br> <br>
                    <div class="container px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar sesión</h3></div>
                                    <div class="card-body">
                                        <form method='POST' action ="<?php echo base_url(); ?>/usuarios/valida">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Usuario" />
                                                <label for="usuario">Usuario</label>
                                            </div>
                                            <div class="form-floating">     
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Password" />
                                                <label for="password">Contraseña</label>
                                            </div>
                                            <div class="d-grid gap-2 mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit" >Ingresar</button>
                                            </div>
                                            <div class="d-grid gap-2 mt-4 mb-0"> 
                                                <?php if(isset($validation)){?>
                                                  <div class="alert alert-danger">
                                                       <?php echo $validation->listErrors(); ?>
                                                  </div>
                                                <?php } ?>

                                                <?php if(isset($error)){?>
                                                    <div class="alert alert-danger">
                                                        <?php echo $error; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <b>&nbsp;Restaurante</b>
            <div id="layoutAuthentication_footer">
                <footer class="py-2 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Sistema de Información II <?php echo date('Y'); ?></div>
                            <div>
                                <a href="https://www.facebook.com/EnriquePlayer" target="_blank">facebook</a>
                                &middot;
                                <a href="http://www.clientefeliz.xyz" target="_blank">WebSite</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/scripts.js"></script>
    </body>

</html>
