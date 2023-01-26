<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <div class= "col-xs-12 col-sm-12 col-md-12">
                <div class="panel">
                    <div class="ratio ratio-1x1" style="margin-top: 30px;">
                        <iframe class="embed-resposive-item" src="<?php echo base_url()."/reportes/generarPdfRangoVentas/".$fechaini."/".$fechafin."/".$id_caja;?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
    if (window.history.replaceState){
        window.history.replaceState(null,null,'<?php echo base_url(); ?>/reportes/index');
    }
    </script>
