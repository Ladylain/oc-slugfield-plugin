<div class="input-group slug-field">
    <input 
        type="text" 
        class="form-control"
        id="<?= $field->getId() ?>"
        name="<?= $field->getName() ?>"
        value="<?= e($field->value) ?>"
        placeholder="<?= e(__($field->placeholder)) ?>"
        autocomplete="off"
        <?= $field->getAttributes() ?>
    />
    <div class="input-group-append">
        <button data-control="tooltip" data-request-complete="$(this).tooltip('dispose');" title="<?= Lang::get('lucaspalomba.slugfield::lang.slug.regenerate_tooltip'); ?>" type="button" class="btn btn-sm btn-outline-secondary" data-request="<?= $this->getEventHandler('onRefreshSlug') ?>">
            <i class="icon-refresh" ></i>
        </button>

    </div>
    
</div>
<?php if(isset($link)): ?>
    <small class="form-text text-muted ps-2 pt-1" style="display: flex !important;gap: 1rem;">
        <span style=""><?= Lang::get('lucaspalomba.slugfield::lang.slug.link_label'); ?>:</span>
        <a href="<?= $link ?>" target="_blank" aria-label="slug link" rel="noopener" style="
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            min-width: 0;
        "><?= $link ?></a>
    </small>
<?php endif ?>
