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
        if (!$this->link) {
            return null;
        }
    
        if (filter_var($this->link, FILTER_VALIDATE_URL)) {
            return rtrim($this->link, '/') . '/' . $this->vars['field']->value;
        }
    
        if (!preg_match("/^page\((.*?)\)$/", $this->link, $matches)) {
            return null;
        }
    
        // Si le lien est une fonction page(), générer le lien vers cette page
        //on recupere tout ce qu'il y a dans la fonction page()
        $matches = explode(',', $matches[1]);
        // le premier match est forcement la page
        // le second est forcement le parametre de la page
        // les suivants si il y en a doivent etre au format key:value et seront ajoutés en parametre de la page
        $pageName = trim($matches[0], " '\"");
        $params = [];
        $paramName = trim($matches[1], " '\"");
    
        $params[$paramName] = $this->vars['field']->value;
        // pour chaque parametre on ajoute le parametre a la page
        $this->addParams($matches, $params);
    
        return Cms::pageUrl($pageName, $params);
    }

    private function addParams($matches, &$params) {
        if (count($matches) <= 2) {
            return;
        }
    
        foreach ($matches as $key => $value) {
            if ($key <= 1) {
                continue;
            }
    
            $param = explode(':', $value);
            $paramName = trim($param[0], " '\"");
            $paramValue = trim($param[1], " '\"");
            // le format sera $key => $value
            $params[$paramName] = $this->model->{$paramValue};
        }
    }

}
