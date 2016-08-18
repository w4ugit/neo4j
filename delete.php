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
    case 'node_delete':
        $item = $client->getNode($_REQUEST['id']);
        $item -> delete();
        break;

    case 'rel_list':
        $item = $client->getNode($_REQUEST['id']);
        $rel = $item->getRelationships();
        print_r($rel);
        break;

    case 'rel_delete':
        $rel_del = $client->getRelationship($_REQUEST['id']);
        $rel_del->delete();
        break;

    case 'all':
        for ($i=101;$i<=200;$i++){
            $rel_del = $client->getRelationship($i);
            if ($rel_del!='') {
                $rel_del->delete();
            }
        }
        break;
}