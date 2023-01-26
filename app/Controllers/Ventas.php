<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\VentasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleVentaModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\CajasModel;
    use App\Models\UsuariosModel;
    use App\Models\DetalleRolesPermisosModel;

class Ventas extends BaseController
{
    protected $ventas, $temporal_compra, $detalle_venta, $productos,$configuracion, $cajas, $session,$usuarios,$detalleRoles;
    public function __construct()
    {
        $this->ventas = New VentasModel();
        $this->detalle_venta = New DetalleVentaModel();
        $this->productos= new ProductosModel();
        $this->configuracion = New ConfiguracionModel();
        $this->cajas = New CajasModel();
        $this->usuarios = New UsuariosModel();
        $this->detalleRoles = New DetalleRolesPermisosModel();
        $this->session = session();
        helper(['form']);
    }

    public function index()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
        $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Ventas','venta');
        echo view('header');
        if (!$permiso) {        
        echo view('roles/sinpermiso'); 
        }else {
            $datos = $this->ventas->obtener(1);      
            $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','venta');
            $permiso_VerTicket = $this->detalleRoles->verificaPermisos($this->session->id_rol,'VerTicket','venta');
            $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','venta');
            if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = '';}
            if (!$permiso_VerTicket) { $btn_verticket =' visually-hidden';} else { $btn_verticket = '';}
            if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = '';}
            $data = ['titulo' => 'Ventas Realizadas','datos'=> $datos];
            $data = [
                'titulo' => 'Ventas Realizadas',
                'datos' => $datos,
                'btn_eliminados' => $btn_eliminados,
                'btn_verticket' => $btn_verticket,
                'btn_eliminar' => $btn_eliminar
            ];
        echo view('ventas/ventas', $data);
        }
        echo view('footer');
    }

    public function eliminados()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}         
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Ventas','venta');   
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','venta');       
        echo view('header'); 
        if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
        else {
            $datos = $this->ventas->obtener(0);
            $data = ['titulo' => 'Ventas Eliminadas','datos'=> $datos];
            echo view('ventas/eliminados', $data);
        }
        echo view('footer');
    }

    public function venta()
    {
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Caja','cajaventa');
        echo view('header');
        if (!$permiso1) { echo view('roles/sinpermiso');}
        else {
            $productos = $this->productos->where('activo',1)->findAll();
            $data = ['productos' => $productos];
        echo view('ventas/caja',$data);
        }
        echo view('footer');
    }

    public function guarda()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Caja','cajaventa');
        if (!$permiso1) {  echo view('header');echo view('roles/sinpermiso');echo view('footer');}
        else {
            $id_venta = $this->request->getPost('id_venta');
            $total =preg_replace('/[\$,]/','',$this->request->getPost('total'));
            $forma_pago = $this->request->getPost('forma_pago');
            $id_cliente = $this->request->getPost('id_cliente');
            $caja = $this->cajas->where('id',$this->session->id_caja)->first();
            $folio=$caja['folio'];
            $user = $this->usuarios->where('id',$this->session->id_usuario)->first();
            $id_caja = $user['id_caja'];
            $resultadoId = $this->ventas->insertaVenta($folio,$total,$this->session->id_usuario,$id_caja, $id_cliente,$forma_pago);
            $this->temporal_compra = New TemporalCompraModel();
            if ($resultadoId) {
                $folio++;
                $this->cajas->update($this->session->id_caja,['folio'=>$folio]);
                $resultadoCompra = $this->temporal_compra->porCompra($id_venta);
                foreach ($resultadoCompra as $row) {
                    $this->detalle_venta->save([
                        'id_venta'=> $resultadoId,
                        'id_producto'=> $row['id_producto'],
                        'nombre'=> $row['nombre'],
                        'capacidad'=> $row['capacidad'],
                        'cantidad'=> $row['cantidad'],
                        'precio'=> $row['precio']
                    ]);
                    $this->productos->actualizaStock($row['id_producto'],$row['cantidad'],'-');
                }
            }
            $this->temporal_compra->eliminarCompra($id_venta);
            return redirect()->to(base_url()."/ventas/muestraTicket/".$resultadoId);
        }
    }

    function muestraTicket($id_venta)
    {    if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Caja','cajaventa');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Ventas','venta'); 
        echo view('header');
        if (!$permiso1 && !$permiso2) { echo view('roles/sinpermiso');}
        else {
            $data['id_venta'] = $id_venta;
            echo view('ventas/ver_ticket',$data);
        }
        echo view('footer');
    }

    function generaTicket($id_venta)
    {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Caja','cajaventa');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Ventas','venta');
        if (!$permiso1 && !$permiso2) {   echo view('header'); echo view('roles/sinpermiso');echo view('footer');}
        else {
            $datosVenta = $this->ventas->where('id',$id_venta)->first();
            $detalleVenta = $this->detalle_venta->select('*')->where('id_venta',$id_venta)->findAll();
            $nombreTienda = $this->configuracion->select('valor')->where('nombre','tienda_nombre')->get()->getRow()->valor;
            $direccionTienda = $this->configuracion->select('valor')->where('nombre','tienda_direccion')->get()->getRow()->valor;
            $leyendaTicket = $this->configuracion->select('valor')->where('nombre','ticket_leyenda')->get()->getRow()->valor;

            $pdf = new \FPDF('P','mm',array(80,200));
            $pdf->AddPage();
            $pdf->SetMargins(5,5,5);
            $pdf->SetTitle("Venta");
            $pdf->SetFont('Arial','B',11);
            $pdf->image(base_url().'/images/logotipo.png',5,4,9,8,'PNG');
            $pdf->Cell(70,4,'',0,1,'C');
            $pdf->Cell(70,4,'Restaurante "'.$nombreTienda.'"',0,1,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(70,5,'----------------------------------------------------------------',0,1,'C');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(17,5,utf8_decode('Dirección: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$direccionTienda,0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(22,5,utf8_decode('Fecha y hora: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$datosVenta['fecha_alta'],0,1,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(12,5,utf8_decode('Ticket: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$datosVenta['folio'],0,1,'L');
            $pdf->Cell(70,2,'',0,1,'C');
            $pdf->SetFont('Arial','',9); 
            $pdf->Cell(70,1,'-----------------------------------------------------------------',0,1,'C');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(8,5,'Cant.',0,0,'L');
            $pdf->Cell(20,5,'Nombre',0,0,'L');
            $pdf->Cell(15,5,utf8_decode('Descrip.'),0,0,'L');
            $pdf->Cell(12,5,'Precio',0,0,'L');
            $pdf->Cell(15,5,'Subtotal',0,1,'L');
            $pdf->SetFont('Arial','',9);  
            $pdf->Cell(70,1,'-----------------------------------------------------------------',0,1,'C');
            $pdf->SetFont('Arial','',7);
            $contador = 1;
            foreach ($detalleVenta as $row){
                $pdf->Cell(8,5,$row['cantidad'],0,0,'L');
                $pdf->Cell(20,5,utf8_decode($row['nombre']),0,0,'L');
                $pdf->Cell(15,5,utf8_decode($row['capacidad']),0,0,'L');
                $pdf->Cell(12,5,$row['precio'],0,0,'L');
                $importe = number_format($row['precio'] * $row['cantidad'],2,'.',',');
                $pdf->Cell(15,5,$importe,0,1,'L');
                $contador++;
            }
            $pdf->SetFont('Arial','',9);  
            $pdf->Cell(70,1,'-----------------------------------------------------------------',0,1,'C');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(55,5,utf8_decode('Total: '),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(15,5,number_format($datosVenta['total'],2,'.',',').' Bs.',0,1,'L');
            $pdf->SetFont('Arial','',9); 
            $pdf->Cell(70,1,'-----------------------------------------------------------------',0,1,'C');
            $pdf->SetFont('Arial','',8);
            $pdf->MultiCell(70,15,$leyendaTicket,0,'C',0);
            $this->response->setHeader('Content-Type','application/pdf');
            $pdf->Output("ticket.pdf","I");
        }
    }

    public function eliminar($id)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}    
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Ventas','venta');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','venta');
        if (!$permiso1 || !$permiso2) {echo view('header'); echo view('roles/sinpermiso');echo view('footer');}
        else {
            $productos = $this->detalle_venta->where('id_venta',$id)->findAll();
            foreach ($productos as $producto){
            $this->productos->actualizaStock($producto['id_producto'], $producto['cantidad'],'+');
            }
            $this->ventas->update($id, ['activo' => 0]);
            return redirect()->to(base_url().'/ventas');
        }
    }

}
