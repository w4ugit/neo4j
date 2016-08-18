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

/** построение нод */

/** S1 */
$s1 = $client->makeNode();
$s1->setProperty('text', 'S1')->setProperty('type', 'orange')->save();

/**
 * S4
 */
$s4 = $client->makeNode();
$s4->setProperty('text', 'S4')->setProperty('type', 'orange')->save();

/**
 * Sr1 - Sr4
 */
for ($i=1;$i<=4;$i++) {
    $sr='sr'.$i;
    $$sr = $client->makeNode();
    $$sr->setProperty('text', 'Sr'.$i)->setProperty('type', 'orange')->save();
}

/**
 * C2 - C4
 */
for ($i=2;$i<=4;$i++) {
    $c='c'.$i;
    $$c = $client->makeNode();
    $$c->setProperty('text', 'C'.$i)->setProperty('type', 'green')->save();
}

/** C2 еще раз */
$с2 = $client->makeNode();
$с2->setProperty('text', 'С2')->setProperty('type', 'green')->save();

/**
 * C8
 */
$c8 = $client->makeNode();
$c8->setProperty('text', 'C8')->setProperty('type', 'green')->save();

/**
 * T2
 */
$t2 = $client->makeNode();
$t2->setProperty('text', 'T2')->setProperty('type', 'blue')->save();
/** end построение нод */

?>