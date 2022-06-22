<?php
require("controllers/Page.php");

$name = basename($_SERVER['REQUEST_URI']);

$page = new Page($name);

//"info o klientach + wykupione pakiety + osoby kontaktowe + opiekunowie"; 
switch ($name) {
    case 'clients': {
            $sql = "SELECT 
                c.name as name, 
                c.lastname as lastname, 
                c.email as email, 
                p.name as packageName, 
                p.description as Packagedescription, 
                co.contacs
            FROM transactions T
            INNER JOIN clients c ON t.id_client = c.client 
            INNER JOIN package p ON t.id_package = p.package 
            INNER JOIN 
                (SELECT  DISTINCT ct.id as id, GROUP_CONCAT((con.name || ' ' || con.lastname ||' ' ||  con.email),'\n') contacs 
                FROM contactsteam ct 
            INNER JOIN contacts con ON ct.id_contact = con.id GROUP by id) co ON t.id_contactsteam = co.id
            ";


        }
        break;

        //info o klientach danej osoby
        case 'employees':{
            $id_employee = $_GET["id_employee"];
            $sql = "SELECT c.name, c.lastname, c.email, package.id , t.date_paid,  t.date_start,  t.date_end FROM "
        }

    default:
        # code...
        break;
}
$page->makePage($sql);
