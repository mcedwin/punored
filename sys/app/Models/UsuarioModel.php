<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    var $fields;
    public function __construct()
    {
        parent::__construct();
        $this->fields = array(
            'usua_nombres' => array('label' => 'Nombres'),
            'usua_movil' => array('label' => 'Teléfono movil', 'required' => false),
            'usua_email' => array('label' => 'Email'),
            'usua_foto' => array('label' => 'Imagen', 'required' => false),
            'usua_nick' => array('label' => 'Usuario'),
            'usua_password' => array('label' => 'Password', 'required' => false),
            'usua_descripcion' => array('label' => 'Descripción'),
        );
        helper('funciones');
        $dfields = $this->db->getFieldData('usuario');
        iniFields($dfields, $this->fields);
    }

    function getFields()
    {
        return $this->fields;
    }

    function get($id = '')
    {
        if (!empty($id)) {
            $row = $this->db->query("SELECT * FROM usuario WHERE usua_id='{$id}'")->getRow();
            foreach ($row as $k => $value) {
                if (!isset($this->fields[$k])) continue;
                $this->fields[$k]->value =  $value;
            }
        }
        return (object)$this->fields;
    }
}
