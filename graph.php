<pre>
<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
require('vendor/autoload.php');

use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Relationship;

$client = new Everyman\Neo4j\Client('localhost', 7474);//подключение к базе

switch ($_REQUEST['action']){
    case 'select_all':
        $queryString = "MATCH (n) RETURN n";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
        $result = $query->getResultSet();
        foreach ($result as $row){
            $id=$row['x']->getId();
            $item = $client->getNode($id);
            //$item->delete();
            print_r($item);
        }
        break;

    case 'create_rel':
        $s1=$client->getNode(413);
//        $s4=$client->getNode(414);
//        $sr1=$client->getNode(415);
//        $sr2=$client->getNode(416);
//        $sr3=$client->getNode(417);
//        $sr4=$client->getNode(418);
//        $c2=$client->getNode(419);
//        $c3=$client->getNode(420);
//        $c4=$client->getNode(421);
//        $c8=$client->getNode(422);
//        $t2=$client->getNode(423);
        $c2_2=$client->getNode(424);
//        $sr1->relateTo($c2, 'IN')->save();
//        $sr2->relateTo($c2, 'IN')->save();
//        $sr3->relateTo($c3, 'IN')->save();
//        $sr4->relateTo($c4, 'IN')->save();
//        $c2->relateTo($s4, 'IN')->save();
//        $c2->relateTo($s1, 'IN')->save();
//        $c3->relateTo($s1, 'IN')->save();
//        $c3->relateTo($t2, 'IN')->save();
//        $c4->relateTo($s1, 'IN')->save();
//        $t2->relateTo($c4, 'IN')->save();
//        $s1->relateTo($c8, 'IN')->save();
//        $c8->relateTo($s4, 'IN')->save();
//        $sr2->relateTo($c2_2, 'IN')->save();
        $c2_2->relateTo($s1, 'IN')->save();
        break;

    case 'update_node':
        $character=$client->getNode($_REQUEST['id']);
        $character->removeProperty('text')
            ->setProperty('text', $_REQUEST['new_text'])
            ->save();
        break;
}
