<?php

declare(strict_types=1);

namespace kilyanov\ajax\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\web\YiiAsset;

/**
 * Class AjaxAsset
 * @package kilyanov\ajax
 */
class AjaxAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@kilyanov/ajax/assets/dist';

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        'ModalRemote.js',
        'ajaxcrud.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class
    ];

    /**
     * @param View $view
     */
    public function registerAssetFiles($view): void
    {
        parent::registerAssetFiles($view);
    }
}
