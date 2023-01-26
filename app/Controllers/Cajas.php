<?php
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CajasModel;
    use App\Models\DetalleRolesPermisosModel;
    class Cajas extends BaseController
    {
        protected $cajas,$detalleRoles,$session;
        protected $reglas;
        public function __construct()
        {
            $this->cajas = New CajasModel();
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->session = Session();
            helper(['form']);
          
            $this->reglas = [
                'numero_caja'=> [
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                        ]
                ],
                'nombre'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'folio'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ]
            ];
        }

        public function index($activo = 1)
        {  
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $cajas = $this->cajas->where('activo',$activo)->findAll();
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');
            echo view('header');
            if (!$permiso) {
                echo view('roles/sinpermiso');
            }else {
                $permiso_new = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','caja');
                $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminadas','caja');
                $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','caja');
                $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','caja');

                if (!$permiso_new) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = '';}
                if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = '';}
                if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = '';}
                if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = '';}
                $data = [
                    'titulo' => 'Cajas',
                    'datos' => $cajas,
                    'btn_agregar' => $btn_agregar,
                    'btn_eliminados' => $btn_eliminados,
                    'btn_editar' => $btn_editar,
                    'btn_eliminar' => $btn_eliminar
                ];
                echo view('cajas/cajas', $data);
            }
            echo view('footer');
        }

        public function eliminados($activo = 0)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminadas','caja');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $cajas = $this->cajas->where('activo',$activo)->findAll();
                $data = ['titulo' => 'Cajas eliminadas','datos' => $cajas];
                echo view('cajas/eliminados', $data);
            }
            echo view('footer');
        }
        public function nuevo()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','caja');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $data = ['titulo' => 'Agregar caja'];
                echo view('cajas/nuevo', $data);
            }
            echo view('footer');
        }
        public function insertar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','caja');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                if($this->request->getMethod() =="post" && $this->validate($this->reglas))
                {   $this->cajas->save([
                        'numero_caja'=>$this->request->getPost('numero_caja'),
                        'nombre'=>$this->request->getPost('nombre'),
                        'folio'=>$this->request->getPost('folio')]);
                    return redirect()->to(base_url().'/cajas');
                }else {
                    $data = ['titulo' => 'Agregar caja','validation'=>$this->validator];
                    echo view('cajas/nuevo', $data);
                }
            }
            echo view('footer');
        }

        public function editar($id, $valid=null)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','caja');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $caja = $this->cajas->where('id',$id)->first();
                if($valid != null){
                    $data = ['titulo' => 'Editar caja',"caja"=>$caja,'validation'=>$valid];
                }else {
                    $data = ['titulo' => 'Editar caja',"caja"=>$caja];
                }
                echo view('cajas/editar', $data);
            }
            echo view('footer');
        }
        public function actualizar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','caja');        
            if (!$permiso1 || !$permiso2) {echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
            else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas)){
                $this->cajas->update($this->request->getPost('id'),[
                    'numero_caja'=>$this->request->getPost('numero_caja'),
                    'nombre'=>$this->request->getPost('nombre'),
                    'folio'=>$this->request->getPost('folio')]);
                return redirect()->to(base_url().'/cajas');
                }else {
                    return $this->editar($this->request->getPost('id'),$this->validator); 
                }
            }
        }
    
        public function eliminar($id)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','caja');
            if (!$permiso1 || !$permiso2) {echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
            else {
                $this->cajas->update($id,['activo'=> 0]);
                return redirect()->to(base_url().'/cajas');
            }
        }

        public function reingresar($id)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Cajas','caja');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminadas','caja');
            if (!$permiso1 || !$permiso2) {echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
            else {
                $this->cajas->update($id,['activo'=> 1]);
                return redirect()->to(base_url().'/cajas');
            }
        }
    }
