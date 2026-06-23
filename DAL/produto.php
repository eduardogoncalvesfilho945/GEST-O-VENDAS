<?php

namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/conexao.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";

class Produto
{
    private function montarProduto(array $linha)
    {
        $produto = new \MODEL\Produto();
        $produto->setId($linha['id']);
        $produto->setDescricao($linha['descricao']);
        $produto->setCategoria($linha['categoria']);
        $produto->setQuantidade($linha['quantidade']);
        $produto->setPreco($linha['preco']);
        $produto->setEstoqueMinimo($linha['estoque_minimo']);
        return $produto;
    }

    public function Select()
    {
        try {
            $sql = "SELECT * FROM produto ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstProduto = [];
            foreach ($registros as $linha) {
                $lstProduto[] = $this->montarProduto($linha);
            }

            Conexao::desconectar();
            return $lstProduto;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar produtos: " . $e->getMessage());
        }
    }

    public function SelectById(int $id)
    {
        try {
            $sql = "SELECT * FROM produto WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$id]);
            $linha = $query->fetch(\PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if (!$linha) {
                return null;
            }

            return $this->montarProduto($linha);
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar produto por ID: " . $e->getMessage());
        }
    }

    public function SelectByDescricao(string $descricao)
    {
        try {
            $sql = "SELECT * FROM produto WHERE descricao LIKE ? ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute(['%' . $descricao . '%']);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstProduto = [];
            foreach ($registros as $linha) {
                $lstProduto[] = $this->montarProduto($linha);
            }

            Conexao::desconectar();
            return $lstProduto;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar produtos por descrição: " . $e->getMessage());
        }
    }

    public function SelectByCategoria(int $categoria)
    {
        try {
            $sql = "SELECT * FROM produto WHERE categoria = ? ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute([$categoria]);
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstProduto = [];
            foreach ($registros as $linha) {
                $lstProduto[] = $this->montarProduto($linha);
            }

            Conexao::desconectar();
            return $lstProduto;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar produtos por categoria: " . $e->getMessage());
        }
    }

    public function SelectAbaixoEstoqueMinimo()
    {
        try {
            $sql = "SELECT * FROM produto WHERE quantidade < estoque_minimo ORDER BY descricao;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

            $lstProduto = [];
            foreach ($registros as $linha) {
                $lstProduto[] = $this->montarProduto($linha);
            }

            Conexao::desconectar();
            return $lstProduto;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao buscar produtos abaixo do estoque mínimo: " . $e->getMessage());
        }
    }

    public function Insert(\MODEL\Produto $produto)
    {
        try {
            $sql = "INSERT INTO produto (descricao, categoria, quantidade, preco, estoque_minimo) VALUES (?, ?, ?, ?, ?);";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $produto->getDescricao(),
                $produto->getCategoria(),
                $produto->getQuantidade(),
                $produto->getPreco(),
                $produto->getEstoqueMinimo()
            ]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao inserir produto: " . $e->getMessage());
        }
    }

    public function Update(\MODEL\Produto $produto)
    {
        try {
            $sql = "UPDATE produto SET descricao = ?, categoria = ?, quantidade = ?, preco = ?, estoque_minimo = ? WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([
                $produto->getDescricao(),
                $produto->getCategoria(),
                $produto->getQuantidade(),
                $produto->getPreco(),
                $produto->getEstoqueMinimo(),
                $produto->getId()
            ]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    public function Delete(int $id)
    {
        try {
            $sql = "DELETE FROM produto WHERE id = ?;";
            $con = Conexao::conectar();
            $query = $con->prepare($sql);
            $result = $query->execute([$id]);
            Conexao::desconectar();
            return $result;
        } catch (\PDOException $e) {
            Conexao::desconectar();
            throw new \Exception("Erro ao deletar produto: " . $e->getMessage());
        }
    }
}

?>
