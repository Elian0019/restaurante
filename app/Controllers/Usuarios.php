<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\UsuariosModel;
    use App\Models\CajasModel;
    use App\Models\RolesModel;
    use App\Models\DetalleRolesPermisosModel;

class Usuarios extends BaseController
{
    protected $usuarios, $cajas, $roles;
    protected $reglasm,$reglasLogin,$reglasCambia,$reglasEdit,$session,$detalleRoles;

    public function __construct()
    {
        $this->usuarios = New UsuariosModel();
        $this->cajas = New CajasModel();
        $this->roles = New RolesModel();
        $this->detalleRoles = New DetalleRolesPermisosModel();
        $this->session = session();
        helper(['form']);

        $this->reglas = [
            'usuario'=> [
                'rules' =>'required|is_unique[usuarios.usuario]',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.',
                    'is_unique'=>'El campo {field} debe ser unico.'
                ]
            ],
            'password'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ],
            'repassword'=>[
                'rules' =>'required|matches[password]',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.',
                    'matches'=>'Las contrañesas no coinciden.'
                ]
            ],
            'nombre'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                    
                ]
            ],
            'id_caja'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo Caja es obligatorio.'
                ]
            ],
            'id_rol'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo Rol es obligatorio.'
                ]
            ]
        ];

        $this->reglasLogin = [
            'usuario'=> [
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ],
            'password'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ]
        ];

        $this->reglasCambia = [
            'password'=> [
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                ]
            ],
            'repassword'=>[
                'rules' =>'required|matches[password]',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.',
                    'matches'=>'Las contrañesas no coinciden.'
                ]
            ],
        ];

        $this->reglasEdit = [
            'nombre'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo {field} es obligatorio.'
                    
                ]
            ],
            'id_caja'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo Caja es obligatorio.'
                ]
            ],
            'id_rol'=>[
                'rules' =>'required',
                'errors'=>[
                    'required'=>'El campo Rol es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        echo view('header');
        if (!$permiso) {
            echo view('roles/sinpermiso');
        }else {
            $usuarios = $this->usuarios->where('activo',$activo)->findAll();
            $permiso_new = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','usuario');
            $permiso_eliminados = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','usuario');
            $permiso_edit = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','usuario');
            $permiso_elim = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','usuario');
            if (!$permiso_new) { $btn_agregar =' visually-hidden-focusable';} else { $btn_agregar = '';}
            if (!$permiso_eliminados) { $btn_eliminados =' visually-hidden-focusable';}else { $btn_eliminados = '';}
            if (!$permiso_edit) { $btn_editar =' visually-hidden';} else { $btn_editar = '';}
            if (!$permiso_elim) { $btn_eliminar =' visually-hidden';}else { $btn_eliminar = '';}
            $data = [
                'titulo' => 'Usuarios',
                'datos' => $usuarios,
                'btn_agregar' => $btn_agregar,
                'btn_eliminados' => $btn_eliminados,
                'btn_editar' => $btn_editar,
                'btn_eliminar' => $btn_eliminar
            ];       
            echo view('usuarios/usuarios', $data);
        }
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','usuario');
        echo view('header');
        if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
        else {
            $usuarios = $this->usuarios->where('activo',$activo)->findAll();
            $data = ['titulo' => 'Usuarios eliminados','datos' => $usuarios];
            echo view('usuarios/eliminados', $data);
        }
        echo view('footer');
    }

    public function nuevo()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','usuario');
        echo view('header');
        if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
        else {
            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            $data = ['titulo' => 'Agregar usuario','cajas'=>$cajas,'roles'=>$roles];
            echo view('usuarios/nuevo', $data);
        }
        echo view('footer');
    }

    public function insertar()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Agregar','usuario');
        echo view('header');
        if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
        else {
            if($this->request->getMethod()=="post" && $this->validate($this->reglas))
            {
                $hash = password_hash($this->request->getPost('password'),PASSWORD_DEFAULT);
                $this->usuarios->save([
                    'usuario'=>$this->request->getPost('usuario'),
                    'password'=>$hash,
                    'nombre'=>$this->request->getPost('nombre'),
                    'id_caja'=>$this->request->getPost('id_caja'),
                    'id_rol'=>$this->request->getPost('id_rol'),
                    'activo'=>1
                ]);
                return redirect()->to(base_url().'/usuarios');
            }else {
                $cajas = $this->cajas->where('activo', 1)->findAll();
                $roles = $this->roles->where('activo', 1)->findAll();
                $data = ['titulo' => 'Agregar usuario','cajas'=>$cajas,'roles'=>$roles,'validation'=>$this->validator];
                echo view('usuarios/nuevo', $data);
            }
        }
        echo view('footer');
    }

    public function editar($id, $valid=null)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','usuario'); 
        echo view('header');
        if (!$permiso1 || !$permiso2) { echo view('roles/sinpermiso');}
        else {
            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            $usuario = $this->usuarios->where('id',$id)->first();
            if($valid != null){
                $data = ['titulo' => 'Editar usuario','cajas'=>$cajas,'roles'=>$roles,"usuario"=>$usuario,'validation'=>$valid];
            }else {
                $data = ['titulo' => 'Editar usuario','cajas'=>$cajas,'roles'=>$roles,"usuario"=>$usuario];
            }
            echo view('usuarios/editar', $data);
        }
        echo view('footer');
    }

    public function actualizar()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Editar','usuario');
        if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso'); echo view('footer');}
        else {
            if($this->request->getMethod()=="post" && $this->validate($this->reglasEdit) ){
                $this->usuarios->update($this->request->getPost('id'),[
                'nombre'=>$this->request->getPost('nombre'),
                'id_caja'=>$this->request->getPost('id_caja'),
                'id_rol'=>$this->request->getPost('id_rol'),
                'activo'=>1
            ]);
                return redirect()->to(base_url().'/usuarios');
            }else {
                return $this->editar($this->request->getPost('id'),$this->validator);
            }
        }
    }

    public function eliminar($id)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminar','usuario');
        if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso'); echo view('footer');}
        else {
            $this->usuarios->update($id,['activo'=> 0]);
            return redirect()->to(base_url().'/usuarios');
        }
    }

    public function reingresar($id)
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $permiso1 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Usuarios','usuario');
        $permiso2 = $this->detalleRoles->verificaPermisos($this->session->id_rol,'Eliminados','usuario');
        if (!$permiso1 || !$permiso2) {echo view('header');echo view('roles/sinpermiso'); echo view('footer');}
        else {
            $this->usuarios->update($id,['activo'=> 1]);
            return redirect()->to(base_url().'/usuarios');
        }
    }

    public function login(){
        echo view('login');
    }

    public function valida(){
        if($this->request->getMethod()=="post" && $this->validate($this->reglasLogin))
        {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuarios = $this->usuarios->where('usuario',$usuario)->first();
          
            if($datosUsuarios != null){
                if (password_verify($password, $datosUsuarios['password'])) {
                    $datosSesion = [
                        'id_usuario'=> $datosUsuarios['id'],
                        'nombre'=> $datosUsuarios['nombre'],
                        'id_caja'=> $datosUsuarios['id_caja'],
                        'id_rol'=> $datosUsuarios['id_rol']
                    ];
                    $session = session();
                    $session->set($datosSesion);
                    return redirect()->to(base_url().'/inicio');
                }else {
                    $data['error'] = "Las contraseña no coinciden";
                    echo view('login',$data);
                }
            }else {
                $data['error'] = "El usuario no existe";
                echo view('login',$data);
            }
        }
        else 
        {
            $data=['validation'=> $this->validator];
            echo view('login',$data);
        }
    }

    public function logout(){
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambia_password(){
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $session = session();
        $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
        $data = ['titulo' => 'Cambiar contraseña','usuario'=>$usuario];
        echo view('header');
        echo view('usuarios/cambia_password', $data);
        echo view('footer');
    }

    public function actualizar_password()
    {   if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        if($this->request->getMethod()=="post" && $this->validate($this->reglasCambia))
        {
            $session = session();
            $idUsuario = $session->id_usuario;
            $hash = password_hash($this->request->getPost('password'),PASSWORD_DEFAULT);
            $this->usuarios->update($idUsuario,['password'=>$hash]);
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'Cambiar contraseña','usuario'=>$usuario,'mensaje'=>'Contraseña actualizada'];
            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }else {
            $session = session();
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'Cambiar contraseña','usuario'=>$usuario,'validation'=>$this->validator];
            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }
    }

    public function gargar_perfil(){
        if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
        $session = session();
        $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
        $caja = $this->cajas->where('id',$this->session->id_caja)->first();
        $rol = $this->roles->where('id',$this->session->id_rol)->first();
        $data = ['titulo' => 'Cambiar contraseña','usuario'=>$usuario,'rol'=>$rol,'caja'=>$caja];
        echo view('header');
        echo view('usuarios/perfil', $data);
        echo view('footer');
    }
}
