<?php

class Contato{

	private $contatoTb = 'contato';
	private $contatoEmail = 1;
	private $contatoFone = 2;

	public function insert($args, $params)
	{
		$sql = "INSERT INTO " . $this->contatoTb . " (idCliente, tipoContato, contato) VALUES ( " . $args['idCliente'] .  ", " . $params['tipoContato'] . ", '" . $params['contato'] . "') ;";
		$paramsDb = array(
			":idCliente" => $args['idCliente'],
			":tipoContato" => $params['tipoContato'],
			":contato" => $params['contato']
		);
		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql, $paramsDb);
		$banco->commit();
		return array("msg" => 'sucesso', "sucesso" => 'Contato cadastrado com Sucesso');
	}

	public function read($options = array())
	{
		$sql = "SELECT * FROM " . $this->contatoTb;

		if (isset($options['idContato'])) {
			$sql .= " WHERE id = " . $options['idContato'];
		}

		if (isset($options['idCliente'])) {
			$sql .= " WHERE idCliente = " . $options['idCliente'];
		}

		$banco = New Banco();
		$clientes = $banco->read($sql);
		return $clientes;
	}

	public function update($args, $params)
	{
		$sql = "UPDATE " . $this->contatoTb . " SET contato = '" . $params['contato'] . "', tipoContato = " . $params['tipoContato'] . " WHERE id = " . $args['idContato'] . " ;";
		$paramsDb = array(
			":contato" => $params['contato'],
			":tipoContato" => $params['tipoContato'],
			":id" => $args['idContato']
		);
		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql, $paramsDb);
		$banco->commit();
		return array("msg" => 'sucesso', "sucesso" => 'Contato atualizado com Sucesso');
	}

	public function delete($args)
	{
		$sql = "DELETE FROM " . $this->contatoTb . " WHERE";

		if ($args['idContato']) {
			$sql .= " id = " . $args['idContato'] . " ;";
		}

		if ($args['idCliente']) {
			$sql .= " idCliente = " . $args['idCliente'] . " ;";
		}

		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql, $paramsDb);
		$banco->commit();
		return array("msg" => 'sucesso', "sucesso" => 'Contato deletado com Sucesso');
	}
}