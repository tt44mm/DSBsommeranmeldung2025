<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thomas
 * Date: 22.03.11
 * Time: 19:58
 * To change this template use File | Settings | File Templates.
 */
  $fieldnames=array(
      'MfirstName'=>'nombre',
      'MlastName'=>'apellidos',
      'PfirstName'=>'nombre',
      'PlastName'=>'apellidos',
      'Street'=>'direccion (n&uacute;meros)',
      'Town'=>'poblaci&oacute;n',
      'PLZ'=>'codigo postal',
      'Phone'=>'tel&eacute;fono',
      'phone0'=>'tel&eacute;fono adicional 1',
      'phone1'=>'tel&eacute;fono adicional 2',
      'phone2'=>'tel&eacute;fono adicional 3',
      'phone3'=>'tel&eacute;fono adicional 4',
      'phone4'=>'tel&eacute;fono adicional 5',
      'phone'=>'tel&eacute;fono adicional',
      'Email'=>'correo electr&oacute;nico',
      'Email1'=>'correo electr&oacute;nico',
      'Email2'=>'repetido correo electr&oacute;nico',
      'Busida'=>'parada autob&uacute;s ida',
      'Busvuelta'=>'parada autob&uacute;s vuelta',

      'nombre'=>'Nombre',
      'apellidos'=>'Apellidos',
      'birthdate'=>'Cumplea&ntilde;os',
      'dsb'=>'Colegio Alem&aacute;n',
      'colegio'=>'Colegio',
      'alergias'=>'Alergias',
      'intolerancias'=>'Intolerancias',
      'medicaciones'=>'Medicaciones',
      'nadar'=>'Nada sin ayuda',
      'autohinch'=>'Autorizaci&oacute;n ba&ntilde;ar en piscina hinchable',
      'autopisci'=>'Autorizaci&oacute;n ba&ntilde;ar en piscina grande',
      'idioma'=>'Idoima del curso',
      'obsidioma'=>'Nivel de idioma',
      'kurs_woche'=>'Las semanas',


      'nombre0'=>'nombre hijo 1',
      'apellidos0'=>'apellidos hijo 1',
      'birthdate0'=>'cumplea&ntilde;os hijo 1',
      'dsb0'=>'Colegio Alem&aacute;n',
      'colegio0'=>'colegio hijo 1',
      'alergias0'=>'alergias hijo 1',
      'intolerancias0'=>'intolerancias hijo 1',
      'medicaciones0'=>'medicaciones  hijo 1',
      'nadar0'=>'nadar sin ayuda  hijo 1',
      'autohinch0'=>'autorizaci&oacute;n ba&ntilde;ar en piscina hinchable  hijo 1',
      'autopisci0'=>'autorizaci&oacute;n ba&ntilde;ar en piscina grande  hijo 1',
      'idioma0'=>'idoima del curso hijo 1',
      'obsidioma0'=>'nivel de idioma del hijo 1',
      'kurs_woche0'=>'Las semanas  hijo 1',

      'nombre1'=>'nombre hijo 2',
      'apellidos1'=>'apellidos hijo 2',
      'birthdate1'=>'cumplea&ntilde;os hijo 2',
      'dsb1'=>'Colegio Alem&aacute;n',
      'colegio1'=>'colegio hijo 2',
      'alergias1'=>'alergias hijo 2',
      'intolerancias1'=>'in1tolerancias hijo 2',
      'medicaciones1'=>'medicaciones  hijo 2',
      'nadar1'=>'nadar sin ayuda  hijo 2',
      'autohinch1'=>'autorizaci&oacute;n ba&ntilde;ar en piscina hinchable  hijo 2',
      'autopisci1'=>'autorizaci&oacute;n ba&ntilde;ar en piscina grande  hijo 2',
      'idioma1'=>'idoima del curso hijo 2',
      'obsidioma1'=>'nivel de idioma del hijo 2',
      'kurs_woche1'=>'Las semanas  hijo 2',
      
      'nombre2'=>'nombre hijo 3',
      'apellidos2'=>'apellidos hijo 3',
      'birthdate2'=>'cumplea&ntilde;os hijo 3',
      'dsb2'=>'Colegio Alem&aacute;n',
      'colegio2'=>'colegio hijo 3',
      'alergias2'=>'alergias hijo 3',
      'intolerancias2'=>'intolerancias hijo 3',
      'medicaciones2'=>'medicaciones  hijo 3',
      'nadar2'=>'nadar sin ayuda  hijo 3',
      'autohinch2'=>'autorizaci&oacute;n ba&ntilde;ar en piscina hinchable  hijo 3',
      'autopisci2'=>'autorizaci&oacute;n ba&ntilde;ar en piscina grande  hijo 3',
      'idioma2'=>'idoima del curso hijo 3',
      'obsidioma2'=>'nivel de idioma del hijo 3',
      'kurs_woche2'=>'Las semanas  hijo 3',
      
      'nombre3'=>'nombre hijo 4',
      'apellidos3'=>'apellidos hijo 4',
      'birthdate3'=>'cumplea&ntilde;os hijo 4',
      'dsb3'=>'Colegio Alem&aacute;n',
      'colegio3'=>'colegio hijo 4',
      'alergias3'=>'alergias hijo 4',
      'intolerancias3'=>'intolerancias hijo 4',
      'medicaciones3'=>'medicaciones  hijo 4',
      'nadar3'=>'nadar sin ayuda  hijo 4',
      'autohinch3'=>'autorizaci&oacute;n ba&ntilde;ar en piscina hinchable  hijo 4',
      'autopisci3'=>'autorizaci&oacute;n ba&ntilde;ar en piscina grande  hijo 4',
      'idioma3'=>'idoima del curso hijo 4',
      'obsidioma3'=>'nivel de idioma del hijo 4',
      'kurs_woche3'=>'Las semanas  hijo 4',
      
      'nombre4'=>'nombre hijo 5',
      'apellidos4'=>'apellidos hijo 5',
      'birthdate4'=>'cumplea&ntilde;os  hijo 5',
      'dsb4'=>'Colegio Alem&aacute;n',
      'colegio4'=>'colegio  hijo 5',
      'alergias4'=>'alergias hijo 5',
      'intolerancias4'=>'intolerancias hijo 5',
      'medicaciones4'=>'medicaciones  hijo 5',
      'nadar4'=>'nadar sin ayuda  hijo 5',
      'autohinch4'=>'autorizaci&oacute;n ba&ntilde;ar en piscina hinchable  hijo 5',
      'autopisci4'=>'autorizaci&oacute;n ba&ntilde;ar en piscina grande  hijo 5',
      'idioma4'=>'idoima del curso hijo 5',
      'obsidioma4'=>'nivel de idioma del hijo 5',
      'kurs_woche4'=>'Las semanas  hijo 5'
  );

function encode_arr($data) {
        return base64_encode(serialize($data));
}

function decode_arr($data) {
        return unserialize(base64_decode($data));
}
 ?>