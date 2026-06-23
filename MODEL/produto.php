<?php

namespace MODEL;

class Produto
{
    private $id;
    private $descricao;
    private $categoria;
    private $quantidade;
    private $preco;
    private $estoque_minimo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getEstoqueMinimo()
    {
        return $this->estoque_minimo;
    }

    public function setEstoqueMinimo($estoque_minimo)
    {
        $this->estoque_minimo = $estoque_minimo;
    }
}

?>
