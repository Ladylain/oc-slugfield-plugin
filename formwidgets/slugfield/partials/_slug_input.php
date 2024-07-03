<div class="input-group slug-field">
    <input type="text" class="form-control" 
    id="<?= $this->getId('input') ?>"
    name="<?= $name ?>"
    value="<?= $value ?>"
    autocomplete="off">
    <div class="input-group-append">
        <button data-control="tooltip" title="Régénerer le lien" type="button" class="btn btn-sm btn-outline-secondary" data-request="<?= $this->getEventHandler('onRefreshSlug') ?>">
            <i class="icon-refresh" ></i>
        </button>

    </div>
    
</div>
<?php if(isset($link)): ?>
    <small class="form-text text-muted ps-2 pt-1" style="display: flex !important;gap: 1rem;">
    <span style="">Lien de prévisualisation:</span> 
    <a href="<?= $link ?>" target="_blank" style="
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
    "><?= $link ?></a>
    </small>
<?php endif ?>