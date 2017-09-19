<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Pagination helper
 */
class PaginationHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function buildPagination($paginator)
    {
        $buffer = "<div class='pagination-div'>";
        $buffer .= "<div class='row vertical-center-row'>";
        $buffer .= "<div class='col-md-8'>";
        $buffer .= "<ul class='pagination pagination-sm'>";
        $buffer .= $paginator->prev("<<");

        $buffer .= $paginator->numbers();

        $buffer .= $paginator->next(">>");
        $buffer .= "</ul>";
        $buffer .= "</div>";

        $buffer .= "<div class='col-md-4' align='right'>";
        $buffer .= $paginator->counter([
            "format" => "{{start}} a {{end}} de {{count}} registros"
        ]);
        $buffer .= "</div>";
        $buffer .= "</div>";
        $buffer .= "</div>";

        return $buffer;
    }
}
