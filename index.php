<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once 'Controller.php';
$manager = new Controller();
?>
<link rel="stylesheet" href="index.css">

<?php

$amount = 15;
$links = 0;
if (array_key_exists('amount', $_GET)) {
    if ((int)$_GET['amount'] == $_GET['amount'] && $_GET['amount'] > 0) {
        $amount = $_GET['amount'];
    }
    $content = json_encode(['amount' => $amount, 'links' => [$links]]);
    file_put_contents('db.json', $content);
}

?>

<form action="" method="get">
    <input type="number" name="amount" value="<?= $amount ?>">
    <button>Submit</button>
</form>

<?php

if (file_exists('db.json')) {
    $db = json_decode(file_get_contents('db.json'), true);
    $amount = $db['amount'];
}

$id_key = @$_GET['id'];

if (array_key_exists('id', $_GET) && !array_key_exists($id_key, $db['links'])) {
    if ($_GET['id'] % 3 === 0) {
        $new_value = $_GET['id'] + 1;
        $manager->add($id_key, $new_value);
    }
}

if (array_key_exists($id_key, $db['links'])) {
    $new_value = $db['links'][$id_key] + 1;
    $manager->add($id_key, $new_value);
}

$db = json_decode(file_get_contents('db.json'), true);


for ($i = 1; $i <= $amount; $i++) {
    if ($i % 2 == 0) {
        echo "<button class='green'><a href='?id=$i'>";
        if ($i % 3 == 0 && array_key_exists($i, $db['links'])) {
            echo $db['links'][$i];
        } else {
            echo $i;
        }
        echo '</a></button>';
    } else {
        echo "<button><a href='?id=$i'>";
        if ($i % 3 == 0 && array_key_exists($i, $db['links'])) {
            echo $db['links'][$i];
        } else {
            echo $i;
        }
        echo "</a></button>";
    }
}

?>