<?php

class Cliente{

	private $clienteTb = 'cliente';

	public function insert($params)
	{
		$sql = "INSERT INTO " . $this->clienteTb . " (nome) VALUES ( '" . $params['nome'] . "') ;";
		
		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql);

		$contatos = json_decode($params['contatos'], true);

		if (!empty($contatos)) {
			$contato = new Contato();
			$lastId = $banco->read("SELECT LAST_INSERT_ID() AS id");
			$args = array(
				'idCliente' => $lastId[0]['id'],
			);
			foreach ($contatos as $key => $iContato) {	
				$params = array(
					'tipoContato' => $iContato['tipoContato'],
					'contato' => $iContato['contato'],
				);
				$contato->insert($args,$params);
			}
		}

		$banco->commit();

		return array("msg" => 'sucesso', "sucesso" => 'Cliente cadastrado com Sucesso');
	}

	public function read($options = array())
	{
		$sql = "SELECT * FROM " . $this->clienteTb;

		if (isset($options['id'])) {
			$sql .= " WHERE id = " . $options['id'];
		}

		$banco = New Banco();
		$clientes = $banco->read($sql);
		return $clientes;
	}

	public function update($args, $params)
	{
		$sql = "UPDATE " . $this->clienteTb . " SET nome = '" . $params['nome'] . "' WHERE id = " . $args['idCliente'] . " ;";
		$paramsDb = array(
			":idCliente" => $args['idCliente'],
			":tipoContato" => $params['tipoContato'],
			":contato" => $params['contato']
		);
		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql, $paramsDb);

		$contatos = json_decode($params['contatos'], true);

		if (!empty($contatos)) {
			$contato = new Contato();
			$args = array(
				'idCliente' => 3,
			);
			foreach ($contatos as $key => $iContato) {	
				$args['idContato'] = $iContato['id'];
				$params = array(
					'tipoContato' => $iContato['tipoContato'],
					'contato' => $iContato['contato']
				);
				$contato->update($args,$params);
			}
		}

		$banco->commit();

		return array("msg" => 'sucesso', "sucesso" => 'Cliente atualizado com Sucesso');
	}

	public function delete($args)
	{

		$contato = new Contato();
		$contato->delete(array(
			'idCliente' => $args['idCliente']
		));

		$sql = "DELETE FROM " . $this->clienteTb . " WHERE id = " . $args['idCliente'] . " ;";;

		$banco = New Banco();
		$banco->begin();
		$banco->exec($sql, $paramsDb);
		$banco->commit();
		return array("msg" => 'sucesso', "sucesso" => 'Contato deletado com Sucesso');
	}
}