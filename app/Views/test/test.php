<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class=" debug container my-5">
    <pre>
        <?=print_r($test, true) ?>
    </pre>
</div>
<?= $this->endSection() ?>