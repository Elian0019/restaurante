<?php 
   namespace App\models;
   use CodeIgniter\Model;

   class ConfiguracionModel extends Model
   {
      protected $table = 'configuracion';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $returnType = 'array';
      protected $useSoftDeletes = false;
      protected $useSoftUpdated = false;  
      protected $useSoftCreates = false; 
      protected $allowedFields = ['nombre', 'valor'];
      protected $useTimestamps = true;
      protected $createdField  = null;
      protected $updatedField  = null;
      protected $deletedField  = 'deleted_at';
      protected $validationRules    = [];
      protected $validationMessages = [];
      protected $skipValidation     = false;
   }
?>