<?php
include(dirname(__DIR__) . "/classes/Db.php");
class Page extends Db
{
    public $name;
    public function __construct(string $pagename = null)
    {
        $this->name = $pagename;
    }

    /**
     * Drawing table of data
     * @param string $sql - Select Query to displat data
     */
    public function drawTable($sql, $desc = "")
    {


        $data = $this->executeS($sql);

        if (!$data || count($data) == 0) {
            return "soory, This table is empty";
        }

        $html =  "
        <h3>".ucfirst($desc)."</h3>
        <table id='datatable'>
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
        $desc = "";
        //"info o klientach + wykupione pakiety + osoby kontaktowe + opiekunowie"; 
        switch ($this->name) {
            case "client": {
                    $sql = "SELECT 
                c.name as name, 
                c.lastname as lastname, 
                c.email as email, 
                p.name as 'package Name', 
                p.description as 'Package description', 
                co.contacs
            FROM transactions t
            INNER JOIN clients c ON t.id_client = c.id 
            INNER JOIN package p ON t.id_package = p.id 
            INNER JOIN 
                (SELECT  DISTINCT id, GROUP_CONCAT((con.name || ' ' || con.lastname ||' ' ||  con.email),'\n') contacs 
                FROM contactsteam ct 
            INNER JOIN contacts con ON ct.id_contact = con.id GROUP by id) co ON t.id_contactsteam = co.id
            ";
            $desc = "info about clients and their bought packages + contacts + employee";
                }
                break;

            case "employee": {
                    $id_employee = $_GET["employeeid"] ?? null;
                    if($id_employee==NULL)
                    {
                        $sql = "SELECT 
                        '<a href=\"index.php?action=employee&employeeid=' || id || ' \"> ' ||id || '</a>' as id, name, lastname, email, job, section
                        FROM employees";
                        $desc = "list of emplyees (click id for see details)";
                    }
                    else{                //info o klientach danej osoby

                        $sql = "SELECT c.name, c.lastname as 'last name', c.email, p.id as 'package id', t.date_paid 'packade date paid',  t.date_start as 'package date start',  t.date_end as 'package date end'
                        FROM transactions t 
                        INNER JOIN clients c ON t.id_client = c.id
                        INNER JOIN package p ON t.id_package = p.id 
                        where t.id_employee = $id_employee";
                        $desc = "employee customer list";

                    }

                }
                break;

                //info o osobach kontaktowych
            case "contacts": {
                    $sql = "SELECT name, lastname, email, phone, NIP from contacts";
                    $desc = "list of contacts";

                }
                break;

                //informacje o dostępnych pakietach
            case "package": {
                    $sql = "SELECT name , description , packagetime as 'package time'  from package where active = 1";
                    $desc = "list of active packages";

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

        $table = $this->drawTable($sql, $desc);
        require(dirname(__DIR__) . "/views/template/table.php");
    }
}
