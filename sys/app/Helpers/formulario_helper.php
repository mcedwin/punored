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