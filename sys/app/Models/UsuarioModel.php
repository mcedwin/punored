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
            'usua_foto' => array('label' => 'Imagen','required' => false),
            'usua_nick' => array('label' => 'Usuario'),
            'usua_password' => array('label' => 'Password', 'required' => false),
            'usua_descripcion' => array('label' => 'Descripción'),
        );

        $dfields = $this->db->getFieldData('usuario');

        foreach ($dfields as $reg) {
            if (!isset($this->fields[$reg->name])) continue;
            $this->fields[$reg->name]['type'] = isset($this->fields[$reg->name]['type']) ? $this->fields[$reg->name]['type'] : $reg->type;
            $this->fields[$reg->name]['name'] = isset($this->fields[$reg->name]['name']) ? $this->fields[$reg->name]['name'] : $reg->name;
            $this->fields[$reg->name]['max_length'] = $reg->max_length;
            $this->fields[$reg->name]['value'] =  isset($this->fields[$reg->name]['value']) ? $this->fields[$reg->name]['value'] : '';
            $this->fields[$reg->name]['required'] =  isset($this->fields[$reg->name]['required']) ? $this->fields[$reg->name]['required'] : true;
            $this->fields[$reg->name] = (object) $this->fields[$reg->name];
        }
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
                //if ($this->fields[$k]->type == 'date') $value = dateToUser($value);
                $this->fields[$k]->value =  $value;
            }
            if (!empty($this->fields['usua_ubig_id']->value)) $this->fields['ubigeo'] = $this->db->query("SELECT ubig_id as id,CONCAT(ubig_departamento,' / ',ubig_provincia,' / ',ubig_distrito) as text FROM ubigeo WHERE ubig_id=" . $this->fields['usua_ubig_id']->value . "")->row();
        }
        return (object)$this->fields;
    }

}
