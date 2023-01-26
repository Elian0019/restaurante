<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class ProductosModel extends Model
   {
      protected $table  = 'productos';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $returnType  = 'array';
      protected $useSoftDeletes = false;
      protected $allowedFields = ['codigo','nombre','capacidad', 'precio_venta','precio_compra','existencias','stock_minimo','inventariable','id_categoria','activo'];
      protected $useTimestamps = true;
      protected $createdField  = 'fecha_alta';
      protected $updatedField  = '';
      protected $deletedField  = 'deleted_at';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation     = false;

      public function actualizaStock($id_producto, $cantidad, $operador='+')
      {
         $this->set('existencias',"existencias $operador $cantidad",FALSE);
         $this->where('id',$id_producto);
         $this->update();
      }

      public function totalProductos()
      {
         return $this->where('activo', 1)->countAllResults();
      }

      public function productosMinimo()
      {
      $where = "stock_minimo >= existencias AND inventariable=1 AND activo=1";
      $this->where($where);
      $sql = $this->countAllResults();
      return $sql;
      }

      public function getProductosMinimo()
      {
      $where = "stock_minimo >= existencias AND inventariable=1 AND activo=1";
      return $this->where($where)->findAll();
      }

      public function mostrarProductoCat($id_cat)
      {  
         $this->select('productos.*, c.nombre AS categoria');
         $this->join('categorias AS c','productos.id_categoria=c.id');
         if ($id_cat==0) {
            $where = "productos.activo=1 AND c.activo=1";
         }else {
            $where = "productos.activo=1 AND c.activo=1 AND c.id=$id_cat";
         }
         return $this->where($where)->findAll();
      }
   }
?>