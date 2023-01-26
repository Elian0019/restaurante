<?php 
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ComprasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleCompraModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetalleRolesPermisosModel;

    class Compras extends BaseController
    {
        protected $compras, $temporal_compra, $detalle_compra, $productos,$configuracion,$detalleRoles;
        protected $reglas;

        public function __construct()
        {
            $this->compras = New ComprasModel();
            $this->detalle_compra = New DetalleCompraModel();
            $this->configuracion = New ConfiguracionModel();    
            $this->productos = New ProductosModel;
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->session = Session();
        }

        public function index($activo = 1)
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Compras','compra');
            echo view('header');
            if (!$permiso) {
             echo view('roles/sinpermiso');
            }else {
            $compras = $this->compras->where('activo',$activo)->findAll();
            $data = ['titulo' => 'Compras realizadas','compras'=> $compras];      
            echo view('compras/compras', $data);
            }
            echo view('footer');
        }

        public function nuevo()
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'NuevaCompra','compra');
            echo view('header');
            if (!$permiso) {
             echo view('roles/sinpermiso');   
            }else {
                $productos = $this->productos->where('activo',1)->findAll();
                $data = ['productos' => $productos];
                echo view('compras/nuevo',$data);
            }
            echo view('footer');
        }

        public function buscar($id)
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'NuevaCompra','compra');
            echo view('header');
            if (!$permiso) {   
             echo view('roles/sinpermiso');
            }else {
                $product = $this->productos->where('id',$id)->first();
                $dato = ["product"=>$product];
                echo view('compras/nuevo', $dato);
            }
            echo view('footer');
        }

        public function guarda()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'NuevaCompra','compra');
            if (!$permiso) {    
                echo view('header'); echo view('roles/sinpermiso');echo view('footer');
            }else {
                    $id_compra = $this->request->getPost('id_compra');
                    $total =preg_replace('/[\$,]/','',$this->request->getPost('total'));
                    $session = session();
                    $resultadoId = $this->compras->insertaCompra($id_compra,$total,$session->id_usuario);

                $this->temporal_compra = New TemporalCompraModel();       
                if ($resultadoId) {
                        $resultadoCompra = $this->temporal_compra->porCompra($id_compra);
                        foreach ($resultadoCompra as $row) {
                            $this->detalle_compra->save([
                                'id_compra'=> $resultadoId,
                                'id_producto'=> $row['id_producto'],
                                'capacidad'=> $row['capacidad'],
                                'nombre'=> $row['nombre'],
                                'cantidad'=> $row['cantidad'],
                                'precio'=> $row['precio']
                            ]);
                            $this->productos->actualizaStock($row['id_producto'],$row['cantidad']);
                        }
                }
                $this->temporal_compra->eliminarCompra($id_compra);
                return redirect()->to(base_url()."/compras/muestraCompraPdf/".$resultadoId);
            }
        }

        function muestraCompraPdf( $id_compra)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Compras','compra');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'NuevaCompra','compra');
            echo view('header');
            if (!$permiso1 && !$permiso2) {
                echo view('roles/sinpermiso');
            }else {
                $data['id_compra'] = $id_compra;
                echo view('compras/ver_compra_pdf',$data);
            }
            echo view('footer');
        }

        function generaCompraPdf( $id_compra)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Compras','compra');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'NuevaCompra','compra');
            if (!$permiso1 && !$permiso2) {
                echo view('header');  echo view('roles/sinpermiso');  echo view('footer');
            }else {
                $datosCompra = $this->compras->where('id',$id_compra)->first();
                $detalleCompra = $this->detalle_compra->select('*')->where('id_compra',$id_compra)->findAll();
                $nombreTienda = $this->configuracion->select('valor')->where('nombre','tienda_nombre')->get()->getRow()->valor;
                $direccionTienda = $this->configuracion->select('valor')->where('nombre','tienda_direccion')->get()->getRow()->valor;
                
                $pdf = new \FPDF('P','mm','letter');
                $pdf->AddPage();
                $pdf->SetMargins(10,10,10);
                $pdf->SetTitle("Compra");
                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(195,5,'Compra de productos',0,1,'C');
                $pdf->image(base_url().'/images/logotipo.png',185,10,18,16,'PNG');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(50,5,'Restaurante "'.$nombreTienda.'"',0,1,'L');
                $pdf->Cell(20,5,utf8_decode('Dirección: '),0,0,'L');
                $pdf->SetFont('Arial','',9);
                $pdf->Cell(50,5,$direccionTienda,0,1,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25,5,utf8_decode('Fecha y hora: '),0,0,'L');
                $pdf->SetFont('Arial','',9);
                $pdf->Cell(50,5,$datosCompra['fecha_alta'],0,1,'L');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',9);
                $pdf->SetFillColor(0,0,0);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(196,5,'Detalle de productos',1,1,'C',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(14,5,'No',1,0,'L');
                $pdf->Cell(72,5,'Nombre',1,0,'L');
                $pdf->Cell(30,5,'Descripcion',1,0,'L');
                $pdf->Cell(25,5,'Precio',1,0,'L');
                $pdf->Cell(25,5,'Cantidad',1,0,'L');
                $pdf->Cell(30,5,'Subtotal',1,1,'L');
                $pdf->SetFont('Arial','',8);               

                $contador = 1;
                foreach ($detalleCompra as $row) {
                    $pdf->Cell(14,5,$contador,1,0,'L');        
                    $pdf->Cell(72,5,utf8_decode($row['nombre']),1,0,'L');
                    $pdf->Cell(30,5,utf8_decode($row['capacidad']),1,0,'L');
                    $pdf->Cell(25,5,$row['precio'],1,0,'L');
                    $pdf->Cell(25,5,$row['cantidad'],1,0,'L');
                    $importe = number_format($row['precio'] * $row['cantidad'],2,'.',',');
                    $pdf->Cell(30,5,$importe,1,1,'R'); 
                    $contador++;
                }
                $pdf->Ln();
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(195,5,'Total: Bs '.number_format($datosCompra['total'],2,'.',','),0,1,'R');
                $this->response->setHeader('Content-Type','application/pdf');
                $pdf->Output("compra_pdf.pdf","I");
            }
        }
    }
