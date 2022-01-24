<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once 'frontcontroller.php';

$faker = Faker\Factory::create();
$pdo = new PDO ('mysql:host=localhost;dbname=test1;charset=utf8', 'root', 'root');
$queryFactory = new \Aura\SqlQuery\QueryFactory('mysql');
exit;
/*$insert = $queryFactory->newInsert();
$insert->into('posts2');
for ($i=0; $i < 5; $i++) {
    $insert->cols([
        'title' => $faker->words(3, true),
        'content' => $faker->text
    ]);
    $insert->addRow();
}

$insert->getStatement();

$sth = $pdo->prepare($insert->getStatement());
$sth->execute($insert->getBindValues());
die('Отработал!');*/

$select = $queryFactory->newSelect();
$select
    ->cols(['*'])
    ->from('posts')
    ->setPaging(10)
    ->page($_GET['page'] ?? 1);
$sth = $pdo->prepare($select->getStatement());
$sth->execute($select->getBindValues());
$items = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $pdo->prepare('SELECT COUNT(*) FROM posts');
$sth->execute();

$totalItems = (int)$sth->fetch()[0];
$itemPerPage = 10;
$currentPage = $_GET['page'] ?? 1;
$urlPattern = '?page=(:num)';


$paginator = new \JasonGrimes\Paginator($totalItems, $itemPerPage, $currentPage, $urlPattern);
foreach ($items as $item) {
    echo $item['id'] . PHP_EOL . $item['title'] . '<br>';
}

 ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<?=$paginator; ?>
</body>
</html>
