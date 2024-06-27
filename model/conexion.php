<?php

class Conexion
{
    public static function conectar()
    {
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "musica";
        $stringConnection = mysqli_connect($server, $user, $pass, $db);
        return $stringConnection;
    }
}
