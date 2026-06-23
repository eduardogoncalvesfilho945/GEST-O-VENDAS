<?php

namespace MODEL;

class Venda
{
    private $id;
    private $cliente;
    private $vendedor;
    private $data_venda;
    private $valor_total;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    public function getVendedor()
    {
        return $this->vendedor;
    }

    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    public function getDataVenda()
    {
        return $this->data_venda;
    }

    public function setDataVenda($data_venda)
    {
        $this->data_venda = $data_venda;
    }

    public function getValorTotal()
    {
        return $this->valor_total;
    }

    public function setValorTotal($valor_total)
    {
        $this->valor_total = $valor_total;
    }
}

?>
