<?php 
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CategoriasModel;
    use App\Models\DetalleRolesPermisosModel;
    use App\Models\ProductosModel;
    use App\Models\VentasModel;

    class Graficos extends BaseController
    {
        protected $categorias,$productoModel,$ventasModel,$session,$detalleRoles;

        public function __construct()
        {
            $this->categorias = New CategoriasModel();
            $this->productoModel= New ProductosModel();
            $this->ventasModel= New VentasModel();
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->session = session();
        }

        public function index()
        {  
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Estadisticas','estadistica');
            echo view('header');
            if (!$permiso1) {echo view('roles/sinpermiso');}
            else { 
                $total = $this->productoModel->totalProductos();
                $hoy= date('Y-m-d');
                $anio_actual= date('Y');
                $mes_actual= date('m');
                $totalVentas = $this->ventasModel->totalDia($hoy);
    
                $minimos = $this->productoModel->productosMinimo();
                $añoActual= date('Y');
                $totalxmeses= $this->ventasModel->totalxmes($añoActual);
                $topProductMasV= $this->ventasModel->productos_mas_vendidos($mes_actual,$anio_actual);

                $datos = ['total'=> $total, 'totalVentas' => $totalVentas, 'minimos'=> $minimos,'totalxmeses'=> $totalxmeses,'topProductMasV'=> $topProductMasV];        
                echo view('graficos/ver_graficos',$datos);
            }
            echo view('footer');
        }

    }
