<?php

function iniFields($fields, &$tfields)
{
    foreach ($fields as $reg) {
        if (!isset($tfields[$reg->name])) continue;
        $tfields[$reg->name]['type'] = isset($tfields[$reg->name]['type']) ? $tfields[$reg->name]['type'] : $reg->type;
        $tfields[$reg->name]['name'] = isset($tfields[$reg->name]['name']) ? $tfields[$reg->name]['name'] : $reg->name;
        $tfields[$reg->name]['max_length'] = $reg->max_length;
        $tfields[$reg->name]['value'] =  isset($tfields[$reg->name]['value']) ? $tfields[$reg->name]['value'] : '';
        $tfields[$reg->name]['required'] =  isset($tfields[$reg->name]['required']) ? $tfields[$reg->name]['required'] : true;
        $tfields[$reg->name] = (object) $tfields[$reg->name];
    }
}
