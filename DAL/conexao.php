<?php

namespace DAL;

use PDO;

class Conexao
{
    private static $dbNome = 'gestaovendas';
    private static $dbHost = '127.0.0.1';
    private static $dbUsuario = 'root';
    private static $dbSenha = '';

    private static $cont = null;

    public static function conectar()
    {
        if (self::$cont == null) {
            try {
                self::$cont = new PDO(
                    "mysql:host=" . self::$dbHost .
                    ";dbname=" . self::$dbNome .
                    ";charset=utf8mb4",
                    self::$dbUsuario,
                    self::$dbSenha
                );

                self::$cont->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            } catch (\PDOException $exception) {
                error_log('Erro de conexao com o banco de dados: ' . $exception->getMessage());
                die('Não foi possível conectar ao banco de dados. Verifique se o MySQL está em execução e se as credenciais em DAL/conexao.php estão corretas.');
            }
        }

        return self::$cont;
    }

    public static function desconectar()
    {
        self::$cont = null;

        return self::$cont;
    }
}

?>