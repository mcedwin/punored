<?php

namespace App\Controllers;

use App\Models\NoticiasModel;
use App\Models\UsuarioModel;

class Miembros extends BaseController
{
    public function index()
    {  
        $this->meta->title = "Miembros";
        $datos['rows'] = $this->db->query("SELECT usua_id,usua_nombres,usua_apellidos,usua_foto FROM usuario")->getResult();
        $this->showHeader();
        $this->ShowContent('index',$datos);
        $this->showFooter();
    }

    public function perfil()
    {
        $this->meta->title = "Perfil de miembro";
        helper("formulario");
        $model = new UsuarioModel();
        $this->datos['from'] = 'Miembros/perfil/';
        $this->datos['fields'] = $model->get($this->user->id);
        $this->datos['fields']->usua_password->value = '';
        $this->datos['fields']->usua_foto->value = base_url('uploads/usuario') . (empty($this->datos['fields']->usua_foto->value) ? '/sinlogo.png' : '/' . $this->datos['fields']->usua_foto->value);
        $this->addJs(array("js/miembros/perfil.js"));
        $this->showHeader();
        $this->ShowContent('perfil');
        $this->showFooter();
    }

    public function guardar()
	{
		$model = new UsuarioModel();
		$data = $this->validar($model->getFields());
		unset($data['usua_foto']);
		if (empty($data['usua_password'])) unset($data['usua_password']);
		else $data['usua_password'] = md5($this->input->post('usua_password'));

		$path = 'img_' . $this->user->id . '.small.jpg';
		if ($this->guardar_imagen('uploads/usuario', $path)) {
			$data = array_merge($data, array('usua_foto' => $path));
		}
		$this->db->table('usuario')->update($data, array('usua_id' => $this->user->id));
		$this->dieMsg(true);
	}

    function registrar()
    {
        $this->meta->title = "Registrar nuevo usuario";
        helper("formulario");
        $model = new UsuarioModel();
        $this->datos['fields'] = $model->get();

        $this->addJs(array("js/login/login.js"));
        $this->showHeader(true);
        $this->showContent('registrar');
        $this->showFooter();
    }


    public function proc_registrar() ##running
    {
        $nombres  = ($this->request->getPost("usua_nombres"));
        $email  = ($this->request->getPost("usua_email"));
        $email = trim($email);
        if (strlen($email) <= 3) $this->dieMsg(false, "Correo incorrecto");
        $password = ($this->request->getPost("usua_password"));
        $password2 = md5(rand(999999999, 9999999999));
        $row = $this->db->query("SELECT * FROM usuario WHERE usua_email='{$email}'")->getRow();


        if ($row) {
            $this->dieMsg(false, 'Usted ya esta registrado');
        }
        $datos = array(
            'usua_nombres' => $nombres,
            'usua_email' => $email,
            'usua_tipo_id' => '1',
            'usua_password' => md5($password),
            'usua_password2' => $password2,
            'usua_activo' => '0' ##fixx
        );
        $this->db->table('usuario')->insert($datos);
        //$this->sendpregistro($nombres, $email, $password2); ##fixx
        $this->dieMsg();
    }

