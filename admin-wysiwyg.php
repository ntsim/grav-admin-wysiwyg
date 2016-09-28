<?php
namespace Grav\Plugin;

use Grav\Common\Assets;
use Grav\Common\Page\Types;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class AdminWysiwygPlugin
 * @package Grav\Plugin
 */
class AdminWysiwygPlugin extends Plugin
{
    /**
     * Bump up the priority of our blueprints over the `admin` plugin.
     *
     * @var array
     */
    public $features = [
        'blueprints' => 10000,
    ];

    /**
     * @var string
     */
    private $theme;

    /**
     * @return array
     *
     * Core list of events that the plugin wants to listen to.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onTwigSiteVariables'  => ['onTwigSiteVariables', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Enable the main event we are interested in
        $this->enable([
            'onTwigTemplatePaths'       => ['onTwigTemplatePaths', 999],
        ]);

        // Get theme for admin
        $this->theme = $this->config->get('plugins.admin.theme', 'grav');
    }

    /**
     * Get list of form field types specified in this plugin. Only special types needs to be listed.
     *
     * @return array
     */
    public function getFormFieldTypes()
    {
        return [
            'wysiwyg' => [
                'input@' => false
            ],
        ];
    }

    /**
     * Add twig paths to plugin templates.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onTwigSiteVariables()
    {
        if (!$this->isAdmin()) {
            return;
        }

        $pluginBase = 'plugin://admin-wysiwyg';

        /** @var Assets $assets */
        $assets = $this->grav['assets'];
        $assets->addCss($pluginBase . '/css-compiled/trumbowyg.min.css', -10);
        $assets->addCss($pluginBase . '/css-compiled/wysiwyg.css', -11);

        $assets->addJs($pluginBase . '/js-compiled/trumbowyg.min.js', -10);
        $assets->addJs($pluginBase . '/node_modules/trumbowyg/plugins/preformatted/trumbowyg.preformatted.js', -11);
        $assets->addJs($pluginBase . '/node_modules/to-markdown/dist/to-markdown.js', -12);
        $assets->addJs($pluginBase . '/node_modules/showdown/dist/showdown.min.js', -13);
        $assets->addJs($pluginBase . '/js-compiled/wysiwyg.js', -14);
    }
}
