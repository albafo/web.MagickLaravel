<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 07/08/15
 * Time: 11:13
 */

namespace Magia\Controller\HtmlRenderer;


class TableRenderer {

    protected $table = "";
    protected $headers = "";
    protected $rows = "";

    public static function createTable($headers, $arrayData)
    {
        $tableRender = new TableRenderer();
        $tableRender->prepareHeaders($headers);
        $tableRender->prepareRows($arrayData);
        return $tableRender->generateTable();

    }

    protected function prepareHeaders($headers)
    {
        $content = '';
        foreach($headers as $head)
        {
            $content.="<td>$head</td>";
        }

        $this->headers = "<thead><tr>$content</tr></thead>";
    }

    protected function prepareRows($rows)
    {
        $content = "";
        foreach($rows as $row) {
            $contentRow = '';
            foreach ($row as $column) {
                $contentRow .= "<td>$column</td>";
            }
            $content .= "<tr>$contentRow</tr>";
        }

        $this->rows = "<tbody>$content</tbody>";
    }

    protected function generateTable()
    {
        return "<div class='table-responsive'><table class='table table-bordered'>{$this->headers} {$this->rows}</table></div>";
    }


}