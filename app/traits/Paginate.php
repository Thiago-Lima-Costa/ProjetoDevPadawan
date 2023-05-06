<?php

namespace app\traits;

//use \app\traits\Paginate;
// o trait Paginate esta sendo adicionado ao respectivo controller, ja que o controller envia as informacoes ao frontend, avaliar se seria o caso adicionar o Paginate aos models

trait Paginate
{

    protected $perPage = 20;
    protected $offset = 0;
    protected $currentPage;
    protected $totalPages;
    protected $linksPerPage = 5;

    public function setPerPage($limit)
    {
        $this->perPage = $limit;
    }

    public function setCurrentPage()
    {
        $this->currentPage = $_GET['page'] ?? 1;
        $this->offset = ($this->currentPage - 1) * $this->perPage;
    }

    public function setTotalPages($count)
    {
        $this->totalPages = ceil($count / $this->perPage);
    }

    public function showPageLinks() 
    {
        $previousPage = $this->currentPage - 1;
        $nextPage = $this->currentPage + 1;

        $output = '<nav aria-label="Page navigation" class="pt-3 pb-0">';
        $output .= '<ul class="pagination justify-content-end mr-3 mb-0">';
        if ($this->currentPage == 1) {
            $output .= '<li class="page-item disabled"><a class="page-link text-secondary border border-warning" href="" style="background-color: black">Anterior</a></li>';

        } else {
            $output .= '<li class="page-item"><a class="page-link paginate-link" href="?page=' . $previousPage . '">Anterior</a></li>';
        }

        for ($i = 1; $i <= $this->totalPages; $i++) {
            if ($i == $this->currentPage) {
                $output .= '<li class="page-item disabled"><a class="page-link bg-warning text-dark border border-warning" href="#">' . $i . '</a></li>';
            } else {
                $output .= '<li class="page-item"><a class="page-link paginate-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }

        if ($this->currentPage == $this->totalPages) {
            $output .= '<li class="page-item disabled"><a class="page-link text-secondary border border-warning" href="" style="background-color: black">Próximo</a></li>';

        } else {
            $output .= '<li class="page-item"><a class="page-link paginate-link" href="?page=' . $nextPage . '">Próximo</a></li>';
        }

        $output .= '</ul>';
        $output .= '</nav>';
        return $output;

    }

}