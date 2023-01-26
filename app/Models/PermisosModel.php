<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class PermisosModel extends Model
   {
      protected $table      = 'permisos';
      protected $primaryKey = 'id';
      protected $returnType     = 'array';
      protected $useSoftDeletes = false;
      protected $useAutoIncrement = true;
      protected $allowedFields = ['nombre', 'tipo','submodulo'];
      protected $useTimestamps = true;
      protected $createdField  = '';
      protected $updatedField  = '';
      protected $deletedField  = '';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation     = false;
   }
?>