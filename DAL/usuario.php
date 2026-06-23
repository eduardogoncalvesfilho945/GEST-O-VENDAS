<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/usuario.php";

class Usuario
{
    private function montarUsuario(array $linha)
    {
        $usuario = new \MODEL\Usuario();
        $usuario->setId($linha['id']);
        $usuario->setLogin($linha['login']);
        $usuario->setSenha($linha['senha']);
        return $usuario;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM usuario ORDER BY login;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstUsuario = [];
            foreach ($registros as $linha) {
                $lstUsuario[] = $this->montarUsuario($linha);
            }

            Conexao::desconectar();
            return $lstUsuario;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar usuários: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarUsuario($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar usuário por ID: " . $e->getMessage());
        }
    }

    public function SelectByLogin(string $login)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE login = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$login]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarUsuario($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar usuário por login: " . $e->getMessage());
        }
    }

    public function ValidarLogin(string $login, string $senha)
    {
        try {
            $senhaCriptografada = md5($senha);

            $sql = "SELECT * FROM usuario WHERE login = ? AND senha = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$login, $senhaCriptografada]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarUsuario($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao validar login: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Usuario $usuario)
    {
        try {
            $senhaCriptografada = md5($usuario->getSenha());

            $sql = "INSERT INTO usuario (login, senha) VALUES (?, ?);";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $usuario->getLogin(),
                $senhaCriptografada
            ]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir usuário: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Usuario $usuario)
    {
        try {
            $senhaCriptografada = md5($usuario->getSenha());

            $sql = "UPDATE usuario SET login = ?, senha = ? WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $usuario->getLogin(),
                $senhaCriptografada,
                $usuario->getId()
            ]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar usuário: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        try {
            $sql = "DELETE FROM usuario WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$id]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao deletar usuário: " . $e->getMessage());
        }
    }
}

?>
