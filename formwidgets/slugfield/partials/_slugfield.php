<?php if ($this->previewMode): ?>

    <div class="form-control">
        <?= $value ?>
    </div>

<?php else: ?>
    <div id="<?= $this->getId('input') ?>_container">
        <?= $this->makePartial('slug_input') ?>
    </div>
<?php endif ?>
