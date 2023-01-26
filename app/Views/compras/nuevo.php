<?php 
    $id_compra = uniqid();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 py-3"> 
            <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>/compras/guarda" autocomplete="off">
            <?php echo csrf_field(); ?>  

                <div class="form-group">
                    <div class="row">
                            <input type="hidden" id="id_producto" name="id_producto"/>
                            <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra; ?>"/>
                        <div class="col-12 col-sm-4"> 
                            <div class="row">
                                <label class="form-label" >Código</label> 
                            </div>
                            <div class="input-group mb-1">
                                <input  class="form-control" id="codigo" name="codigo" type="text" placeholder="Escribe el código y luego enter." data-bs-toggle="tooltip" data-bs-placement="bottom" title="Codigo" onkeyup="buscarProducto(event,this,this.value)" autofocus>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#lista"><i class="fas fa-list-ol"></i></button>                             
                            </div>
                            <div class="row">
                                <label for="codigo" id ="resultado_error" style="color: red"></label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Nombre del producto</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control me-md-8" id="nombre" name="nombre" type="text" disabled />
                            </div> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Cantidad</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="cantidad" name="cantidad" type="number" onkeyup="Calcula_cantidad_subtotal(event,this,codigo.value,this.value)" onclick="Calcula_cantidad_subtotal2(codigo.value,cantidad.value)"  disabled/>
                            </div> 
                        </div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Precio de compra</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="precio_compra" name="precio_compra" type="text" disabled/>
                            </div> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Subtotal</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="subtotal" name="subtotal" type="text" disabled step="0.01"/>
                            </div> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <label><br></label> 
                            <div class="container-fluid px-0 py-2">
                               <button class="btn btn-primary" id="agregar_producto" name="agregar_producto" type="button" onclick="agregarProducto(id_producto.value,codigo.value,cantidad.value,'<?php echo $id_compra; ?>')">Agregar producto</button>
                            </div> 
                        </div>
                    </div>   
                </div>
             <br>
                <div class="table-responsive">
                    <table id="tablaProductos" class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th width= "1%"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="container-fluid px-0 py-3">
                    <div class="row">
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                            <label style="font-weight: bold; font-size: 30px; text-align: center;">Total Bs.</label>
                            <input type="text" id="total" name="total" size="6" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;"/>
                            <button class="btn btn-success" type="button" id="completa_compra">Completar compra</button>
                        </div>
                    </div>
               </div> 
            </form>   
        </div>     
    </main>
