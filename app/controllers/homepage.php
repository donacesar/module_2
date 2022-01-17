<?php

use App\QueryBuilder;

$db = new QueryBuilder();

//$db->update('posts', 14, ['title' => 'new post from aura SqlQuery14']);
$db->delete('posts', 15);
$posts = $db->getAll('posts');
//$post = $db->getOne('posts', 11);
var_dump($posts);
