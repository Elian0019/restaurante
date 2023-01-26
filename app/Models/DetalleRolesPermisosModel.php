<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class DetalleRolesPermisosModel extends Model
   {
      protected $table      = 'detalle_roles_permisos';
      protected $primaryKey = 'id';
      protected $returnType     = 'array';
      protected $useSoftDeletes = false;
      protected $useAutoIncrement = true;
      protected $allowedFields = ['id_rol', 'id_permiso'];
      protected $useTimestamps = true;
      protected $createdField  = '';
      protected $updatedField  = '';
      protected $deletedField  = '';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation = false;

      public function verificaPermisos($idRol,$permiso,$submodulo){
         $tieneAcceso = false;
         $this->select('*');
         $this->join('permisos','detalle_roles_permisos.id_permiso = permisos.id');
         $existe = $this->where(['id_rol' => $idRol, 'permisos.nombre' => $permiso,'permisos.submodulo'=>$submodulo])->first();
         if ($existe != null) {
            $tieneAcceso = true;
         }
         return $tieneAcceso;
      }
   }
?>