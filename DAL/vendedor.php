<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT']
    . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT']
    . "/gestaovenda/MODEL/vendedor.php";

class Vendedor
{
    private function montarVendedor(array $linha)
    {
        $vendedor = new \MODEL\Vendedor();

        $vendedor->setId($linha['id']);
        $vendedor->setNome($linha['nome']);
        $vendedor->setCpf($linha['cpf']);
        $vendedor->setTelefone($linha['telefone']);
        $vendedor->setEmail($linha['email']);

        return $vendedor;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM vendedor ORDER BY nome;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVendedor = [];
            foreach ($registros as $linha) {
                $lstVendedor[] = $this->montarVendedor($linha);
            }

            Conexao::desconectar();
            return $lstVendedor;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendedores: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM vendedor WHERE id = ?;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarVendedor($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendedor por ID: " . $e->getMessage());
        }
    }

    public function SelectByNome(string $nome)
    {
        try {
            $sql = "SELECT * FROM vendedor WHERE nome LIKE ? ORDER BY nome;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute(['%' . $nome . '%']);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVendedor = [];
            foreach ($registros as $linha) {
                $lstVendedor[] = $this->montarVendedor($linha);
            }

            Conexao::desconectar();
            return $lstVendedor;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendedores por nome: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Vendedor $vendedor)
    {
        try {
            $sql = "INSERT INTO vendedor (nome, cpf, telefone, email) VALUES (?, ?, ?, ?);";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $vendedor->getNome(),
                $vendedor->getCpf(),
                $vendedor->getTelefone(),
                $vendedor->getEmail()
            ]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir vendedor: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Vendedor $vendedor)
    {
        try {
            $sql = "UPDATE vendedor SET nome = ?, cpf = ?, telefone = ?, email = ? WHERE id = ?;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $vendedor->getNome(),
                $vendedor->getCpf(),
                $vendedor->getTelefone(),
                $vendedor->getEmail(),
                $vendedor->getId()
            ]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar vendedor: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        try {
            $sql = "DELETE FROM vendedor WHERE id = ?;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$id]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao deletar vendedor: " . $e->getMessage());
        }
    }
}

?>
