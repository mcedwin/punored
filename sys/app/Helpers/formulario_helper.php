<?php
function select_options($datos, $opts, $vacio = FALSE)
{
    $options = ($vacio != FALSE) ? array("" => $vacio) : array();
    $id = $opts[0];
    $nombre = $opts[1];
    foreach ($datos as $value) {
        $options[$value->$id] = $value->$nombre;
    }
    return $options;
}

function select_enum($datos, $vacio = FALSE)
{
    $options = ($vacio != FALSE) ? array("" => $vacio) : array();
    foreach ($datos as $value) {
        $options[$value] = $value;
    }
    return $options;
}

function dateToMysql($date)
{
    $date = trim($date);
    if (preg_match('#([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4}) ([0-9]{1,2}):([0-9]{1,2}) ([A|P][M])#', $date, $buf)) {
        $hora = ($buf[6] == 'PM' && $buf[4] < 12) ? $buf[4] + 12 : ($buf[4] == 12 && $buf[6] == 'AM' ? 0 : $buf[4]);
        return $buf[3] . '-' . $buf[2] . '-' . $buf[1] . ' ' . $hora . ':' . $buf[5] . ':00';
    }
    return preg_replace('#(\d{1,2})/(\d{1,2})/(\d{4})#', '$3-$2-$1', $date);
}

function dateToUser($date)
{
    $date = trim($date);
    if (preg_match('/ /', $date)) return preg_replace('#(\d{4})-(\d{1,2})-(\d{1,2})\s(.*)#', '$3/$2/$1 $4', $date);
    return preg_replace('#(\d{4})-(\d{1,2})-(\d{1,2})#', '$3/$2/$1', $date);
}

function GetQS($_m, $campos)
{
    $_m = preg_replace("/[ \t]+/i", " ", trim($_m));
    $mms = explode(" ", $_m);
    $arro = array();
    foreach ($mms as $ms) {
        $arra = array();
        foreach ($campos as $cam) {
            $arra[] = "$cam LIKE '%$ms%'";
        }
        $arro[] = "(" . implode(" OR ", $arra) . ")";
    }
    $mm_sql = implode(" AND ", $arro);
    return $mm_sql;
}

function myinput($reg, $col, $class = '', $params = '', $data = array())
{

    if(!isset($reg->id))$reg->id = $reg->name;

   if(isset($reg->max_length)&&$reg->max_length>=200) $reg->type='text';
    $options = "<option value=''>{$reg->label}</option>";
    foreach ($data as $item) {
        $options .= "<option value='{$item->id}' " . ($item->id == $reg->value ? 'selected' : '') . ">{$item->text}</option>";
    }
    $add = '';
    if ($reg->required) {
        $params .= ' required';
        $add = '<strong class="text-danger">*</strong>';
    }
    $label = '';
    $html = '';
    if ($col != '0') {
        $label = "<label for='{$reg->name}'>{$reg->label} {$add}</label>";
        $html .= <<<EOT
            <div class="form-group col-md-{$col}">
EOT;
    }

    if ($reg->type == 'text') {
        $html .= <<<EOT
        {$label}<textarea class="form-control limit" maxlength="{$reg->max_length}" id="{$reg->name}" name="{$reg->name}" {$params}>{$reg->value}</textarea>
EOT;
    } else if ($reg->type == 'select') {
        $html .= <<<EOT
        {$label}<select class="form-control {$class}" id="{$reg->id}" name="{$reg->name}" {$params}>{$options}</select>
EOT;
    } else if ($reg->type == 'date') {
        $html .= <<<EOT
        {$label}<input type="date" class="form-control" id="{$reg->name}" name="{$reg->name}" value="{$reg->value}" {$params} placeholder="día/mes/año">
EOT;
    } else if ($reg->type == 'hidden') {
        $html .= <<<EOT
        {$label}<input type="hidden" class="form-control" id="{$reg->name}" name="{$reg->name}" value="{$reg->value}" {$params}>
EOT;
    } else if ($reg->type == 'url') {
        $html .= <<<EOT
        {$label}<div class="input-group date" id="{$reg->name}" data-target-input="nearest" >
                                    <div class="input-group-prepend" data-target="#{$reg->name}" data-toggle="datetimepicker">
                                        <div class="input-group-text">https://</div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" name="{$reg->name}" value="{$reg->value}" autocomplete="off" data-target="#{$reg->name}" {$params}>
                                </div>
EOT;
    } else if($reg->type=='password'){
        $html .= <<<EOT
    {$label}<input type="password" class="form-control" maxlength="{$reg->max_length}" id="{$reg->name}" name="{$reg->name}" value="{$reg->value}" {$params} autocomplete="off">
EOT;
    } else {
    $html .= <<<EOT
    {$label}<input type="text" class="form-control" maxlength="{$reg->max_length}" id="{$reg->name}" name="{$reg->name}" value="{$reg->value}" {$params} autocomplete="off">
EOT;
}
    if ($col != '0') $html .= '</div>';
    return $html;
}




