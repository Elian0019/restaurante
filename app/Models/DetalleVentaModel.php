<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class DetalleVentaModel extends Model
   {
      protected $table      = 'detalle_venta';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $returnType     = 'array';
      protected $useSoftDeletes = false;
      protected $allowedFields = ['id_venta','id_producto', 'nombre','capacidad','cantidad','precio'];
      protected $useTimestamps = true;
      protected $createdField  = 'fecha_alta';
      protected $updatedField  = '';  
      protected $deletedField  = '';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation     = false;
      
      public function productos_mas_vendidos($mes,$anio){
         $this->select('COUNT(dv.id_producto) AS cant_ventas,dv.id_producto,SUM(dv.cantidad) AS cantidad,p.nombre,p.capacidad');
         $this->from('ventas');
         $this->join('detalle_venta AS dv','ventas.id = dv.id_venta ');
         $this->join('productos AS p','p.id=dv.id_producto');
         $where = "MONTH(ventas.fecha_alta)='$mes' AND YEAR(ventas.fecha_alta) ='$anio' AND ventas.activo = 1";
         $this->where($where);
         $this->groupby('dv.id_producto,p.nombre,p.capacidad');
         $this->orderBy('SUM(dv.cantidad)','DESC');
         $datos = $this->Limit(5);
         return $datos;
      }
   }
?>