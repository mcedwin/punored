<?php

namespace App\Controllers;

class Login extends BaseController
{
    function index()
    {
        $this->addJs(array("js/login/login.js"));
        $this->showHeader(true);
        $this->showContent('index');
        $this->showFooter();
    }

    
    public function ingresar() ##running
    {
        $usuario  = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $ip = $this->request->getIPAddress();

        $sql = "SELECT usua_id as id,usua_email as email,usua_tipo_id as type FROM usuario WHERE usua_activo=1 AND usua_email='{$usuario}' AND usua_password=md5('{$password}') LIMIT 1";
        $result = $this->db->query($sql);
        $session = session(); 
        if ($result->getNumRows()) {
            $row = $result->getRow();
            $sesdata = array(
                'id'  => $row->id,
                'user'  => $row->email,
                'type'     => $row->type,
                'auth'     => true
            );
            $session->set($sesdata);
            $sql = "UPDATE usuario SET usua_lastip='{$ip}' WHERE usua_id='{$row->id}'";
            $this->db->query($sql);
        } else {
            $this->dieMsg(false, "Error al ingresar sus datos ó no a confirmado su cuenta");
        }
        $this->dieMsg(true, '', base_url('Miembros/perfil'));
    }

    function salir()
    {
        $session = session(); 
        $session->destroy();
        return redirect()->to('/'); 
    }

    
}