    function proc_cambiar($password2)
    {
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $ip = $this->request->getIPAddress();

        $sql = "SELECT usua_id as id,usua_email as email,usua_tipo_id as type FROM usuario WHERE 
        usua_email='{$email}' AND !(usua_password2 IS NULL) AND !(usua_password2='') 
        AND  usua_password2='{$password2}' LIMIT 1";
        //echo $sql;

        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $sql = "UPDATE usuario SET usua_lastip='{$ip}',usua_password=md5('{$password}'),usua_password2=NULL WHERE usua_id='{$row->id}'";
            $this->db->query($sql);
        } else {
            $this->dieMsg(false, "Error al ingresar sus datos");
        }
        $this->dieMsg(true, '', base_url());
    }


    function cambiar($email, $password2)
    {
        $this->meta->title = "Cambiar contraseña";
        $this->addJs(array("js/login/login.js"));
        $this->datos['password2'] = $password2;
        $this->datos['email'] = urldecode($email);
        $this->showHeader(true);
        $this->showContent('cambiar', $datos);
        $this->showFooter();
    }

    function confirmar($email, $password2) ##codeigniter3
    {
        $email = urldecode($email);
        $this->db->query("UPDATE usuario SET usua_password2=NULL, usua_activo=1 WHERE usua_email='{$email}' AND usua_password2='{$password2}'");
        redirect("Login");
    }

    function recuperar() ##codeigniter3
    {
        $this->ShowContent('recuperar');
    }

    public function proc_recuperar() ##codeigniter3
    {
        $email = $this->request->getPost('email');
        $row = $this->db->query("SELECT * FROM usuario WHERE usua_email='{$email}'")->row();
        if ($row) {
            $this->sendpassword($row);
        } else {
            $this->dieMsg(false, "Email no encontrado.");
        }
    }

    public function sendpassword($row)
    {
        if ($row) {
            $passwordplain  = rand(999999999, 9999999999);
            $newpass['usua_password2'] = md5($passwordplain);
            $this->db->where('usua_email', $row->usua_email);
            $this->db->update('usuario', $newpass);
            $mail_message = 'Estimado ' . $row->usua_nombres . ',' . "\r\n";
            $mail_message .= 'Gracias por contactarnos para recuperar su contraseña,<br> Ingrese al siguiente enlace para cambiar su contraseña: 
            <b><a href="' . base_url('Login/cambiar/' . urlencode($row->usua_email) . '/' . $newpass['usua_password2']) . '">Cambiar</a></b>' . "\r\n";
            $mail_message .= '<br>Favor de actualizar su contraseña.';
            $mail_message .= '<br>Gracias';
            $mail_message .= '<br>Egresado.pe';

            require FCPATH . 'assets/PHPMailer/src/Exception.php'; ## assets primero
            require FCPATH . 'assets/PHPMailer/src/PHPMailer.php';
            require FCPATH . 'assets/PHPMailer/src/SMTP.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer(false);
            //$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPSecure = "tls";
            //$mail->Debugoutput = 'html';
            $mail->Host = "tls://smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->Username = "edwin@gruposistemas.com"; ##cambiar a env
            $mail->Password = "locoloco"; ##cambiar a env
            $mail->setFrom('edwin@gruposistemas.com', 'Egresado');
            $mail->IsHTML(true);
            $mail->addAddress($row->usua_email);
            $mail->Subject = 'Recuperar egresado.pe';
            $mail->Body    = $mail_message;
            $mail->AltBody = $mail_message;
            if (!$mail->send()) {
                $this->dieMsg(false, "Error al enviar la contraseña.");
            } else {
                $this->dieMsg();
            }
        } else {
            $this->dieMsg(false, "Correo no encontrado.");
        }
    }


    public function sendpregistro($nombres, $email, $password2)
    {
        $mail_message = 'Estimado ' . $nombres . ',' . "\r\n";
        $mail_message .= 'Gracias por registrare a egresado.pe,<br> Ingrese al siguiente enlace para confirmar su registro: 
            <b><a href="' . base_url('Login/confirmar/' . urlencode($email) . '/' . $password2) . '">Confirmar</a></b>' . "\r\n";
        $mail_message .= '<br>Gracias';
        $mail_message .= '<br>Egresado.pe';

        require FCPATH . 'assets/PHPMailer/src/Exception.php';
        require FCPATH . 'assets/PHPMailer/src/PHPMailer.php';
        require FCPATH . 'assets/PHPMailer/src/SMTP.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(false);
        //$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPSecure = "tls";
        //$mail->Debugoutput = 'html';
        $mail->Host = "tls://smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->CharSet = "UTF-8";
        $mail->Username = "edwin@gruposistemas.com";
        $mail->Password = "locoloco";
        $mail->setFrom('edwin@gruposistemas.com', 'Egresado');
        $mail->IsHTML(true);
        $mail->addAddress($email);
        $mail->Subject = 'Confirmar egresado.pe';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;
        if (!$mail->send()) {
            $this->dieMsg(false, "Error al enviar correo.");
        } else {
            $this->dieMsg();
        }
    }

    function info($id)
    {
        $datos['row'] = $this->db->query("SELECT usua_id,usua_nombres,usua_apellidos,usua_foto,usua_descripcion FROM usuario WHERE usua_id='{$id}'")->getRow();
        $this->meta->title = "Información de Miembro ".$datos['row']->usua_nombres;
        $this->showHeader(true);
        $this->showContent('info',$datos);
        $this->showFooter();
    }

}
