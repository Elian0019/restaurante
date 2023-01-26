<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\ProductosModel;
    use App\Models\CategoriasModel;
    use App\Models\DetalleRolesPermisosModel;
    use App\Models\UsuariosModel;

    class Productos extends BaseController
    {
        protected $productos, $detalleRoles, $session,$usuarios,$control;
        protected $reglas,$reglasEdit;

        public function __construct()
        {
            $this->productos = New ProductosModel();
            $this->categorias = New CategoriasModel();
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->usuarios = New UsuariosModel();
            $this->session = Session();
            helper(['form','upload']);

            $this->reglas = [
                'codigo'=> [
                    'rules' =>'required|is_unique[productos.codigo]',
                   
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.',
                         'is_unique'=>'El campo {field} debe ser unico.',
                        ]
                ],
                'nombre'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'capacidad'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'Seleccione una capacidad.'
                    ]
                ],
                'id_categoria'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'Seleccione una categoria.'
                    ]
                ],
                'precio_venta'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'precio_compra'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'stock_minimo'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'img_producto'=>[
                    'rules' =>'uploaded[img_producto]|is_image[img_producto]|max_size[img_producto,4096]|ext_in[img_producto,jpg,jpeg]',
                    'errors'=>[
                        'uploaded'=>'El campo {field} es obligatorio.',
                        'is_image'=>'La {field} no es un archivo de imagen',
                        'max_size'=>'La {field}  supera el limite de 4 Megasbyte',
                        'ext_in'=>'La {field} debe ser formato .jpg',
                    ]
                ]

            ];

            $this->reglasEdit= [
                'codigo'=> [               
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.',
                    ]
                ],
                'nombre'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'capacidad'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'Seleccione una Capacidad.'
                    ]
                ],
                'id_categoria'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'Seleccione una categoria.'
                    ]
                ],
                'precio_venta'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'precio_compra'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'stock_minimo'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'img_producto'=>[
                    'rules' =>'is_image[img_producto]|max_size[img_producto,4096]|ext_in[img_producto,jpg,jpeg]',
                    'errors'=>[
                        'is_image'=>'La {field} no es un archivo de imagen',
                        'max_size'=>'La {field}  supera el limite de 4 Megasbyte',
                        'ext_in'=>'La {field} debe ser formato .jpg'
                    ]
                ]

            ];
        }
        public function index($activo = 1)
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
           $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
           echo view('header');
           if (!$permiso) {       
            echo view('roles/sinpermiso');
           }else {
            $productos = $this->productos->where('activo',$activo)->findAll();
            $permiso_pn = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','producto');
            $permiso_pe = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','producto');
            $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','producto');
            $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','producto');
            if (!$permiso_pn) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = '';}
            if (!$permiso_pe) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = '';}
            if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = '';}
            if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = '';}
            $data = [
                'titulo' => 'Productos',
                'datos' => $productos,
                'btn_agregar' => $btn_agregar,
                'btn_eliminados' => $btn_eliminados,
                'btn_editar' => $btn_editar,
                'btn_eliminar' => $btn_eliminar
            ];
            echo view('productos/productos',$data );
            }
            echo view('footer');
        }

        public function eliminados($activo = 0)
        {    if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','producto');
            echo view('header'); 
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $productos = $this->productos->where('activo',$activo)->findAll();
                $data = ['titulo' => 'Productos eliminados','datos' => $productos];
            echo view('productos/eliminados', $data);          
            }
            echo view('footer');
        }

        public function nuevo()
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','producto');
             echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $categorias = $this->categorias->where('activo',1)->findAll();
                $data = ['titulo' => 'Agregar producto','categorias'=>$categorias];
            echo view('productos/nuevo', $data);
            }
            echo view('footer');
        }

        public function insertar()
        {
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','producto');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                if($this->request->getMethod() =="post" && $this->validate($this->reglas))
                {
                    $this->productos->save([
                        'codigo'=>$this->request->getPost('codigo'),
                        'nombre'=>$this->request->getPost('nombre'),
                        'capacidad'=>$this->request->getPost('capacidad'),
                        'id_categoria'=>$this->request->getPost('id_categoria'),
                        'precio_venta'=>$this->request->getPost('precio_venta'),
                        'precio_compra'=>$this->request->getPost('precio_compra'),
                        'stock_minimo'=>$this->request->getPost('stock_minimo'),
                        'inventariable'=>$this->request->getPost('inventariable')]);
                    $id = $this->productos->insertID();
                    $validacion = $this->validate([
                            'img_producto'=> [
                            'uploaded[img_producto]',
                            'mime_in[img_producto,image/jpg,image/jpeg]',
                            'max_size[img_producto, 4096]'
                        ]
                    ]) ;

                    if ($validacion) {
                        $ruta_logo = "images/productos/".$id.".jpg";
                        if (file_exists($ruta_logo)) {
                            unlink($ruta_logo);
                        }
                        $img = $this->request->getFile('img_producto');
                        $img->move('./images/productos/',$id.'.jpg');
                    }else {}
                return redirect()->to(base_url().'/productos');
                }else{
                    $categorias = $this->categorias->where('activo',1)->findAll();
                    $data = ['titulo' => 'Agregar producto','categorias'=>$categorias,'validation'=>$this->validator];
                    echo view('productos/nuevo', $data);
                }
            }
            echo view('footer');
        }

        public function editar($id, $valid=null)
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','producto');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
            else {
                $categorias = $this->categorias->where('activo',1)->findAll();
                $producto = $this->productos->where('id',$id)->first();
                if($valid != null){
                    $data = ['titulo' => 'Editar producto','categorias'=>$categorias,"producto"=>$producto,'validation'=>$valid];
                }else {
                    $data = ['titulo' => 'Editar producto','categorias'=>$categorias,"producto"=>$producto];
                }
            echo view('productos/editar', $data);
            }
            echo view('footer');
        }

        public function actualizar()
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            if($this->request->getMethod()=="post"  && $this->validate($this->reglasEdit)){

            $this->productos->update($this->request->getPost('id'),[
                'codigo'=>$this->request->getPost('codigo'),
                'nombre'=>$this->request->getPost('nombre'),
                'capacidad'=>$this->request->getPost('capacidad'),
                'id_categoria'=>$this->request->getPost('id_categoria'),
                'precio_venta'=>$this->request->getPost('precio_venta'),
                'precio_compra'=>$this->request->getPost('precio_compra'),
                'stock_minimo'=>$this->request->getPost('stock_minimo'),
                'inventariable'=>$this->request->getPost('inventariable')]);

                $id = $this->request->getPost('id');
                $validacion = $this->validate([
                    'img_producto'=> [
                        'uploaded[img_producto]',
                        'mime_in[img_producto,image/jpg,image/jpeg]',
                        'max_size[img_producto, 4096]'
                ]
                ]);
                
                if ($validacion) {
                    $ruta_logo = "images/productos/".$id.".jpg";
                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }
                    $img = $this->request->getFile('img_producto');
                    $img->move('./images/productos/',$id.'.jpg');
                }
            return redirect()->to(base_url().'/productos');
            }else {
                return $this->editar($this->request->getPost('id'),$this->validator);
            }
        }

        public function eliminar($id)
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','producto');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
            else {
                $this->productos->update($id,['activo'=> 0]);
                return redirect()->to(base_url().'/productos');
            }
        }
   
        public function reingresar($id)
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}	
            $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Productos','producto');
            $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','producto');
            echo view('header');
            if (!$permiso1 || !$permiso2) { echo view('header'); echo view('roles/sinpermiso'); echo view('footer');}
            else {
           $this->productos->update($id,['activo'=> 1]);
            return redirect()->to(base_url().'/productos');
            }
        }

        public function buscarPorCodigo($codigo)
        {  if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
           $this->productos->select('*');
           $this->productos->where('codigo',$codigo);
           $this->productos->where('activo',1);
           $datos= $this->productos->get()->getRow();
           $res['existe'] = false;
           $res['datos']= '';
           $res['error']= '';
           if ($datos) {
                $res['datos']=$datos;
                $res['existe']= true;
           }else {
                $res['error']='No existe el producto';
                $res['existe']= false;
           }
           echo json_encode($res);
        }

        public function autocompleteData(){
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $returnData = $arrayName = array();
            $valor = $this->request->getGet('term');
            $productos = $this->productos->like('nombre',$valor)->where('activo',1)->findAll();
            if(!empty($productos)){
                foreach ($productos as $row) {
                    $data['id'] = $row['id'];
                    $data['value'] = $row['nombre'];
                    $data['label'] = $row['nombre'].' - '.$row['capacidad'];
                    array_push($returnData,$data);
                }
            }
           echo json_encode($returnData);
        }

        public function calcular_c_subtotal($codigo){
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 
            $this->productos->select('*');
            $this->productos->where('codigo',$codigo);
            $this->productos->select('activo',1);
            $datos=  $this->productos->get()->getRow();
            $res['existe'] = false;
            $res['datos'] = '';
            $res['error'] = '';
            if($datos){
               $res['datos'] = $datos;
               $res['existe']= true;
            }else {
              $res['error']= 'no existe el producto';
              $res['existe'] = false;
            }
            echo json_encode($res);
        }

    }
