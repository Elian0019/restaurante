<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class RolesModel extends Model
   {
      protected $table      = 'roles';
      protected $primaryKey = 'id';
      protected $returnType     = 'array';
      protected $useSoftDeletes = false;
      protected $useAutoIncrement = true;
      protected $allowedFields = ['nombre', 'activo'];
      protected $useTimestamps = true;
      protected $createdField  = 'fecha_alta';
      protected $updatedField  = 'fecha_modifica';
      protected $deletedField  = 'deleted_at';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation     = false;
   }
?>