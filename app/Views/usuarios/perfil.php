<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
        <h4 class="mt-4">Perfil de usuario</h4>
        <input type="hidden" id="id" name="id" value="<?php echo $usuario['id'];?>"/>
            <div class="card mb-4" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo base_url(). '/images/user.png?'; ?><?php echo time(); ?>" width="142"class="img-thumbnail ">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Administrador</h5>
                            <table width="100%">
                                <tr>
                                    <td width="30%"><b>Usuario:</b></td>
                                    <td width="70%"><?php echo $usuario['usuario']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Rol:</b></td>
                                    <td><?php echo $rol['nombre']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Caja:</b></td>
                                    <td><?php echo $caja['nombre']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
