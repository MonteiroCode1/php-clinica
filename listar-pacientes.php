<?php

use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioPaciente;
use Luizlins\Projeto01\Infraestrutura\Persistencia\FabricaConexao;

require_once "vendor/autoload.php";

$pdo = FabricaConexao::criarConexao();
$repositorio = new RepositorioPaciente($pdo);
$resposta = $repositorio->buscarTodos();

var_dump($resposta);