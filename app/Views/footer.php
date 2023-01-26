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
        <script src="<?php echo base_url(); ?>/js/simple-datatables@latest.js"></script>
        <script src="<?php echo base_url(); ?>/js/datatables-simple-demo.js"></script>
        <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
        <script>
            $('#modal-confirma').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            }); 

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $(document).ready(function() {
                $("body").tooltip({
                    selector: '[rel="tooltip"]'
                });
            });
        </script>
    </body>
</html>