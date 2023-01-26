<?php 
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ConfiguracionModel;
    use App\Models\DetalleRolesPermisosModel;

    class Configuracion extends BaseController
    {
        protected $configuracion,$detalleRoles,$session;
        protected $reglas;
        public function __construct()
        {
            $this->configuracion = New ConfiguracionModel();
            $this->detalleRoles = New DetalleRolesPermisosModel();
            $this->session = Session();
            helper(['form','upload']);

            $this->reglas = [
                'tienda_nombre'=> [
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'tienda_rfc'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'tienda_telefono'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'tienda_email'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'tienda_direccion'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'ticket_leyenda'=>[
                    'rules' =>'required',
                    'errors'=>[
                        'required'=>'El campo {field} es obligatorio.'
                    ]
                ],
                'tienda_logo'=>[
                    'rules' =>'is_image[tienda_logo]|max_size[tienda_logo,4096]|ext_in[tienda_logo,png]',
                    'errors'=>[
                        'is_image'=>'La {field} no es un archivo de imagen',              
                        'max_size'=>'La {field}  supera el limite de 2 Megasbyte',
                        'ext_in'=>'La {field} debe ser formato .png',
                    ]
                ]

            ];
    
        }

        public function index($activo = 1,$valid=null)
        {   
            if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Configuracion','administracion');
            echo view('header');
            if (!$permiso) {
                echo view('roles/sinpermiso');
            }else {
                $nombre= $this->configuracion->where('nombre','tienda_nombre')->first();
                $rfc= $this->configuracion->where('nombre','tienda_rfc')->first();
                $telefono= $this->configuracion->where('nombre','tienda_telefono')->first();
                $email= $this->configuracion->where('nombre','tienda_email')->first();
                $direccion= $this->configuracion->where('nombre','tienda_direccion')->first();
                $leyenda= $this->configuracion->where('nombre','ticket_leyenda')->first();

                if($valid != null){
                    $data = ['titulo' => 'Configuración','nombre'=>$nombre,'rfc'=>$rfc,'telefono'=>$telefono,'email'=>$email,'direccion'=>$direccion,'leyenda'=>$leyenda,'validation'=>$valid];
                }else {
                    $data = ['titulo' => 'Configuración','nombre'=>$nombre,'rfc'=>$rfc,'telefono'=>$telefono,'email'=>$email,'direccion'=>$direccion,'leyenda'=>$leyenda];
                }    
                echo view('configuracion/configuracion',$data);
            }
            echo view('footer');
        }

        public function actualizar()
        {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());} 	
            $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Configuracion','administracion');
            if (!$permiso) {
                echo view('header');echo view('roles/sinpermiso');echo view('footer');
            }else {
                if($this->request->getMethod()=="post" && $this->validate($this->reglas)){
                $this->configuracion->whereIn('nombre',['tienda_nombre'])->set(['valor'=>$this->request->getPost('tienda_nombre')])->update();
                $this->configuracion->whereIn('nombre',['tienda_rfc'])->set(['valor'=>$this->request->getPost('tienda_rfc')])->update();
                $this->configuracion->whereIn('nombre',['tienda_telefono'])->set(['valor'=>$this->request->getPost('tienda_telefono')])->update();
                $this->configuracion->whereIn('nombre',['tienda_email'])->set(['valor'=>$this->request->getPost('tienda_email')])->update();
                $this->configuracion->whereIn('nombre',['tienda_direccion'])->set(['valor'=>$this->request->getPost('tienda_direccion')])->update();
                $this->configuracion->whereIn('nombre',['ticket_leyenda'])->set(['valor'=>$this->request->getPost('ticket_leyenda')])->update();

                $validacion = $this->validate([
                    'tienda_logo'=> [
                        'uploaded[tienda_logo]',
                        'mime_in[tienda_logo,image/png]',
                        'max_size[tienda_logo, 4096]'
                    ]
                ]);

                if ($validacion) {
                    $ruta_logo = "images/logotipo.png";

                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }
                    $img = $this->request->getFile('tienda_logo');
                    $img->move('./images','logotipo.png');
                }
                    return redirect()->to(base_url().'/configuracion');
                }else {
                    return $this->index($this->request->getPost('id'),$this->validator); 
                }
            }
        }

    }
