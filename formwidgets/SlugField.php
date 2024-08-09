<?php namespace LucasPalomba\SlugField\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Cms;
use Flash;
use Lang;

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
        $this->vars['field'] = $this->formField;
        $this->vars['link'] = $this->makeLink($this->vars['field']->value);
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
        $this->vars['field'] = $this->formField;
        $this->vars['field']->value = $this->model->{$this->formField->fieldName};
        
        $this->vars['link'] = $this->makeLink($this->vars['field']->value);
        
        Flash::info(Lang::get('lucaspalomba.slugfield::lang.slug.refreshed'));
        // et on retourne le champs pour la mise a jour de l'input
        return [
            '#' . $this->getId('input') . '_container' => $this->makePartial('slug_input')
        ];
    }

    protected function makeLink($value){
        // on récupère la config du link et on ajoute la valeur,
        // tout en verifiatn que le link est bien une URL valide et si besoin on ajoute un slash
        if ($this->link) {
            if (preg_match("/^page\('(.*)',\s*'(.*)'\)$/", $this->link, $matches)) {
                // Si le lien est une fonction page(), générer le lien vers cette page
                $pageName = $matches[1];
                $paramName = $matches[2];
                $link = Cms::pageUrl($pageName, [$paramName => $this->vars['field']->value]);
            } elseif (filter_var($this->link, FILTER_VALIDATE_URL)) {
                // Si le lien est une URL valide
                $link = rtrim($this->link, '/') . '/' . $this->vars['field']->value;
            } else {
                $link = null;
            }
        } else {
            $link = null;
        }

        return $link;
    }

}
