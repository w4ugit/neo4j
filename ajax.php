<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
require('vendor/autoload.php');

use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Relationship;

$client = new Everyman\Neo4j\Client('localhost', 7474);//подключение к базе

switch ($_POST['flag']) {
    case 'all':
        $arr = [];
        $queryString = "MATCH (n) RETURN n";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
        $result = $query->getResultSet();
        foreach ($result as $row) {
            $id = $row['x']->getId();
            $item = $client->getNode($id);
            $rel = $item->getRelationships();
            foreach ($rel as $q) {
                $x = $q->getStartNode()->getId();
                $y = $q->getEndNode()->getId();
                if ($x == $id) {
                    $info = $client->getNode($y);
                    $arr['nodes'][] = array("name" => $row['x']->getProperty('text'), "color" => $row['x']->getProperty('type'));
                    $arr['edges'][] = array("src" => $row['x']->getProperty('text'), "dest" => $info->getProperty('text'));
                } else {
                    $info = $client->getNode($y);
                    $arr['nodes'][] = array("name" => $row['x']->getProperty('text'), "color" => $info->getProperty('type'));
                    $arr['edges'][] = array("src" => $info->getProperty('text'), "dest" => $row['x']->getProperty('text'));
                }
            }
        }
        echo json_encode($arr);
        break;

    case 'all-2':
        $arr = [];
        $queryString = "MATCH (n) RETURN n";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
        $result = $query->getResultSet();
        foreach ($result as $row) {
            $id = $row['x']->getId();
            $item = $client->getNode($id);
            $rel = $item->getRelationships();
            $arr['shapes'][] = array(
                "id" => "$id",
                "content" => ["text" => $item->getProperty('text')],
                "type" => "circle",
                "stroke" => ["width" => "1", "color" => "black"],
                "width" => 50,
                "height" => 50,
                "fill" => $item->getProperty('type')
            );
            foreach ($rel as $q) {
                $x = $q->getStartNode()->getId();
                $y = $q->getEndNode()->getId();
                if ($x == $id) {
                    $info = $client->getNode($y);
                    $arr['connect'][] = array(
                        "from" => "$id",
                        "to" => "{$info->getId()}",
                        "endCap" => ["type" => "ArrowStart"]
                    );
                } else {
                    $info = $client->getNode($x);
                    $arr['connect'][] = array(
                        "from" => "{$info->getId()}",
                        "to" => "$id",
                        "endCap" => ["type" => "ArrowStart"]
                    );
                }
            }
        }
        echo json_encode($arr);
        break;

    case 'search':
        $queryString = 'MATCH (n) WHERE n.text = "' . $_POST['node'] . '" RETURN n';
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
        $result = $query->getResultSet();
        $arr = [];
        foreach ($result as $row) {
            $id = $row['x']->getId();
            $item = $client->getNode($id);
            $color = $item->getProperty('type');
            $rel = $item->getRelationships();
            foreach ($rel as $q) {
                $x = $q->getStartNode()->getId();
                $y = $q->getEndNode()->getId();
                if ($x == $id) {
                    $tar = $client->getNode($y);
                    $color_2 = $tar->getProperty('type');
                    $name_2 = $tar->getProperty('text');
                    if ($color == $color_2) {
                        $arr[] = $name_2;
                    }
                } else {
                    $tar = $client->getNode($x);
                    $color_2 = $tar->getProperty('type');
                    $name_2 = $tar->getProperty('text');
                    if ($color == $color_2) {
                        $arr[] = $name_2;
                    }
                }
            }
        }

        echo implode(', ', $arr);
        break;
}