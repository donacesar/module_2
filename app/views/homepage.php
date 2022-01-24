<?php
$this->layout('layout', ['title' => 'Home Page']) ?>

<h1>Home Page</h1>
<?php foreach ($posts as $post):?>
<?=$post['title'];?>
<br>
<?php endforeach;?>