/*
function myform_select($modo, $key, $datos, $label, $value, $required, $default = true,$rel='')
{
    $class = empty($rel)?'':'relation';
    $param = empty($rel)?array():array('data-rel'=>$rel);
    $strlabel = "<label for='{$key}'><strong>{$label}</strong></label>";
    if ($modo == 'noedit') {
        return $strlabel . '<div>' . (empty($value) ? $value : $this->datos[$value]) . '</div>';
    }
    $args = array('class' => 'form-control '.$class, 'id' => $key)+$param;
    if ($required) {
         $args['required'] = '';
    }
    if ($default) {
        $datos = array('' => '') + $datos;
    }
    return $strlabel . form_dropdown($key, $datos, $value, $args) . ($required ? '<div class="invalid-feedback">Campo requerido</div>' : '');
}
function myform_subbitdouble($modo, $label, $value = '', $name = '', $required = false,$id='',$class='',$value2){
    if ($modo == 'noedit')  return '<div><span '.($value2?'style="border:1px solid red; padding:0 4px;"':'').'>' . $value . '</span></div>';
    return '<div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" name="' . $name . '" value="'.$value.'" class="custom-control-input '.$class.'" id="' . $id . '" ' . ($value2 == true ? 'checked' : '') . ' ' . ($required ? 'required' : '') . '>
                                <label class="custom-control-label hide" for="' . $id . '">'.$label.'</label>
                                </div>';
}
function myform_subinput($modo, $type, $label, $value = '', $name = '', $required = false)
{

    if ($modo == 'noedit')  return '<div>' . $value . '</div>';
    if ($type == 'textarea') {
        return '<textarea class="form-control" rows="4" name="' . $name . '" placeholder="' . $label . '" ' . ($required ? 'required' : '') . '>' . $value . '</textarea>';
    } else {
        return '<input type="text" name="' . $name . '" class="form-control" value="' . $value . '" placeholder="' . $label . '" ' . ($required ? 'required' : '') . '>';
    }
}

function myform_subselect($modo, $value = '', $name = '', $datos = array(), $required = false)
{
    
    if ($modo == 'noedit') {
        return '<div>' . (empty($value) ? '' : $this->datos[$value]) . '</div>';
    } else {
        return form_dropdown($name, $datos,  $value, array('class' => 'form-control ', 'id' => $name) + ($required ? array('required' => '') : array()));
    }
}

function myform_input($modo, $type, $key, $label, $value, $maxlength = '', $label0 = '', $required, $disable = false,$rel='')
{

    $add = $required ? 'required' : '';
    $add .= $disable ? ' disabled' : '';
    $html = "<label for='{$key}'><strong>{$label}</strong></label>";

    if ($modo == 'noedit') {
        if ($type == "bit") $value = $value == '1' ? "SI" : "NO";
        return $html . '<div>' . $value . '</div>';
    }

    $class = empty($rel)?'':'relation';
    $param = empty($rel)?'':'data-rel="'.$rel.'"';

    $html .= empty($label0) ? '' : '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">' . $label0 . '</span></div>';
    if ($type == 'text') $html .= '<textarea class="form-control limit" rows="4" maxlength="500" id="' . $key . '" name="' . $key . '" ' . $add . '>' . $value . '</textarea>';
    elseif ($type == 'int') $html .= '<input type="number" class="form-control" min="0" id="' . $key . '" name="' . $key . '" value="' . $value . '" autocomplete="off" ' . $add . '>';
    elseif ($type == 'decimal') $html .= '<input type="number" min="0" class="form-control text-right decimal" id="' . $key . '" name="' . $key . '" value="' . $value . '" autocomplete="off" ' . $add . '>';
    elseif ($type == 'date')  $html .= '<div class="input-group date" id="' . $key . '" data-target-input="nearest" ' . $add . '>
                                    <input type="text" class="form-control datetimepicker-input" name="' . $key . '" value="' . $value . '" autocomplete="off" data-target="#' . $key . '" ' . $add . '>
                                    <div class="input-group-append" data-target="#' . $key . '" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>';
    elseif ($type == 'bit') $html .= '<div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" name="' . $key . '" value="1" class="custom-control-input '.$class.'" '.$param.' id="' . $key . '" ' . ($value == '1' ? 'checked' : '') . '>
                                <label class="custom-control-label hide" for="' . $key . '"><strong style="color:white">.</strong></label>
                                </div>';

    else $html .= '<input type="text" class="form-control limit" ' . (empty($maxlength) ? '' : 'maxlength="' . $maxlength . '"') . ' id="' . $key . '" name="' . $key . '" value="' . $value . '" autocomplete="off" ' . $add . '>';
    $comp = $required ? '<div class="invalid-feedback">Campo requerido</div>' : '';

    return $html . $comp . (empty($label0) ? '' : '</div>');
}
*/
function THS($arr)
{
    $str = "";
    foreach ($arr as $cod => $val) {
        if (!preg_match('/DT_/', $val['dt']))
            $str .= '<th class="ths">' . $val['dt'] . '</th>';
    }
    return $str;
}

function genDataTable($id, $columns, $withcheck = false, $responsive = false)
{
    if ($responsive) $class = "table table-striped table-bordered dt-responsive";
    else $class = "table table-striped table-bordered";
    return '<table id="' . $id . '" wch="' . $withcheck . '" cellpadding="0" cellspacing="0" border="0" width="100%" class="' . $class . '">
          <thead>
              <tr>
                  '  . THS($columns) . ($withcheck ? '<th></th>' : '') . '
              </tr>
          </thead>
      </table>';
}


function data_table($data)
{

    echo "<table class='table table-striped table-bordered'>";
    echo "<thead><tr>";
    echo "<th style='width:50%'></th><th style='width:50%'>Cantidad</th>";
    echo "</tr></thead>";
    foreach ($data as $reg) {
        if (empty($reg->text)) $reg->text = 'Vacio';
        echo "<tr>";
        echo "<td>{$reg->text}</td><td>{$reg->val}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
