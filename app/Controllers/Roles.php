<?php 
    namespace App\Controllers;
    use App\Controllers\BaseController;

    use App\Models\RolesModel;
    use App\Models\PermisosModel;
    use App\Models\DetalleRolesPermisosModel;

    class Roles extends BaseController
    {
        protected $roles, $permisos, $detalleRoles,$session;
        protected $reglas;

        public function __construct()
        {
            $this->roles = New RolesModel();
            $this->permisos = New PermisosModel();
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
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            echo view('header');
            if (!$permiso) {
                echo view('roles/sinpermiso');
            }else {
                $roles = $this->roles->where('activo',$activo)->findAll();
                $permiso_new = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','rol');
                $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','rol');
                $permiso_asig_permi = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Permisos','rol');
                $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','rol');
                $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','rol');
                if (!$permiso_new) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = null;}
                if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = null;}
                if (!$permiso_asig_permi) { $btn_asig_permiso =' visually-hidden';} else { $btn_asig_permiso = null;}
                if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = null;}
                if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = null;}
                $data = [
                    'titulo' => 'Roles',
                    'datos' => $roles,
                    'btn_agregar' => $btn_agregar,
                    'btn_eliminados' => $btn_eliminados,
                    'btn_asig_permiso' => $btn_asig_permiso,
                    'btn_editar' => $btn_editar,
                    'btn_eliminar' => $btn_eliminar
                ];
                echo view('roles/roles', $data);
            }
            echo view('footer');
        }

        public function eliminados($activo = 0)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','rol');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $roles = $this->roles->where('activo',$activo)->findAll();
                $data = ['titulo' => 'Roles eliminados','datos' => $roles];
                echo view('roles/eliminados', $data);
            }
            echo view('footer');
        }

        public function nuevo()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','rol');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $data = ['titulo' => 'Agregar Roles'];
                echo view('roles/nuevo', $data);
            }
            echo view('footer');
        }

        public function insertar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','rol');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas))
                {
                    $this->roles->save(['nombre'=>$this->request->getPost('nombre')]);
                    return redirect()->to(base_url().'/roles');
                }else {
                    $data = ['titulo' => 'Agregar roles','validation'=>$this->validator];
                    echo view('roles/nuevo', $data);
                }
            }
            echo view('footer');
        }

        public function editar($id, $valid=null)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','rol');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $rol = $this->roles->where('id',$id)->first();
                if($valid != null){
                    $data = ['titulo' => 'Editar rol','datos'=>$rol,'validation'=>$valid];
                }else {
                    $data = ['titulo' => 'Editar rol','datos'=>$rol];
                }
                echo view('roles/editar', $data);
            }
            echo view('footer');
        }
        public function actualizar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','rol');
            if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso');echo view('footer');}
            else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas)){
                    $this->roles->update($this->request->getPost('id'),[
                        'nombre'=>$this->request->getPost('nombre')]);
                    return redirect()->to(base_url().'/roles');
                }else {
                    return $this->editar($this->request->getPost('id'),$this->validator);
                }
            }
        }

        public function eliminar($id)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','rol');
            if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso');echo view('footer');}
            else {
                $this->roles->update($id,['activo'=> 0]);
                return redirect()->to(base_url().'/roles');
            }
        }

        public function reingresar($id)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','rol');
            if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso');echo view('footer');}
            else {
                $this->roles->update($id,['activo'=> 1]);
                return redirect()->to(base_url().'/roles');
            }
        }

        public function detalles($idRol)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Permisos','rol');
            echo view('header');
            if (!$permiso1 || !$permiso2) {echo view('roles/sinpermiso');}
            else {
                $permisos= $this->permisos->findAll();
                $permisosAsignados = $this->detalleRoles->where('id_rol',$idRol)->findAll();
                $datos = array();
                foreach ($permisosAsignados as $permisoAsignado){
                    $datos[$permisoAsignado['id_permiso']]=true;
                }
                $data = ['titulo' => 'Asignar permisos', 'permisos' => $permisos, 'id_rol'=>$idRol, 'asignado'=>$datos];
                echo view('roles/detalles',$data);
            }
            echo view('footer');
        }

        public function guardaPermisos()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Roles','rol');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Permisos','rol');
            if (!$permiso1 || !$permiso2) {  echo view('header');echo view('roles/sinpermiso');  echo view('footer');}
            else {
                if($this->request->getMethod()=="post"){
                    $idRol = $this->request->getPost('id_rol');
                    $permisos = $this->request->getPost('permisos');
                    $this->detalleRoles->where('id_rol',$idRol)->delete();
                    if($permisos != null){
                        foreach ($permisos as $permiso) {
                            $this->detalleRoles->save(['id_rol' => $idRol,'id_permiso' =>$permiso]);
                        }
                        return redirect()->to(base_url()."/roles");
                    }else {
                        return redirect()->to(base_url()."/inicio");
                    }
                }
            }
        }

    }
