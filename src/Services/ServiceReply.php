<?php
namespace App\Services;

class ServiceReply
{
    public static function generate($data, $message = null)
    {
        // if(is_array($data) && $message)
        // $message = null;
        // elseif(is_string($data)){
        //     $message = $data;
        //     $data = [];
        // }
        
        $result = [
            'Estado' => ($message ? 'Error' : 'Ok'),
            'Datos' => $data,
            'Mensaje' => $message
        ];
        
        // return (object)$result;
        return $result;
    }
}