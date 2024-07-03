<?php namespace LucasPalomba\SlugField\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * SlugField Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class SlugField extends FormWidgetBase
{
    use \Backend\Traits\FormModelWidget;

    protected $defaultAlias = 'slugfield';

    public $alias = 'SlugField';

    public $link = null;

    public function init()
    {
        $this->fillFromConfig([
            'link'
        ]);
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('slugfield');
    }

    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        // on récupère la config du link et on ajoute la valeur, 
        // tout en verifiatn que le link est bien une URL valide et si besoin on ajoute un slash
        if ($this->link && filter_var($this->link, FILTER_VALIDATE_URL)) {
            $link = rtrim($this->link, '/') . '/' . $this->vars['value'];
        } else {
            $link = null;
        }

        $this->vars['link'] = $link;
    }

    public function loadAssets()
    {
        $this->addCss('css/slugfield.css');
        $this->addJs('js/slugfield.js');
    }

    public function getSaveValue($value)
    {
        return $value;
    }

    public function onRefreshSlug(){
        $newValue = post($this->formField->arrayName.'['.$this->formField->preset['field'].']');
        // on passe $newValue dans la fonction selon le type du preset (slug, camel)
        $newValue = ($this->formField->preset['type'] == 'slug') ? str_slug($newValue) : camel_case($newValue);

        $this->model->{$this->formField->fieldName} = $newValue;
        $this->model->slugAttributes();
        //not necessary to save model now
        //$this->model->save();

        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->model->{$this->formField->fieldName};
        $this->vars['model'] = $this->model;
        // on récupère la config du link et on ajoute la valeur, 
        // tout en verifiatn que le link est bien une URL valide et si besoin on ajoute un slash
        if ($this->link && filter_var($this->link, FILTER_VALIDATE_URL)) {
            $link = rtrim($this->link, '/') . '/' . $this->vars['value'];
        } else {
            $link = null;
        }

        $this->vars['link'] = $link;
 
        // et on retourne le champs pour la mise a jour de l'input
        return [
            '#' . $this->getId('input') . '_container' => $this->makePartial('slug_input')
        ];

        

    }

}
