
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4"><i class="fas fa-chart-bar me-1"></i> Estadísticas</h2>
            <ol class="breadcrumb mb-2"></ol>
            <div class="row">

              <div class="col-xl-3 col-md-6">
                  <div class="card text-white bg-danger mb-3" >
                    <div class="card-header">  <i class="fas fa-utensils"></i> Total de productos</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total;?></h5>
                        <a class="card-link  text-white" href="<?php echo base_url();?>/productos">
                            Ver detalles
                        </a>  
                    </div>
                  </div> 
              </div>
                
              <div class="col-xl-3 col-md-6">
                <div class="card text-dark bg-warning mb-3">
                  <div class="card-header"><i class="fas fa-cash-register"></i> Ventas del día</div>
                  <div class="card-body">
                      <h5 class="card-title"><?php if($totalVentas['total']==null){ echo 0;}else{echo $totalVentas['total'];};?> bs.</h5>
                      <a class="card-link  text-dark" href="<?php echo base_url();?>/reportes/mostrarVendasDia">                     
                            <?php echo date('d-m-Y');?>
                      </a>
                  </div>
                </div> 
              </div>

                <div class="col-xl-3 col-md-6">
                  <div class="card text-white bg-success mb-3" >
                    <div class="card-header"><i class="fas fa-money-bill-wave"></i> Monto del Mes</div>
                    <div class="card-body">
                        <h5 class="card-title">
                          <?php foreach ($totalxmeses as $totalxmes) {?>
                              <?php if ($totalxmes['mes'] == date("F")){$m_actual= $totalxmes['total']; }?>
                          <?php } ?>  
                          <?php if(isset($m_actual)){echo $m_actual;}else{echo 0;} ?> Bs.
                        </h5>
                        <a class="card-link  text-white" href="<?php echo base_url();?>/reportes/mostrarVentasMes">                     
                          <?php echo date('F-Y');?>
                        </a>
                    </div>
                  </div> 
                </div>

                <div class="col-xl-3 col-md-6">
                  <div class="card bg-primary text-white mb-3">
                      <div class="card-header"><i class="fas fa-list"></i> Stock mínimos</div>
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
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-dark">
                            <i class="fas fa-chart-area me-1"></i>
                            Monto por mes  del <?php echo date('Y'); ?>
                        </div>
                        <div class="card-body">
                          <canvas id="myBarChart" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-chart-bar me-1"></i>
                            <label class="fw-bold">TOP 10</label>
                            Productos más vendidos en
                            <label class="fw-bold"> <?php echo date('F - Y');?></label>
                        </div>
                        <div class="card-body">
                          <canvas id="myBarChart2" width="100%" height="50"></canvas>                                 
                        </div>
                    </div>
                </div>
            </div>

          <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    MONTO TOTAL DE CADA MES - <?php echo date('Y');?>
                </div>
                <div class="card-body">
                  <table class="table table-bordered">
                      <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Monto</th>                                     
                            </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($totalxmeses as $totalxmess) {?>
                          <tr>            
                            <td class="align-middle"><?php echo $totalxmess['mes'] ?></td>
                            <td class="align-middle"><?php echo $totalxmess['total'] ?></td>                              
                          </tr>        
                        <?php } ?>  
                      </tbody>
                   </table>
                </div>
            </div>
          </div>

        </div>
    </main>

  <script>
  <?php foreach ($totalxmeses as $totalxmes) {?>
  <?php  if ($totalxmes['mes'] == 'January'){$m1= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'February') {$m2= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'March'){$m3= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'April'){$m4= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'May') {$m5= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'June'){$m6= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'July') {$m7= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'August'){$m8= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'September'){$m9= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'October'){$m10= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'November') {$m11= $totalxmes['total']; }?>
  <?php if ($totalxmes['mes'] == 'December'){$m12= $totalxmes['total']; }?>
  <?php } ?>

  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Enero", "Febrero", "marzo", "Abril", "Mayo", "Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
      datasets: [{
        label: "Monto",
        backgroundColor: "rgba(2,117,216,1)",
        borderColor: "rgba(2,117,216,1)",    
          data: ["<?php if(isset($m1)){echo $m1;}else{echo 0;} ?>","<?php if(isset($m2)){echo $m2 ;}else{echo 0;} ?>","<?php if(isset($m3)){echo $m3;}else{echo 0;} ?>","<?php if(isset($m4)){echo $m4;}else{echo 0;} ?>","<?php if(isset($m5)){echo $m5;}else{echo 0;} ?>","<?php if(isset($m6)){echo $m6;}else{echo 0;} ?>","<?php if(isset($m7)){echo $m7;}else{echo 0;} ?>","<?php if(isset($m8)){echo $m8;}else{echo 0;} ?>","<?php if(isset($m9)){echo $m9;}else{echo 0;} ?>","<?php if(isset($m10)){echo $m10;}else{echo 0;} ?>","<?php if(isset($m11)){echo $m11;}else{echo 0;} ?>","<?php if(isset($m12)){echo $m12;}else{echo 0;} ?>"],
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 12
          }
        }],
        yAxes: [{
          gridLines: {
            display: true
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });
<?php   $cont=1;?>
      <?php foreach ($topProductMasV as $top) {?>
          <?php if ($cont==1){$p1= $top['cantidad']; $pn1= $top['nombre'].' - '.$top['capacidad']; }?>
          <?php if ($cont==2){$p2= $top['cantidad'];$pn2= $top['nombre'].' - '.$top['capacidad']; }?>
          <?php if ($cont==3){$p3= $top['cantidad']; $pn3= $top['nombre'].' - '.$top['capacidad'];}?>
          <?php if ($cont==4){$p4= $top['cantidad']; $pn4= $top['nombre'].' - '.$top['capacidad'];}?>
          <?php if ($cont==5){$p5= $top['cantidad'];$pn5= $top['nombre'].' - '.$top['capacidad'];}?>
          <?php if ($cont==6){$p6= $top['cantidad']; $pn6= $top['nombre'].' - '.$top['capacidad']; }?>
          <?php if ($cont==7){$p7= $top['cantidad'];$pn7= $top['nombre'].' - '.$top['capacidad']; }?>
          <?php if ($cont==8){$p8= $top['cantidad']; $pn8= $top['nombre'].' - '.$top['capacidad'];}?>
          <?php if ($cont==9){$p9= $top['cantidad']; $pn9= $top['nombre'].' - '.$top['capacidad'];}?>
          <?php if ($cont==10){$p10= $top['cantidad'];$pn10= $top['nombre'].' - '.$top['capacidad'];}?>
      <?php   $cont++;?>
  <?php } ?>

  // Bar Chart Example
  var ctx = document.getElementById("myBarChart2");
  var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["<?php if(isset($pn1)){echo $pn1;}else{echo '';} ?>","<?php if(isset($pn2)){echo $pn2;}else{echo '';} ?>","<?php if(isset($pn3)){echo $pn3;}else{echo '';} ?>","<?php if(isset($pn4)){echo $pn4;}else{echo '';} ?>","<?php if(isset($pn5)){echo $pn5;}else{echo '';} ?>","<?php if(isset($pn6)){echo $pn6;}else{echo '';} ?>","<?php if(isset($pn7)){echo $pn7;}else{echo '';} ?>","<?php if(isset($pn8)){echo $pn8;}else{echo '';} ?>","<?php if(isset($pn9)){echo $pn9;}else{echo '';} ?>","<?php if(isset($pn10)){echo $pn10;}else{echo '';} ?>"],
      datasets: [{
        label: "Monto",
        backgroundColor: "rgba(255, 99, 132, 1)",
        borderColor: "rgba(2,117,216,1)",    
          data: ["<?php if(isset($p1)){echo $p1;}else{echo 0;} ?>","<?php if(isset($p2)){echo $p2;}else{echo 0;} ?>","<?php if(isset($p3)){echo $p3;}else{echo 0;} ?>","<?php if(isset($p4)){echo $p4;}else{echo 0;} ?>","<?php if(isset($p5)){echo $p5;}else{echo 0;} ?>","<?php if(isset($p6)){echo $p6;}else{echo 0;} ?>","<?php if(isset($p7)){echo $p7;}else{echo 0;} ?>","<?php if(isset($p8)){echo $p8;}else{echo 0;} ?>","<?php if(isset($p9)){echo $p9;}else{echo 0;} ?>","<?php if(isset($p10)){echo $p10;}else{echo 0;} ?>"],
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit:12
          }
        }],
        yAxes: [{
          gridLines: {
            display: true
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });

  </script>   
