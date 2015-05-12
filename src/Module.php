<?php

namespace DotPlant\TwitterCards;

use app;
use app\components\ExtensionModule;
use Yii;

/**
 * Class Module represents twitter cards module for DotPlant2 CMS
 *
 * @package DotPlant\TwitterCards
 */
class Module extends ExtensionModule
{
    public static $moduleId = 'twitterCards';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'configurableModule' => [
                'class' => 'app\modules\config\behaviors\ConfigurableModuleBehavior',
                'configurationView' => '@twitterCards/views/configurable/_config',
                'configurableModel' => 'DotPlant\TwitterCards\components\ConfigurationModel',
            ]
        ];
    }

}