<?php
include("DB.php");
class Page extends Db
{
    public $name;
    public function __construct(string $pagename = null)
    {
        $this->name = $pagename;
    }

    public function drawTable($sql)
    {

        $data = $this->executeS($sql);

        $html =  "<table>
            <thead> 
        <tr>";
        for ($i = 0; count($data) > 0 && $i < count($data[0]); $i++) {
            $html .= "<th>" . $data[0][$i] . "</th>";
        }

        $html .= "</tr>
    </thead>
    <tbody>";
        for ($i = 0; $i < count($data); $i++) {
            $html .= "<tr>";
            foreach ($data[$i] as $key => $val) {
                $html .= "<td>$val</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";

        return $html;
    }

    public function makePage($sql)
    {
        $table = $this->drawTable($sql);
        require($this->name . ".php");
    }
}
