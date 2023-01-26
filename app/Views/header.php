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
        <link rel="icon" href="<?php echo base_url(); ?>/images/icono.png" sizes="32x32" />
        <title>Restaurante</title>

        <link href="<?php echo base_url(); ?>/css/style.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.min.js"></script>
        <link href="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.js"></script> 
        <link href="<?php echo base_url(); ?>/css/sweetalert.css" rel="stylesheet"/> 
        <script src="<?php echo base_url(); ?>/js/sweetalert-dev.js"></script>
        <script src="<?php echo base_url(); ?>/js/jquery-ui/Chart.min.js"></script>
    </head>

    <body class="sb-nav-fixed">            
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="<?php echo base_url();?>/inicio">RESTAURANTE</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>      
            <ul class="navbar-nav ms-auto me-3 me-lg-4 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $user_session->nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/gargar_perfil"><i class="fas fa-user"></i> Perfil</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/cambia_password"><i class="fas fa-key"></i> Cambiar contraseña</a></li>                   
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                                 PRODUCTOS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" >
                                <nav class="sb-sidenav-menu-nested nav">             
                                    <a class="nav-link" href="<?php echo base_url(); ?>/productos">Productos</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>/categorias">Categorías</a>    
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="true" aria-controls="pagesCollapseError">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                CLIENTES
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne">
                                        <nav class="sb-sidenav-menu-nested nav">
                                           <a class="nav-link" href="<?php echo base_url(); ?>/clientes">Clientes</a>
                                        </nav>
                                    </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuCompras" aria-expanded="false" aria-controls="menuCompras">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                 COMPRAS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="menuCompras" aria-labelledby="headingOne">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/compras/nuevo">Nueva compra</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>/compras">Compras</a>
                                </nav>
                            </div>
                            
                        <a class="nav-link"  href="<?php echo base_url(); ?>/ventas/venta"><div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>CAJA</a>
                        <a class="nav-link"  href="<?php echo base_url(); ?>/ventas"><div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>VENTA REALIZADA</a>

                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuReport" aria-expanded="false" aria-controls="menuReport">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                                REPORTES 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="menuReport" aria-labelledby="headingOne">
                                        <nav class="sb-sidenav-menu-nested nav">    
                                             <a class="nav-link" href="<?php echo base_url(); ?>/reportes/mostrarMinimos">Stock mínimos</a>
                                            <a class="nav-link" href="<?php echo base_url(); ?>/reportes">Rango de fechas</a>
                                            <a class="nav-link" href="<?php echo base_url(); ?>/reportes/index_CP">Según categoría</a>
                                        
                                        </nav>
                                    </div>           
                    <a class="nav-link"  href="<?php echo base_url(); ?>/graficos"><div class="sb-nav-link-icon"><i class="fas fa-chart-bar me-1"></i></div>ESTADÍSTICAS</a>         
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#subAdministracion" aria-expanded="false" aria-controls="subAdministracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                            ADMINISTRACIÓN
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="subAdministracion" aria-labelledby="headingOne">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/configuracion">Configuración</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>/usuarios">Usuarios</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>/roles">Roles</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>/cajas">Cajas</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                   <div class="py-2 px-2">
                        <div class="small fw-bold fst-italic" >INTEGRANTES</div>
                        <div class="small">- Elian Paz Alvarez Choque</div>
                        <div class="small">- Dennis Sebastian Vallejos Luna</div>
                        <div class="small">- Mauricio Reyes Ortiz </div>
                    </div>
                </nav>
            </div>
