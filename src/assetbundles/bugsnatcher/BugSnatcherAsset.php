<?php
/**
 * BugSnatcher plugin for Craft CMS 3.x
 *
 * A handy plugin for catching and recording errors and exceptions. Also sends out notifications via Mail, Slack, Stride and SMS.
 *
 * @link      https://kaiserrobin.eu
 * @copyright Copyright (c) 2018 Robin Kaiser
 */

namespace kaiserwerk\bugsnatcher\assetbundles\BugSnatcher;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * BugSnatcherAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Robin Kaiser
 * @package   BugSnatcher
 * @since     1.0.0
 */
class BugSnatcherAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@kaiserwerk/bugsnatcher/assetbundles/bugsnatcher/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/BugSnatcher.js',
        ];

        $this->css = [
            'css/BugSnatcher.css',
        ];

        parent::init();
    }
}
