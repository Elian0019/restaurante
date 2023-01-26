    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4"> 
                    <h2 class=" mb-3 mt-3 fw-bold"><i class="fa fa-lock"></i> NO TIENE ACCESO A ESTE MÓDULO.</h2>
                <form autocomplete="off">
                    <label class="form-label fw-bold"><i class="text-danger">*</i> Contacte al Administrador del sistema.</label>
                    <!-- Modal -->
                    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title w-100 text-center fw-bold text-dark" id="staticBackdropLabel"> <i class="fas fa-exclamation-triangle text-warning" ></i> NO AUTORIZADO</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="fst-italic">No tiene permiso para acceder a este módulo.</label>
                                <label class="fst-italic">Por favor contacte al administrador.</label>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Entendido</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>

    <script>
        $( document ).ready(function() {
            $('#staticBackdrop').modal('toggle')
        });
    </script>