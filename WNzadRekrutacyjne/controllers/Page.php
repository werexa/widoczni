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

        if ($data || count($data) == 0) {
            return "soory, This table is empty";
        }

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

    public function makePage()
    {
        //"info o klientach + wykupione pakiety + osoby kontaktowe + opiekunowie"; 
        switch ($this->name) {
            case 'client': {
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
            case 'employee': {
                    $id_employee = $_GET["employeeid"];
                    $sql = "SELECT c.name, c.lastname, c.email, package.id , t.date_paid,  t.date_start,  t.date_end 
            FROM transactions t
            INNER JOIN clients c ON t.id_client = c.id,
            INNER JOIN package p ON t.id_package = p.id 
            where t.id_employee = $id_employee";
                }

                //info o osobach kontaktowych
            case 'contacts': {
                    $sql = "SELECT name, lastname, email, phone, NIP from contacts";
                }

                //informacje o dostępnych pakietach
            case "package": {
                    $sql = "SELECT name , description , packagetime  from package where active = 1";
                }

            default:
                $sql = "";
                break;
        }

        if (empty($sql) || empty($this->name))
            require(dirname(__DIR__) . "/views/template/main.php");

        $table = $this->drawTable($sql);
        require(dirname(__DIR__) . "/views/template/table.php");
    }
}
