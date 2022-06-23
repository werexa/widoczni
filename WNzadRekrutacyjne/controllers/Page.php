<?php
include(dirname(__DIR__) . "/classes/Db.php");
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

        if (!$data || count($data) == 0) {
            return "soory, This table is empty";
        }

        $html =  "<table id='datatable'>
            <thead> 
        <tr>";
        foreach ($data[0] as $key => $value) {
            $html .= "<th>$key</th>";
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

    public function makePage()
    {
        $sql = "";
        //"info o klientach + wykupione pakiety + osoby kontaktowe + opiekunowie"; 
        switch ($this->name) {
            case "client": {
                    $sql = "SELECT 
                c.name as name, 
                c.lastname as lastname, 
                c.email as email, 
                p.name as packageName, 
                p.description as Packagedescription, 
                co.contacs
            FROM transactions t
            INNER JOIN clients c ON t.id_client = c.id 
            INNER JOIN package p ON t.id_package = p.id 
            INNER JOIN 
                (SELECT  DISTINCT id, GROUP_CONCAT((con.name || ' ' || con.lastname ||' ' ||  con.email),'\n') contacs 
                FROM contactsteam ct 
            INNER JOIN contacts con ON ct.id_contact = con.id GROUP by id) co ON t.id_contactsteam = co.id
            ";
                }
                break;

                //info o klientach danej osoby
            case "employee": {
                    $id_employee = $_GET["employeeid"] ?? 1;
                    $sql = "SELECT c.name, c.lastname as 'last name', c.email, p.id as 'package id', t.date_paid 'packade date paid',  t.date_start as 'package date start',  t.date_end as 'package date end'
            FROM transactions t 
            INNER JOIN clients c ON t.id_client = c.id
            INNER JOIN package p ON t.id_package = p.id 
            where t.id_employee = $id_employee";
                }
                break;

                //info o osobach kontaktowych
            case "contacts": {
                    $sql = "SELECT name, lastname, email, phone, NIP from contacts";
                }
                break;

                //informacje o dostępnych pakietach
            case "package": {
                    $sql = "SELECT name , description , packagetime as 'package time'  from package where active = 1";
                }
                break;

            default:
                //$sql = "";
                break;
        }

        if (empty($sql) || empty($this->name)) {
            require(dirname(__DIR__) . "/views/template/main.php");
            return;
        }

        $table = $this->drawTable($sql);
        require(dirname(__DIR__) . "/views/template/table.php");
    }
}
