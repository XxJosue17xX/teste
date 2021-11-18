<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Vaga;
use \App\Db\Pagination;

//buscar
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
$filtroStatus = in_array($filtroStatus, ['s', 'n']) ? $filtroStatus : '';

//condiçoes sql
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%' . str_replace(' ', '%', $busca) . '%"' : null,
    strlen($filtroStatus) ? 'ativo = "' . $filtroStatus . '"' : null
];

//remove posiçoes vazias
$condicoes = array_filter($condicoes);

//clausula where
$where = implode(' AND ', $condicoes);

//quantidade total de vagas
$quantidadeVagas = Vaga::getQuantidadeVagas($where);

//paginação
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 10);

//obtem as vagas
$vagas = Vaga::getVagas($where, null, $obPagination->getLimit());

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/listagem.php';
include __DIR__ . '/includes/footer.php';
