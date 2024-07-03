<?php namespace LucasPalomba\SlugField;

use Backend;
use System\Classes\PluginBase;
use LucasPalomba\SlugField\FormWidgets\SlugField;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'SlugField',
            'description' => 'Enhance the slug field with a preview and a button to generate it automatically.',
            'author' => 'LucasPalomba',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

    }

    /**
     * registerFormWidgets
     */
    public function registerFormWidgets()
    {
        return [
            SlugField::class => [
                'code' => 'slugfield',
            ],
        ];
    }
}
