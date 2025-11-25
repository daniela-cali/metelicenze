<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1>
<pre>
<?= print_r($clienti, true); ?>
</pre>
<?= $this->endSection() ?>