<!-- Modal aviso-->
<div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Ingrese un código y presione enter.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 <!-- Modal lista product-->
 <div class="modal fade" id="lista" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100 text-center fw-bold"id="exampleModalLabel">LISTA DE PRODUCTOS</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card-body"> 
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>      
                        <th>Precio compra</th>               
                        <th>stock</th>
                        <th width= "1%"></th>        
                    </tr>
                </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) {?>
                            <tr>
                                <td class="align-middle"> <?php echo $producto['codigo'] ?></td>                              
                                <td class="align-middle"> <?php echo $producto['nombre'] ?></td>
                                <td class="align-middle"> <?php echo $producto['capacidad'] ?></td>
                                <td class="align-middle"> <?php echo $producto['precio_compra'] ?></td>
                                <td class="align-middle text-center"><?php echo $producto['existencias'] ?></td>
                                <td><a class="badge bg-success" onclick="buscarproducto2(<?php echo $producto['codigo'] ?>)" rel="tooltip" data-placement="top" title="Seleccionar"> <i class="fas fa-plus"></i></a></td> 
                            </tr>        
                        <?php } ?>  
                    </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <script>
    $(document).ready(function() {
        $("#completa_compra").click(function () {
            let nFila= $("#tablaProductos tr").length;
            if(nFila <2){
                swal('Aviso','Agregue productos.','warning');
            }else{
            $("#form_compra").submit();
            }
        });
    });

    function buscarProducto(e,tagCodigo,codigo){
        var enterKey = 13;
        if (codigo != ''|| (e.keyCode==8)) {
            if (e.which == enterKey) {
                $.ajax({
                    url:'<?php echo base_url(); ?>/productos/buscarPorCodigo/'+ codigo, dataType:'json',
                    success: function(resultado){
                        if (resultado == 0) {
                            $(tagCodigo).val('');
                        }
                        else{
                            $("#resultado_error").html(resultado.error);
                            if (resultado.existe) {
                                $("#id_producto").val(resultado.datos.id);
                                $("#nombre").val(resultado.datos.nombre);
                                $("#cantidad").val(1);
                                $("#precio_compra").val(resultado.datos.precio_compra);
                                $("#subtotal").val(resultado.datos.precio_compra);
                                $("#cantidad").focus();
                                document.getElementById('cantidad').disabled=false;
                            }
                        }
                    }
                });
            }else{
                document.getElementById('cantidad').disabled=true;
                $("#id_producto").val('');
                $("#nombre").val('');
                $("#cantidad").val('');
                $("#precio_compra").val('');
                $("#subtotal").val('');
            }
        }
    }

    function buscarproducto2(codigo) {
        $.ajax({
            url:'<?php echo base_url(); ?>/productos/buscarPorCodigo/'+codigo, dataType:'json',
            success: function(resultado){
                if (resultado == 0) {
                    $(tagCodigo).val('');
                }
                else{
                    $("#resultado_error").html(resultado.error);
                    if (resultado.existe) {
                        $("#id_producto").val(resultado.datos.id);
                        $("#codigo").val(resultado.datos.codigo);
                        $("#nombre").val(resultado.datos.nombre);
                        $("#cantidad").val(1);
                        $("#precio_compra").val(resultado.datos.precio_compra);
                        $("#subtotal").val(resultado.datos.precio_compra);
                        $("#cantidad").focus();
                        document.getElementById('cantidad').disabled=false;
                    }
                    $('#lista').modal('hide');
                }
            }
        });
    }

    function Calcula_cantidad_subtotal(e,tagCodigo,codigo, cantidad) {
        if (codigo != '' && cantidad>0 ) {
            if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode==8)) {
                $.ajax({
                    url: '<?php echo base_url(); ?>/productos/calcular_c_subtotal/' + codigo, dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            $(tagCodigo).val('');
                        } else {
                            $("#resultado_error").html(resultado.error);
                            if (resultado.existe) {
                               $("#subtotal").val((resultado.datos.precio_compra * cantidad).toFixed(2));
                            }
                        }
                    }
                });
            }
        }
    }

    function Calcula_cantidad_subtotal2(codigo,cantidad){
        if (codigo != '') {     
            if (cantidad > 0 && cantidad!='') {
                $.ajax({
                    url: '<?php echo base_url(); ?>/productos/calcular_c_subtotal/' + codigo, dataType: 'json',
                    success: function(resultado){
                        if (resultado == 0){
                            $(tagCodigo).val('');
                        } else {
                            $("#resultado_error").html(resultado.error);
                            if (resultado.existe) {
                            $("#subtotal").val((resultado.datos.precio_compra * cantidad).toFixed(2));
                            }
                        }
                    }
                });
            }
        }
    }

    function agregarProducto(id_producto,codigo,cantidad,id_compra) { 
        if(codigo !=''){
            if (id_producto != null && id_producto != 0) {
                if(cantidad > 0 && cantidad!='')
                {
                    $.ajax({
                        url:'<?php echo base_url(); ?>/TemporalCompra/insertar/'+ id_producto + "/"+ cantidad + "/"+id_compra + "/"+1, 
                        success: function(resultado){
                            if (resultado == 0) {
                            }
                            else{
                                var resultado= JSON.parse(resultado);
                                if (resultado.error == '') {
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#total").val(resultado.total);
                                    $("#codigo").val('');
                                    $("#id_producto").val('');
                                    $("#capacidad").val('');
                                    $("#nombre").val('');
                                    $("#cantidad").val('');
                                    $("#precio_compra").val('');
                                    $("#subtotal").val(''); 
                                    document.getElementById('cantidad').disabled=true;
                                }
                            }
                        }
                    });
                }
                else { swal('Error','Agregue una cantidad','error');} 
            }
            else { $('#avisoModal').modal('show');}
        }
        else { $('#avisoModal').modal('show');}
    }

    function eliminaProducto(id_producto, id_compra) { 
        $.ajax({
            url:'<?php echo base_url(); ?>/TemporalCompra/eliminar/'+ id_producto +"/"+ id_compra,
            success: function(resultado){
                if (resultado == 0) {
                    $(tagCodigo).val('');
                }
                else{
                    var resultado= JSON.parse(resultado);
                    $("#tablaProductos tbody").empty();
                    $("#tablaProductos tbody").append(resultado.datos);
                    $("#total").val(resultado.total);
                }
            }
        });
    }
    </script>
