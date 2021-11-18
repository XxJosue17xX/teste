<?php

namespace App\Db;

class Pagination{

    /**
     * numero maximo de registros por pagina
     * @var integer
     */
    private $limit;

    /**
     * quantidade total de resultados do banco 
     * @var integer
     */
    private $results;

    /**
     * quantidade de paginas
     * @var integer
     */
    private $pages;

    /**
     * pagina atual
     * @var integer
     */
    private $currentPage;

    /**
     * construtor da classe
     * @param integer
     * @param integer
     * @param integer
     */
    public function __construct($results,$currentPage = 1, $limit = 10){
        $this->results = $results;
        $this->limit   = $limit;
        $this->currentPage = (is_numeric($currentPage) and  $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * metodo responsavel por calcular a paginação
     */
    private function calculate(){
        //calcula o total de paginas
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        //verificar se a pagina atual não excede o numero de paginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * metodo responsavel por retornar a clausula limit da sql
     * @return string
     */
    public function getLimit(){
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset.','.$this->limit;
    }

    /**
     * metodo responsavel por retornar as opçoes de paginas disponiveis
     * @return array
     */
    public function getPages(){
        //não retorna paginas
        if($this->pages == 1) return [];

        //paginas
        $paginas = [];
        for($i = 1; $i <= $this->pages; $i++){
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }
    }

}