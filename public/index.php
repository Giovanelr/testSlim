<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';
require 'classes/Banco.php';
require'classes/Cliente.php';
require'classes/Contato.php';

$config['view'] = new \Slim\Views\PhpRenderer('../templates/');

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world! 2");
    return $response;
});

$app->post('/api', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(array("apiCheck" => "ON")));
    return $response;
});

$app->post('/api/cliente', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $cliente = new Cliente();
    $listaClientes = $cliente->insert($params);
    $response->getBody()->write(json_encode($listaClientes));
    return $response;
});

$app->post('/api/cliente/{idCliente}', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $cliente = new Cliente();
    $listaClientes = $cliente->update($args, $params);
    $response->getBody()->write(json_encode($listaClientes));
    return $response;
});

$app->delete('/api/cliente/{idCliente}', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $cliente = new Cliente();
    $retorno = $cliente->delete($args);
    $response->getBody()->write(json_encode($retorno));
    return $response;
});

$app->get('/api/clientes', function (Request $request, Response $response, $args) {
    $cliente = new Cliente();
    $listaClientes = $cliente->read();
    $response->getBody()->write(json_encode($listaClientes));
    return $response;
});

$app->post('/api/cliente/{idCliente}/contato', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $contato = new Contato();
    $listaContatos = $contato->insert($args,$params);
    $response->getBody()->write(json_encode($listaContatos));
    return $response;
});

$app->post('/api/contato/{idContato}', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $contato = new Contato();
    $listaContatos = $contato->update($args,$params);
    $response->getBody()->write(json_encode($listaContatos));
    return $response;
});

$app->delete('/api/contato/{idContato}', function (Request $request, Response $response, $args) {
    $params = $request->getParsedBody();
    $contato = new Contato();
    $retorno = $contato->delete($args,$params);
    $response->getBody()->write(json_encode($retorno));
    return $response;
});

$app->get('/api/cliente/{idCliente}/contatos', function (Request $request, Response $response, $args) {
    $contato = new Contato();
    $listaContatos = $contato->read($args);
    $response->getBody()->write(json_encode($listaContatos));
    return $response;
});

$app->get('/clientes', function (Request $request, Response $response, $args) {
    $cliente = new Cliente();
    $listaClientes = $cliente->read();
    $renderer = new PhpRenderer('views');
    return $renderer->render($response, "listaClientes.phtml", array( 'listaClientes' => $listaClientes ));
});

$app->get('/cliente/{idCliente}/contatos', function (Request $request, Response $response, $args) {
    $contato = new Contato();
    $listaContatos = $contato->read($args);
    $renderer = new PhpRenderer('views');
    return $renderer->render($response, "listaContatos.phtml", array( 'listaContatos' => $listaContatos ));
});

$app->run();
