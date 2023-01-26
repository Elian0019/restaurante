<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
         <br />
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-2">
                    <div class="card text-white bg-primary mb-3" >
                        <div class="card-header">  <i class="fas fa-utensils"></i> Total de productos</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $total;?></h5>
                            <a class="card-link  text-white" href="<?php echo base_url();?>/productos">
                                Ver detalles
                            </a>
                        </div>
                    </div> 
                </div>
                <div class="col-xl-3 col-sm-6 mb-2">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header"><i class="fas fa-cash-register"></i> Ventas del día</div>
                        <div class="card-body">
                            <h5 class="card-title"> <?php if($totalVentas['total']==null){ echo 0;}else{echo $totalVentas['total'];};?> bs.</h5>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <label class="card-link text-white" ><?php echo date('d-m-Y');?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-2">
                    <div class="card text-white bg-danger mb-3" >
                        <div class="card-header"><i class="fas fa-list"></i> Monto del mes</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php foreach ($totalxmeses as $totalxmes) {?>
                                    <?php if ($totalxmes['mes'] == date("F")){$m_actual= $totalxmes['total']; }?>
                                <?php } ?>
                                <?php if(isset($m_actual)){echo $m_actual;}else{echo 0;} ?> Bs.
                            </h5>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <label class="card-link  text-white" >
                                    <?php echo date("F")?> - <?php echo date('Y') ?>

                                </label>   
                            </div>                
                        </div>
                    </div> 
                </div>

                <div class="col-xl-3 col-sm-6 mb-2">
                    <div class="card text-white bg-secondary mb-3" >
                        <div class="card-header">   <i class="fas fa-list"></i> Stock mínimos</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $minimos;?></h5>
                            <a class="card-link  text-white" href="<?php echo base_url();?>/reportes/mostrarMinimos">
                                Ver detalles
                            </a>  
                        </div>
                    </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header bg-white text-dark ">
                            <i class="fas fa-chart-bar me-1"></i>
                           TOP 10 Productos más vendidos en <?php echo date('F-Y');?>

                        </div>
                        <div class="card-body ">
                            <canvas id="myChart" width="500px" height="280px"></canvas>
                        </div>
                    </div>
                </div>
                <?php $cont=1;?>
                    <?php foreach ($topProductMasV as $top){ ?>
                        <?php if ($cont==1){$p1= $top['cantidad']; $pn1= $top['nombre'].' - '.$top['capacidad']; $id1=$top['id_producto'];  }?>
                        <?php if ($cont==2){$p2= $top['cantidad'];$pn2= $top['nombre'].' - '.$top['capacidad'];  $id2=$top['id_producto'];  }?>
                        <?php if ($cont==3){$p3= $top['cantidad']; $pn3= $top['nombre'].' - '.$top['capacidad']; $id3=$top['id_producto'];  }?>
                        <?php if ($cont==4){$p4= $top['cantidad']; $pn4= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==5){$p5= $top['cantidad'];$pn5= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==6){$p6= $top['cantidad'];$pn6= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==7){$p7= $top['cantidad'];$pn7= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==8){$p8= $top['cantidad'];$pn8= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==9){$p9= $top['cantidad'];$pn9= $top['nombre'].' - '.$top['capacidad']; }?>
                        <?php if ($cont==10){$p10= $top['cantidad'];$pn10= $top['nombre'].' - '.$top['capacidad']; }?>
                    <?php $cont++;?>
                <?php } ?>
                <?php if(isset($id1)){ $id11= $id1;}else{ $id11= "0";} ?>
                <?php if(isset($id2)){ $id22= $id2;}else{ $id22= "0";} ?>
                <?php if(isset($id3)){ $id33=$id3;}else{ $id33= "0";} ?>

                <div class="col-xl-6 col-lg-6 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header  bg-white text-dark ">
                            <i class="fas fa-utensils"></i> &nbsp; TOP 3 de los productos más vendidos
                        </div>
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">            
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                                
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="2000">  
                                    <img width="500px" height="320px" src="<?php echo base_url().'/images/productos/';?><?php echo $id11 .'.jpg?';?><?php echo time(); ?>" class="d-block w-100" alt="">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 class="fw-bold fst-italic"><?php if(isset($pn1)){echo $pn1;}else{echo '';} ?></h5>
                                    </div>
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <img  width="500px" height="320px" src="<?php echo base_url().'/images/productos/';?><?php echo $id22 .'.jpg?';?><?php echo time(); ?>" class="d-block w-100" alt="">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 class="fw-bold fst-italic"><?php if(isset($pn2)){echo $pn2;}else{echo '';} ?></h5>
                                    </div>
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <img width="500px"  height="320px" src="<?php echo base_url().'/images/productos/';?><?php echo $id33.'.jpg?';?><?php echo time(); ?>" class="d-block w-100" alt="">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 class="fw-bold fst-italic"><?php if(isset($pn3)){echo $pn3;}else{echo '';} ?></h5>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
 <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["<?php if(isset($pn1)){echo $pn1;}else{echo '';} ?>","<?php if(isset($pn2)){echo $pn2;}else{echo '';} ?>","<?php if(isset($pn3)){echo $pn3;}else{echo '';} ?>","<?php if(isset($pn4)){echo $pn4;}else{echo '';} ?>","<?php if(isset($pn5)){echo $pn5;}else{echo '';} ?>","<?php if(isset($pn6)){echo $pn6;}else{echo '';} ?>","<?php if(isset($pn7)){echo $pn7;}else{echo '';} ?>","<?php if(isset($pn8)){echo $pn8;}else{echo '';} ?>","<?php if(isset($pn9)){echo $pn9;}else{echo '';} ?>","<?php if(isset($pn10)){echo $pn10;}else{echo '';} ?>"],
            datasets: [{
                label: "Cantidad",
                data:["<?php if(isset($p1)){echo $p1;}else{echo'';} ?>","<?php if(isset($p2)){echo $p2;}else{echo '';} ?>","<?php if(isset($p3)){echo $p3;}else{echo '';} ?>","<?php if(isset($p4)){echo $p4;}else{echo '';} ?>","<?php if(isset($p5)){echo $p5;}else{echo '';} ?>","<?php if(isset($p6)){echo $p6;}else{echo '';} ?>","<?php if(isset($p7)){echo $p7;}else{echo '';} ?>","<?php if(isset($p8)){echo $p8;}else{echo '';} ?>","<?php if(isset($p9)){echo $p9;}else{echo '';} ?>","<?php if(isset($p10)){echo $p10;}else{echo '';} ?>"],     
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',

                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            legend: {
            display: false
            }
        }

    });

</script>  
