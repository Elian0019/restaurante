<?php
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ClientesModel;
    use App\Models\DetalleRolesPermisosModel;

    class Clientes extends BaseController
    {
        protected $clientes,$detalleRoles,$session;
        protected $reglas;

        public function __construct()
        {
            $this->clientes = New ClientesModel();
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
                'direccion'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'telefono'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'correo'=>[
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
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');
            echo view('header');
            if (!$permiso) {
                echo view('roles/sinpermiso');
            }else {
            $clientes = $this->clientes->where('activo',$activo)->findAll();
            $permiso_new = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','cliente');
            $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','cliente');
            $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','cliente');
            $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','cliente');

            if (!$permiso_new) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = null;}
            if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = null;}
            if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = null;}
            if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = null;}

            $data = [
                'titulo' => 'Clientes',
                'datos' => $clientes,
                'btn_agregar' => $btn_agregar,
                'btn_eliminados' => $btn_eliminados,
                'btn_editar' => $btn_editar,
                'btn_eliminar' => $btn_eliminar
            ];       
            echo view('clientes/clientes', $data);
            }    
            echo view('footer');
        }

        public function eliminados($activo = 0)
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','cliente');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $clientes = $this->clientes->where('activo',$activo)->findAll();
                $data = ['titulo' => 'Clientes eliminados','datos' => $clientes];
            echo view('clientes/eliminados', $data);
            }
            echo view('footer');
        }

        public function nuevo()
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','cliente');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $data = ['titulo' => 'Agregar cliente'];
                echo view('clientes/nuevo', $data);
            }
            echo view('footer');
        }

        public function insertar()
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','cliente');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                if($this->request->getMethod() =="post" && $this->validate($this->reglas))
                {
                    $this->clientes->save([   
                        'nombre'=>$this->request->getPost('nombre'),
                        'direccion'=>$this->request->getPost('direccion'),
                        'telefono'=>$this->request->getPost('telefono'),
                        'correo'=>$this->request->getPost('correo')]);
                    return redirect()->to(base_url().'/clientes');
                }else {
                    $data = ['titulo' => 'Agregar cliente','validation'=>$this->validator];      
                    echo view('clientes/nuevo', $data);            
                }
            }
            echo view('footer');
        }

        public function editar($id, $valid=null)
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','cliente');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $cliente = $this->clientes->where('id',$id)->first();
                if($valid != null){
                    $data = ['titulo' => 'Editar cliente',"cliente"=>$cliente,'validation'=>$valid];
                }else {
                    $data = ['titulo' => 'Editar cliente',"cliente"=>$cliente];
                }
                echo view('clientes/editar', $data);
            }
            echo view('footer');
        }

        public function actualizar()
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            if($this->request->getMethod()=="post" && $this->validate($this->reglas)){

            $this->clientes->update($this->request->getPost('id'),[
                'nombre'=>$this->request->getPost('nombre'),
                'direccion'=>$this->request->getPost('direccion'),
                'telefono'=>$this->request->getPost('telefono'),
                'correo'=>$this->request->getPost('correo')]);

            return redirect()->to(base_url().'/clientes');
            }else {
                return $this->editar($this->request->getPost('id'),$this->validator); 
            }
        }
        public function eliminar($id)
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');   
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','cliente');
          
            if (!$permiso1 || !$permiso2) {  echo view('header'); echo view('roles/sinpermiso');echo view('footer');}
            else {
            $this->clientes->update($id,['activo'=> 0]);
                return redirect()->to(base_url().'/clientes');
            }
        }

        public function reingresar($id)
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Clientes','cliente');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','cliente');
          
            if (!$permiso1 || !$permiso2) {  echo view('header'); echo view('roles/sinpermiso');echo view('footer');}
            else {
            $this->clientes->update($id,['activo'=> 1]);
                return redirect()->to(base_url().'/clientes');
            }
        }

        public function autocompleteData()
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $returnData = $arrayName = array();
            $valor = $this->request->getGet('term');
            $clientes = $this->clientes->like('nombre',$valor)->where('activo',1)->findAll();
            if(!empty($clientes)){
                foreach ($clientes as $row) {
                    $data['id'] = $row['id'];
                    $data['value'] = $row['nombre'];
                    array_push($returnData,$data);
                }
            }
           echo json_encode($returnData);
        }

    }
