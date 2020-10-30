<?php
class PerPage
{
    public $perpage;

    function __construct()
    {
        $this->perpage = 3;
    }

    function getPrevNext($count, $href)
    {
        $output = '';
        if (!isset($_GET["page"])) $_GET["page"] = 1;
        if ($this->perpage != 0) $pages = ceil($count / $this->perpage);
        if ($pages > 1)
        {
            if ($_GET["page"] == 1) $output = $output . '<span class="link disabled first btn btn-primary btn-sm">Prev</span>';
            else $output = $output . '<a class="link first btn btn-primary btn-sm" onclick="getresult(\'' . $href . ($_GET["page"] - 1) . '\')" >Prev</a>';

            if ($_GET["page"] < $pages) $output = $output . '<a  class="link btn btn-primary btn-sm" onclick="getresult(\'' . $href . ($_GET["page"] + 1) . '\')" >Next</a>';
            else $output = $output . '<span class="link disabled btn btn-primary btn-sm">Next</span>';

        }
        return $output;
    }
}
?>
