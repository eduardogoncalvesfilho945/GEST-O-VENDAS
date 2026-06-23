<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";

class Cliente
{
    private function montarCliente(array $linha)
    {
        $cliente = new \MODEL\Cliente();
        $cliente->setId($linha['id']);
        $cliente->setNome($linha['nome']);
        $cliente->setCpf($linha['cpf']);
        $cliente->setTelefone($linha['telefone']);
        $cliente->setEmail($linha['email']);
        $cliente->setEndereco($linha['endereco']);
        return $cliente;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM cliente ORDER BY nome;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstCliente = [];
            foreach ($registros as $linha) {
                $lstCliente[] = $this->montarCliente($linha);
            }

            Conexao::desconectar();
            return $lstCliente;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar clientes: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM cliente WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarCliente($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar cliente por ID: " . $e->getMessage());
        }
    }

    public function SelectByNome(string $nome)
    {
        try {
            $sql = "SELECT * FROM cliente WHERE nome LIKE ? ORDER BY nome;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute(['%' . $nome . '%']);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstCliente = [];
            foreach ($registros as $linha) {
                $lstCliente[] = $this->montarCliente($linha);
            }

            Conexao::desconectar();
            return $lstCliente;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar clientes por nome: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Cliente $cliente)
    {
        try {
            $sql = "INSERT INTO cliente (nome, cpf, telefone, email, endereco) VALUES (?, ?, ?, ?, ?);";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $cliente->getNome(),
                $cliente->getCpf(),
                $cliente->getTelefone(),
                $cliente->getEmail(),
                $cliente->getEndereco()
            ]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir cliente: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Cliente $cliente)
    {
        try {
            $sql = "UPDATE cliente SET nome = ?, cpf = ?, telefone = ?, email = ?, endereco = ? WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $cliente->getNome(),
                $cliente->getCpf(),
                $cliente->getTelefone(),
                $cliente->getEmail(),
                $cliente->getEndereco(),
                $cliente->getId()
            ]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar cliente: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        try {
            $sql = "DELETE FROM cliente WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$id]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao deletar cliente: " . $e->getMessage());
        }
    }
}

?>
