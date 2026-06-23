<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT']
    . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT']
    . "/gestaovenda/MODEL/venda.php";

class Venda
{
    private function montarVenda(array $linha)
    {
        $venda = new \MODEL\Venda();

        $venda->setId($linha['id']);
        $venda->setCliente($linha['cliente']);
        $venda->setVendedor($linha['vendedor']);
        $venda->setDataVenda($linha['data_venda']);
        $venda->setValorTotal($linha['valor_total']);

        return $venda;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM venda ORDER BY data_venda DESC;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVenda = [];
            foreach ($registros as $linha) {
                $lstVenda[] = $this->montarVenda($linha);
            }

            Conexao::desconectar();
            return $lstVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendas: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM venda WHERE id = ?;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarVenda($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar venda por ID: " . $e->getMessage());
        }
    }

    public function SelectByCliente(int $cliente)
    {
        try {
            $sql = "SELECT * FROM venda WHERE cliente = ? ORDER BY data_venda DESC;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$cliente]);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVenda = [];
            foreach ($registros as $linha) {
                $lstVenda[] = $this->montarVenda($linha);
            }

            Conexao::desconectar();
            return $lstVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendas por cliente: " . $e->getMessage());
        }
    }

    public function SelectByVendedor(int $vendedor)
    {
        try {
            $sql = "SELECT * FROM venda WHERE vendedor = ? ORDER BY data_venda DESC;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$vendedor]);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVenda = [];
            foreach ($registros as $linha) {
                $lstVenda[] = $this->montarVenda($linha);
            }

            Conexao::desconectar();
            return $lstVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendas por vendedor: " . $e->getMessage());
        }
    }

    public function SelectByData(string $data)
    {
        try {
            $sql = "SELECT * FROM venda WHERE DATE(data_venda) = ? ORDER BY data_venda DESC;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$data]);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstVenda = [];
            foreach ($registros as $linha) {
                $lstVenda[] = $this->montarVenda($linha);
            }

            Conexao::desconectar();
            return $lstVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar vendas por data: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Venda $venda)
    {
        try {
            $sql = "INSERT INTO venda (cliente, vendedor, data_venda, valor_total) VALUES (?, ?, ?, 0);";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([
                $venda->getCliente(),
                $venda->getVendedor(),
                $venda->getDataVenda()
            ]);

            $idVenda = $con->lastInsertId();

            Conexao::desconectar();
            return $idVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir venda: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Venda $venda)
    {
        try {
            $sql = "UPDATE venda SET cliente = ?, vendedor = ?, data_venda = ? WHERE id = ?;";

            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $venda->getCliente(),
                $venda->getVendedor(),
                $venda->getDataVenda(),
                $venda->getId()
            ]);

            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar venda: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        $con = Conexao::conectar();

        try {
            $con->beginTransaction();

            $sqlItens = "SELECT produto, quantidade FROM itemvenda WHERE venda = ?;";
            $queryItens = $con->prepare($sqlItens);
            $queryItens->execute([$id]);
            $itens = $queryItens->fetchAll(\PDO::FETCH_ASSOC);

            // Devolve ao estoque a quantidade de cada item antes de excluir a venda.
            foreach ($itens as $item) {
                $sqlEstoque = "UPDATE produto SET quantidade = quantidade + ? WHERE id = ?;";
                $queryEstoque = $con->prepare($sqlEstoque);
                $queryEstoque->execute([$item['quantidade'], $item['produto']]);
            }

            $sqlExcluirItens = "DELETE FROM itemvenda WHERE venda = ?;";
            $queryExcluirItens = $con->prepare($sqlExcluirItens);
            $queryExcluirItens->execute([$id]);

            $sqlVenda = "DELETE FROM venda WHERE id = ?;";
            $queryVenda = $con->prepare($sqlVenda);
            $result = $queryVenda->execute([$id]);

            $con->commit();

            Conexao::desconectar();
            return $result;
        } catch (\Exception $exception) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }

            Conexao::desconectar();
            throw new \Exception("Erro ao excluir venda: " . $exception->getMessage());
        }
    }
}

?>
