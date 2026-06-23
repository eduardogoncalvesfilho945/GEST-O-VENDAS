<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/itemvenda.php";

class ItemVenda
{
    private function montarItemVenda(array $linha)
    {
        $itemVenda = new \MODEL\ItemVenda();
        $itemVenda->setId($linha['id']);
        $itemVenda->setVenda($linha['venda']);
        $itemVenda->setProduto($linha['produto']);
        $itemVenda->setQuantidade($linha['quantidade']);
        $itemVenda->setPrecoUnitario($linha['preco_unitario']);
        $itemVenda->setSubtotal($linha['subtotal']);
        return $itemVenda;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM itemvenda ORDER BY id;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);
            $lstItemVenda = [];
            foreach ($registros as $linha) {
                $lstItemVenda[] = $this->montarItemVenda($linha);
            }
            Conexao::desconectar();
            return $lstItemVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar itens de venda: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM itemvenda WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);
            Conexao::desconectar();
            if (!$linha) {
                return null;
            }
            return $this->montarItemVenda($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar item de venda por ID: " . $e->getMessage());
        }
    }

    public function SelectByVenda(int $venda)
    {
        try {
            $sql = "SELECT * FROM itemvenda WHERE venda = ? ORDER BY id;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$venda]);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);
            $lstItemVenda = [];
            foreach ($registros as $linha) {
                $lstItemVenda[] = $this->montarItemVenda($linha);
            }
            Conexao::desconectar();
            return $lstItemVenda;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar itens de venda por venda: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\ItemVenda $itemVenda)
    {
        $con = Conexao::conectar();
        try {
            $con->beginTransaction();
            $sqlProduto = "SELECT quantidade, preco FROM produto WHERE id = ? FOR UPDATE;";
            $queryProduto = $con->prepare($sqlProduto);
            $queryProduto->execute([$itemVenda->getProduto()]);
            $produto = $queryProduto->fetch(\PDO::FETCH_ASSOC);
            if (!$produto) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Produto não encontrado.");
            }
            if ($itemVenda->getQuantidade() <= 0) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Quantidade deve ser maior que zero.");
            }
            if ($produto['quantidade'] < $itemVenda->getQuantidade()) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Quantidade insuficiente em estoque.");
            }
            $precoUnitario = $produto['preco'];
            $subtotal = $precoUnitario * $itemVenda->getQuantidade();
            $sqlItem = "INSERT INTO itemvenda (venda, produto, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?);";
            $queryItem = $con->prepare($sqlItem);
            $queryItem->execute([$itemVenda->getVenda(), $itemVenda->getProduto(), $itemVenda->getQuantidade(), $precoUnitario, $subtotal]);
            $sqlEstoque = "UPDATE produto SET quantidade = quantidade - ? WHERE id = ?;";
            $queryEstoque = $con->prepare($sqlEstoque);
            $queryEstoque->execute([$itemVenda->getQuantidade(), $itemVenda->getProduto()]);
            $sqlVenda = "UPDATE venda SET valor_total = valor_total + ? WHERE id = ?;";
            $queryVenda = $con->prepare($sqlVenda);
            $queryVenda->execute([$subtotal, $itemVenda->getVenda()]);
            $con->commit();
            Conexao::desconectar();
            return true;
        } catch (\Exception $exception) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            Conexao::desconectar();
            throw $exception;
        }
    }

    public function Update(\MODEL\ItemVenda $itemVenda)
    {
        $con = Conexao::conectar();
        try {
            $con->beginTransaction();
            $sqlAntigo = "SELECT * FROM itemvenda WHERE id = ? FOR UPDATE;";
            $queryAntigo = $con->prepare($sqlAntigo);
            $queryAntigo->execute([$itemVenda->getId()]);
            $itemAntigo = $queryAntigo->fetch(\PDO::FETCH_ASSOC);
            if (!$itemAntigo) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Item de venda não encontrado.");
            }
            if ($itemVenda->getQuantidade() <= 0) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Quantidade deve ser maior que zero.");
            }
            $sqlDevolverEstoque = "UPDATE produto SET quantidade = quantidade + ? WHERE id = ?;";
            $queryDevolverEstoque = $con->prepare($sqlDevolverEstoque);
            $queryDevolverEstoque->execute([$itemAntigo['quantidade'], $itemAntigo['produto']]);
            $sqlProduto = "SELECT quantidade, preco FROM produto WHERE id = ? FOR UPDATE;";
            $queryProduto = $con->prepare($sqlProduto);
            $queryProduto->execute([$itemVenda->getProduto()]);
            $produto = $queryProduto->fetch(\PDO::FETCH_ASSOC);
            if (!$produto || $produto['quantidade'] < $itemVenda->getQuantidade()) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Quantidade insuficiente em estoque.");
            }
            $precoUnitario = $produto['preco'];
            $subtotal = $precoUnitario * $itemVenda->getQuantidade();
            $sqlAtualizarItem = "UPDATE itemvenda SET venda = ?, produto = ?, quantidade = ?, preco_unitario = ?, subtotal = ? WHERE id = ?;";
            $queryAtualizarItem = $con->prepare($sqlAtualizarItem);
            $queryAtualizarItem->execute([$itemVenda->getVenda(), $itemVenda->getProduto(), $itemVenda->getQuantidade(), $precoUnitario, $subtotal, $itemVenda->getId()]);
            $sqlRetirarEstoque = "UPDATE produto SET quantidade = quantidade - ? WHERE id = ?;";
            $queryRetirarEstoque = $con->prepare($sqlRetirarEstoque);
            $queryRetirarEstoque->execute([$itemVenda->getQuantidade(), $itemVenda->getProduto()]);
            $sqlVendaAntiga = "UPDATE venda SET valor_total = valor_total - ? WHERE id = ?;";
            $queryVendaAntiga = $con->prepare($sqlVendaAntiga);
            $queryVendaAntiga->execute([$itemAntigo['subtotal'], $itemAntigo['venda']]);
            $sqlVendaNova = "UPDATE venda SET valor_total = valor_total + ? WHERE id = ?;";
            $queryVendaNova = $con->prepare($sqlVendaNova);
            $queryVendaNova->execute([$subtotal, $itemVenda->getVenda()]);
            $con->commit();
            Conexao::desconectar();
            return true;
        } catch (\Exception $exception) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            Conexao::desconectar();
            throw $exception;
        }
    }

    public function Delete(int $id)
    {
        $con = Conexao::conectar();
        try {
            $con->beginTransaction();
            $sqlItem = "SELECT * FROM itemvenda WHERE id = ? FOR UPDATE;";
            $queryItem = $con->prepare($sqlItem);
            $queryItem->execute([$id]);
            $item = $queryItem->fetch(\PDO::FETCH_ASSOC);
            if (!$item) {
                $con->rollBack();
                Conexao::desconectar();
                throw new \Exception("Item de venda não encontrado.");
            }
            $sqlDelete = "DELETE FROM itemvenda WHERE id = ?;";
            $queryDelete = $con->prepare($sqlDelete);
            $queryDelete->execute([$id]);
            $sqlEstoque = "UPDATE produto SET quantidade = quantidade + ? WHERE id = ?;";
            $queryEstoque = $con->prepare($sqlEstoque);
            $queryEstoque->execute([$item['quantidade'], $item['produto']]);
            $sqlVenda = "UPDATE venda SET valor_total = valor_total - ? WHERE id = ?;";
            $queryVenda = $con->prepare($sqlVenda);
            $queryVenda->execute([$item['subtotal'], $item['venda']]);
            $con->commit();
            Conexao::desconectar();
            return true;
        } catch (\Exception $exception) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            Conexao::desconectar();
            throw $exception;
        }
    }
}

?>
