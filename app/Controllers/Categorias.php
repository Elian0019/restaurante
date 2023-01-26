<?php 
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CategoriasModel;
    use App\Models\DetalleRolesPermisosModel;
    
    class Categorias extends BaseController
    {
        protected $categorias, $detalleRoles,$session;
        protected $reglas;

        public function __construct()
        {
            $this->categorias = New CategoriasModel();
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->session = Session();
            helper(['form']);

            $this->reglas = [
                'nombre'=> [
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
            ];


        }

        public function index($activo = 1)
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $categorias = $this->categorias->where('activo',$activo)->findAll();
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            echo view('header');
            if (!$permiso ) {            
            echo view('roles/sinpermiso'); 
            }else {
                $permiso_new = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','categoria');
                $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','categoria');
                $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','categoria');
                $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','categoria');
                if (!$permiso_new) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = '';}
                if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = '';}
                if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = '';}
                if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = '';}
                $data = [
                    'titulo' => 'Categorías',
                    'datos' => $categorias,
                    'btn_agregar' => $btn_agregar,
                    'btn_eliminados' => $btn_eliminados,
                    'btn_editar' => $btn_editar,
                    'btn_eliminar' => $btn_eliminar
                ];
            echo view('categorias/categorias', $data);
            }
            echo view('footer');
        }

        public function eliminados($activo = 0)
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','categoria');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
            $categorias = $this->categorias->where('activo',$activo)->findAll();
            $data = ['titulo' => 'Categorías eliminadas','datos' => $categorias];
            echo view('categorias/eliminados', $data);
            }
            echo view('footer');
        }
       
        public function nuevo()
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','categoria');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
            $data = ['titulo' => 'Agregar Categoría'];
            echo view('categorias/nuevo', $data);
            }
            echo view('footer');
        }

        public function insertar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','categoria');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas))
                {
                    $this->categorias->save(['nombre'=>$this->request->getPost('nombre')]);
                    return redirect()->to(base_url().'/categorias');
                }else {
                    $data = ['titulo' => 'Agregar Categoría','validation'=>$this->validator];       
                    echo view('categorias/nuevo', $data);
                }
            }
            echo view('footer');
        }

        public function editar($id,$valid=null)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','categoria');
            echo view('header');  
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
            $unidad = $this->categorias->where('id',$id)->first();
                if($valid != null){$data = ['titulo' => 'Editar categoría','datos'=>$unidad,'validation'=>$valid];}
                else{ $data = ['titulo' => 'Editar categoría','datos'=>$unidad];}
            echo view('categorias/editar', $data);      
            }
            echo view('footer');
        }

        public function actualizar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','categoria');
            if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso');echo view('footer');}
            else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas)){
                    $this->categorias->update($this->request->getPost('id'),['nombre'=>$this->request->getPost('nombre')]);
                    return redirect()->to(base_url().'/categorias');
                }else {
                    return $this->editar($this->request->getPost('id'),$this->validator);
                }
            }
        }

        public function eliminar($id)
        {  if (!isset($this->session->id_usuario)){return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','categoria');
            if (!$permiso1 || !$permiso2) {echo view('header');  echo view('roles/sinpermiso'); echo view('footer');}
            else {
                $this->categorias->update($id,['activo'=> 0]);
                return redirect()->to(base_url().'/categorias');
            }
        }
   
        public function reingresar($id)
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Categorias','categoria');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','categoria');
            if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso');echo view('footer');}
            else {
                $this->categorias->update($id,['activo'=> 1]);
                return redirect()->to(base_url().'/categorias');
            }
        }

    }
