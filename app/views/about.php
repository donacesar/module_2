<?php
$this->layout('layout', ['title' => 'About']) ?>
<?=flash()->display();?>
<h1>About</h1>
<p>About <?= $this->e($name) ?></p>