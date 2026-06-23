<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

class Categoria
{
    private function montarCategoria(array $linha)
    {
        $categoria = new \MODEL\Categoria();
        $categoria->setId($linha['id']);
        $categoria->setDescricao($linha['descricao']);
        return $categoria;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM categoria ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstCategoria = [];
            foreach ($registros as $linha) {
                $lstCategoria[] = $this->montarCategoria($linha);
            }

            Conexao::desconectar();
            return $lstCategoria;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar categorias: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM categoria WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarCategoria($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar categoria por ID: " . $e->getMessage());
        }
    }

    public function SelectByDescricao(string $descricao)
    {
        try {
            $sql = "SELECT * FROM categoria WHERE descricao LIKE ? ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute(['%' . $descricao . '%']);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstCategoria = [];
            foreach ($registros as $linha) {
                $lstCategoria[] = $this->montarCategoria($linha);
            }

            Conexao::desconectar();
            return $lstCategoria;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar categorias por descrição: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Categoria $categoria)
    {
        try {
            $sql = "INSERT INTO categoria (descricao) VALUES (?);";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$categoria->getDescricao()]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir categoria: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Categoria $categoria)
    {
        try {
            $sql = "UPDATE categoria SET descricao = ? WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $categoria->getDescricao(),
                $categoria->getId()
            ]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar categoria: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        try {
            $sql = "DELETE FROM categoria WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$id]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao deletar categoria: " . $e->getMessage());
        }
    }
}

?>