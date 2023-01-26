<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\CajasModel;
    use App\Models\VentasModel;
    use App\Models\DetalleRolesPermisosModel;
    use App\Models\ProductosModel;
    use App\Models\CategoriasModel;

class Reportes extends BaseController
{
    protected $cajas, $ventas,$session,$detalleRoles,$productos,$categorias;
    protected $reglas;
 
    public function __construct()
    {
        $this->categorias = New CategoriasModel();
        $this->cajas = New CajasModel();
        $this->ventas = New VentasModel();
        $this->detalleRoles = New DetalleRolesPermisosModel();
        $this->productos = New ProductosModel();
        $this->session = Session();
        helper(['form']);

        $this->reglas = [
            'fecha_inicio'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ],
            'fecha_fin'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index()
    {
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'RangoFechas','reporte');
            echo view('header');
            if (!$permiso1) { echo view('roles/sinpermiso');}
            else {
                $cajas = $this->cajas->where('activo', 1)->findAll();
                $data = ['titulo' => 'Reporte de ventas','cajas'=>$cajas];
                echo view('reportes/rango_ventas',$data);     
        }
        echo view('footer');
    }

    function reporte_ventas()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'RangoFechas','reporte');
        if (!$permiso1) { echo view('header');echo view('roles/sinpermiso');echo view('footer');}
        else {
            if($this->request->getMethod() =="post" && $this->validate($this->reglas))
            {
            $fechaini = $this->request->getPost('fecha_inicio');
            $fechafin = $this->request->getPost('fecha_fin');
            $id_caja = $this->request->getPost('caja');
            $data = ['fechaini'=>$fechaini,'fechafin'=>$fechafin,'id_caja'=>$id_caja];
            echo view('header');
            echo view('reportes/ver_pdf_rangoVentas',$data);
            echo view('footer');
            }else {
                $cajas = $this->cajas->where('activo', 1)->findAll();
                $data = ['titulo' => 'Reporte de ventas','cajas'=>$cajas,'validation'=>$this->validator];
                echo view('header');
                echo view('reportes/rango_ventas',$data);
                echo view('footer');
            }
        }
    }

    public function generarPdfRangoVentas($fechaini =null, $fechafin=null,$id_caja=null)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'RangoFechas','reporte');
        if (!$permiso1) { echo view('header');echo view('roles/sinpermiso');echo view('footer');}
        else {
            $pdf = new \FPDF('P','mm','letter');
            $pdf->AddPage();
            $pdf->SetMargins(12,12,12);
            $pdf->SetTitle("Productos con stock minimo");
            $pdf->SetFont('Arial','B',15);
            $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');
            $pdf->Cell(195,5,utf8_decode("Reporte de ventas según rango de fechas"),0,1,'C');
            $pdf->SetFont('Arial','B',11);
            $pdf->Ln(14);
            $pdf->Cell(12,5,utf8_decode('Nº'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('Folio'),1,0,'L');
            $pdf->Cell(44,5,utf8_decode('fecha'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('cajero'),1,0,'L');
            $pdf->Cell(50,5,utf8_decode('cliente'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('Monto'),1,1,'L');
            $pdf->SetFont('Arial','',11);

            $datosProductos =$this->ventas->rangoFechas($fechaini,$fechafin,$id_caja);
            $contador = 1;
            $sum=0;
            $cortar=47;
            $pdf->SetAutoPageBreak(false);
            foreach ($datosProductos as $producto) {
                $pdf->Cell(12,5,$contador,1,0,'L');
                $pdf->Cell(30,5,$producto['folio'],1,0,'L');
                $pdf->Cell(44,5,utf8_decode($producto['fecha_alta']),1,0,'L');
                $pdf->Cell(28,5,utf8_decode($producto['cajero']),1,0,'L');
                $pdf->Cell(50,5,utf8_decode($producto['cliente']),1,0,'L');
                $pdf->Cell(28,5,$producto['total'],1,1,'L');
                $sum=$sum+ $producto['total'];
                $contador++;
                
                if ($contador==$cortar) {
                    $pdf->AddPage();
                    $cortar= $cortar+50;
                }
            }
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(192,5,'Total: '.number_format($sum,2,'.',',').' Bs.',0,1,'R');
            $this->response->setHeader('Content-type','application/pdf');
            $pdf->Output('ProductoMinimo.pdf','I');
        }
    }

    function mostrarMinimos()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
         $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'StockMinimos','reporte');   
         echo view('header');              
         if (!$permiso1) {echo view('roles/sinpermiso');}
         else {
         echo view('reportes/ver_minimos');
         }
         echo view('footer');
    }

    function generaMinimosPdf(){
     if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
     $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'StockMinimos','reporte');
     if (!$permiso1) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
     else {
         $pdf = new \FPDF('P','mm','letter');
         $pdf->AddPage();
         $pdf->SetMargins(12,10,12);
         $pdf->SetTitle("Productos con stock minimo");
         $pdf->SetFont('Arial','B',15);
         $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');
         $pdf->Cell(195,5,utf8_decode("Reporte de producto con stock mínimo"),0,1,'C');
         $pdf->SetFont('Arial','B',11);
         $pdf->Ln(14);
         $pdf->Cell(12,5,utf8_decode('Nº'),1,0,'L');
         $pdf->Cell(30,5,utf8_decode('Código'),1,0,'L');
         $pdf->Cell(66,5,utf8_decode('Nombre'),1,0,'L');
         $pdf->Cell(28,5,utf8_decode('Descripción'),1,0,'L');
         $pdf->Cell(28,5,utf8_decode('Existencias'),1,0,'L');
         $pdf->Cell(28,5,utf8_decode('Stock mínimo'),1,1,'L');
         $pdf->SetFont('Arial','',11);
         $datosProductos=$this->productos->getProductosMinimo();
         $contador = 1;
         foreach ($datosProductos as $producto) {
             $pdf->Cell(12,5,$contador,1,0,'L');
             $pdf->Cell(30,5,$producto['codigo'],1,0,'L');
             $pdf->Cell(66,5,utf8_decode($producto['nombre']),1,0,'L');
             $pdf->Cell(28,5,utf8_decode($producto['capacidad']),1,0,'L');
             $pdf->Cell(28,5,$producto['existencias'],1,0,'L');
             $pdf->Cell(28,5,$producto['stock_minimo'],1,1,'L');
             $contador++;
         }
         $this->response->setHeader('Content-type','application/pdf');
         $pdf->Output('ProductoMinimo.pdf','I');
        }
    }

    function mostrarVendasDia()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Estadisticas','estadistica');
        echo view('header');
        if (!$permiso1) {echo view('roles/sinpermiso');}
        else {
        echo view('reportes/ventas_del_dia');
        }
        echo view('footer');
    }

     function generaVentaDiaPdf(){
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Estadisticas','estadistica');
        if (!$permiso1) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
        else {
            $hoy= date('d-m-Y');
            $pdf = new \FPDF('P','mm','letter');
            $pdf->AddPage();
            $pdf->SetMargins(12,12,12);
            $pdf->SetTitle("VentaDia");
            $pdf->SetFont('Arial','B',15);
            $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');   
            $pdf->Cell(195,5,utf8_decode("Ventas del día ".$hoy),0,1,'C');
            $pdf->SetFont('Arial','B',11);
            $pdf->Ln(14);
            $pdf->Cell(12,5,utf8_decode('Nº'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('Folio'),1,0,'L');
            $pdf->Cell(44,5,utf8_decode('fecha'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('cajero'),1,0,'L');
            $pdf->Cell(50,5,utf8_decode('cliente'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('Monto'),1,1,'L');
            $pdf->SetFont('Arial','',11);
            $hoy= date('Y-m-d');
            $datosProductos=$this->ventas->ventas_del_dia($hoy);
            $contador = 1;
            $sum=0;
            $cortar = 47;
            $pdf->SetAutoPageBreak(false);
            foreach ($datosProductos as $producto) {
                $pdf->Cell(12,5,$contador,1,0,'L');
                $pdf->Cell(30,5,$producto['folio'],1,0,'L');
                $pdf->Cell(44,5,utf8_decode($producto['fecha_alta']),1,0,'L');
                $pdf->Cell(28,5,utf8_decode($producto['cajero']),1,0,'L');
                $pdf->Cell(50,5,utf8_decode($producto['cliente']),1,0,'L');
                $pdf->Cell(28,5,$producto['total'],1,1,'L');
                $sum=$sum+ $producto['total'];
                $contador++;
                if ($contador==$cortar) {
                    $pdf->AddPage();
                    $cortar= $cortar+50;
                }
            }
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(192,5,'Total: '.number_format($sum,2,'.',',').' Bs.',0,1,'R');
            $this->response->setHeader('Content-type','application/pdf');
            $pdf->Output('ProductoMinimo.pdf','I');
        }
    }

    function mostrarVentasMes()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Estadisticas','estadistica');   
        echo view('header');
        if (!$permiso1) {echo view('roles/sinpermiso');}
        else {
        echo view('reportes/ventas_del_mes');
        }
        echo view('footer');
    }

    function generaVentaMesPdf(){
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Estadisticas','estadistica');                 
        if (!$permiso1) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
        else {
            $mes_actual= date('m');
            $mes= date('F');
            $pdf = new \FPDF('P','mm','letter');
            $pdf->AddPage();
            $pdf->SetMargins(12,12,12);
            $pdf->SetTitle("VentasMes");
            $pdf->SetFont('Arial','B',15);
            $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');
            $pdf->Cell(195,5,utf8_decode("Ventas del mes ".$mes_actual." (".$mes.")"),0,1,'C');
            $pdf->SetFont('Arial','B',11);
            $pdf->Ln(14);
            $pdf->Cell(12,5,utf8_decode('Nº'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('Folio'),1,0,'L');
            $pdf->Cell(44,5,utf8_decode('fecha'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('cajero'),1,0,'L');
            $pdf->Cell(50,5,utf8_decode('cliente'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('Monto'),1,1,'L');
            $pdf->SetFont('Arial','',11);

            $datosProductos=$this->ventas->ventas_del_mes($mes_actual);
            $contador = 1;
            $sum=0;
            $cortar = 47;
            $pdf->SetAutoPageBreak(false);
            foreach ($datosProductos as $producto) {
                $pdf->Cell(12,5,$contador,1,0,'L');
                $pdf->Cell(30,5,$producto['folio'],1,0,'L');
                $pdf->Cell(44,5,utf8_decode($producto['fecha_alta']),1,0,'L');
                $pdf->Cell(28,5,utf8_decode($producto['cajero']),1,0,'L');
                $pdf->Cell(50,5,utf8_decode($producto['cliente']),1,0,'L');
                $pdf->Cell(28,5,$producto['total'],1,1,'L');
                $sum=$sum+ $producto['total'];
                $contador++;
                if ($contador==$cortar) {
                    $pdf->AddPage();
                    $cortar= $cortar+50;
                }
            }
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(192,5,'Total: '.number_format($sum,2,'.',',').' Bs.',0,1,'R');
            $this->response->setHeader('Content-type','application/pdf');
            $pdf->Output('ProductoMinimo.pdf','I');
        }
    }

    function index_CP()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'SegúnCategoria','reporte');
        echo view('header');
        if (!$permiso1) {echo view('roles/sinpermiso');}
        else {
            $categorias = $this->categorias->where('activo',1)->findAll();
            $data = ['titulo' => 'Reporte de productos según categoría','categorias'=>$categorias];
            echo view('reportes/seleccionar_categoria', $data);
        }
        echo view('footer');
    }

    function tabla_CP()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'SegúnCategoria','reporte');
        echo view('header');
        if (!$permiso1) {echo view('roles/sinpermiso');}
        else {
            if($this->request->getMethod() =="post" )
            {
                $id_cat = $this->request->getPost('id_categoria');
                $prod = $this->productos->mostrarProductoCat($id_cat);
                if ($id_cat==0) {
                    $data = ['titulo' =>'Todas las categorias','prod'=>$prod, 'id_cat'=> $id_cat];
                }else {
                    $data = ['prod'=>$prod, 'id_cat'=> $id_cat];
                }
                echo view('reportes/tabla_categoria', $data);
            }
            else{
                return redirect()->to(base_url().'/reportes/index_CP');
            }
        }
        echo view('footer');
    }

    function decargarPdfCat($id_cat,$cat_nombre){
    
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'SegúnCategoria','reporte');
        if (!$permiso1) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
        else {
            $pdf = new \FPDF('P','mm','letter');
            $pdf->AddPage();
            $pdf->SetMargins(12,12,12);
            $pdf->SetTitle("Productos con stock minimo");
            $pdf->SetFont('Arial','B',15);
            $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');
            $pdf->Cell(195,5,utf8_decode("Reporte de ".$cat_nombre),0,1,'C');
            $pdf->SetFont('Arial','B',11);
            $pdf->Ln(14);
            $pdf->Cell(12,5,utf8_decode('Nº'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('codigo'),1,0,'L');
            $pdf->Cell(44,5,utf8_decode('nombre'),1,0,'L');
            $pdf->Cell(28,5,utf8_decode('Descripción'),1,0,'L');
            $pdf->Cell(26,5,utf8_decode('Precio venta'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('Precio compra'),1,0,'L');
            $pdf->Cell(24,5,utf8_decode('existencias'),1,1,'L');
            $pdf->SetFont('Arial','',11);

            $mes_actual= date('m');
            $datosProductos= $this->productos->mostrarProductoCat($id_cat);
            $contador = 1;
            $sum=0;
            $cortar = 47;
            $pdf->SetAutoPageBreak(false);
            foreach ($datosProductos as $producto) {
                $pdf->Cell(12,5,$contador,1,0,'L');
                $pdf->Cell(28,5,$producto['codigo'],1,0,'L');
                $pdf->Cell(44,5,utf8_decode($producto['nombre']),1,0,'L');
                $pdf->Cell(28,5,utf8_decode($producto['capacidad']),1,0,'L');
                $pdf->Cell(26,5,$producto['precio_venta'],1,0,'L');
                $pdf->Cell(30,5,$producto['precio_compra'],1,0,'L');
                $pdf->Cell(24,5,$producto['existencias'],1,1,'L');
                $contador++;

                if ($contador==$cortar) {
                    $pdf->AddPage();
                    $cortar= $cortar+50;
                }
            }
            $pdf->Ln();
            $this->response->setHeader('Content-type','application/pdf');
            if ($id_cat==0) {
                $pdf->Output('CategoriasTodas.pdf','D');
            }else {
                if (isset($producto['categoria'])) {
                    $pdf->Output('Categorias'.$producto['categoria'].'.pdf','D');
                }else {
                    return redirect()->to(base_url().'/reportes/index_CP');
                }
            }         
        }

    }

}
