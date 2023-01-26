<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class VentasModel extends Model
   {
      protected $table = 'ventas';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $returnType = 'array';
      protected $useSoftDeletes = false;
      protected $allowedFields = ['folio','total','id_usuario','id_caja','id_cliente','forma_pago','activo'];
      protected $useTimestamps = true;
      protected $createdField  = 'fecha_alta';
      protected $updatedField  = '';  
      protected $deletedField  = '';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation = false;

      public function insertaVenta($id_venta,$total,$id_usuario,$id_cajas,$id_cliente,$forma_pago){
         $this->insert([
            'folio'=>$id_venta,
            'total'=>$total,
            'id_usuario'=> $id_usuario,
            'id_caja' => $id_cajas,
            'id_cliente' => $id_cliente,
            'forma_pago' => $forma_pago
         ]);
         return $this->insertID();
      }

      public function obtener($activo=1){
         $this->select('ventas.*,u.usuario AS cajero, c.nombre AS cliente');
         $this->join('usuarios AS u','ventas.id_usuario = u.id');
         $this->join('clientes AS c','ventas.id_cliente = c.id');
         $this->where('ventas.activo',$activo);
         $this->orderBy('ventas.fecha_alta','DESC');
         $datos = $this->findAll();
         return $datos;
      }

      public function totalDia($fecha){
         $this->select("sum(total) AS total");
         $where = "activo = 1 AND DATE(fecha_alta)='$fecha'";
         return $this->where($where)->first();
      }

      public function rangoFechas($fechainicio,$fechafin,$id_caja){ 
         $this->select('ventas.*,u.usuario AS cajero, c.nombre AS cliente');
         $this->join('usuarios AS u','ventas.id_usuario = u.id');
         $this->join('clientes AS c','ventas.id_cliente = c.id');
         if ($id_caja==0) {
            $where = " DATE(ventas.fecha_alta) BETWEEN '$fechainicio' AND '$fechafin' AND ventas.activo = 1 ";
         }else {
            $where = " DATE(ventas.fecha_alta) BETWEEN '$fechainicio' AND '$fechafin' AND ventas.id_caja = '$id_caja' AND ventas.activo = 1 ";
         }
         $this->where($where); 
         $this->orderBy('ventas.fecha_alta','DESC');
         $datos = $this->findAll();
         return $datos;
      }

      public function ventas_del_dia($fechahoy){
         $this->select('ventas.*,u.usuario AS cajero, c.nombre AS cliente');
         $this->join('usuarios AS u','ventas.id_usuario = u.id');
         $this->join('clientes AS c','ventas.id_cliente = c.id');
         $where = " DATE(ventas.fecha_alta) = '$fechahoy'  AND ventas.activo = 1 ";
         $this->where($where); 
         $this->orderBy('ventas.fecha_alta','DESC');
         $datos = $this->findAll();
         return $datos;
      }

      public function ventas_del_mes($mesActual){
         $this->select('ventas.*,u.usuario AS cajero, c.nombre AS cliente');
         $this->join('usuarios AS u','ventas.id_usuario = u.id');
         $this->join('clientes AS c','ventas.id_cliente = c.id');
         $where = "MONTH(ventas.fecha_alta) = '$mesActual'  AND ventas.activo = 1 ";
         $this->where($where); 
         $this->orderBy('ventas.fecha_alta','DESC');
         $datos = $this->findAll();
         return $datos;
      }

      public function totalxmes($anioActual){
         $this->select('MONTHNAME(ventas.fecha_alta) AS mes, SUM(ventas.total) AS total');
         $where = "YEAR(ventas.fecha_alta)='$anioActual' AND ventas.activo = 1";
         $this->where($where); 
         $this->groupby('mes');
         $this->orderBy('MONTHNAME(ventas.fecha_alta)','DESC');
         $datos = $this->findAll();
         return $datos;
      }

      public function productos_mas_vendidos($mes,$anio){
         $this->select('COUNT(dv.id_producto) AS cant_ventas,dv.id_producto,SUM(dv.cantidad) AS cantidad,p.nombre,p.capacidad');
         $this->join('detalle_venta AS dv','ventas.id = dv.id_venta ');
         $this->join('productos AS p','p.id=dv.id_producto');
         $where = "MONTH(ventas.fecha_alta)='$mes' AND YEAR(ventas.fecha_alta) ='$anio' AND ventas.activo = 1";
         $this->where($where); 
         $this->groupby('dv.id_producto,p.nombre,p.capacidad');
         $this->orderBy('SUM(dv.cantidad)','DESC');
         $datos = $this->findAll(10);
         return $datos;
      }

   } 
?>

