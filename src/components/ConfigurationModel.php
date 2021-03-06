<?php

namespace DotPlant\TwitterCards\components;

use app\modules\config\models\BaseConfigurationModel;

class ConfigurationModel extends BaseConfigurationModel
{

    public $twitter_acount;

    public $jsonProductData;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twitter_acount', 'jsonProductData'], 'required'],
            [['twitter_acount'], 'match', 'pattern' => '/@([A-Za-z0-9_]{1,15})/']
        ];
    }

    public function beforeValidate()
    {
        if (\Yii::$app->request->post('data')) {
            $this->jsonProductData = json_encode(\Yii::$app->request->post('data'));
        }
        return parent::beforeValidate();
    }

    /**
     * Fills model attributes with default values
     * @return void
     */
    public function defaultValues()
    {

    }

    /**
     * Returns array of module configuration that should be stored in application config.
     * Array should be ready to merge in app config.
     * Used both for web only.
     *
     * @return array
     */
    public function webApplicationAttributes()
    {
        return [
            'modules' => [
                'twitterCards' => [
                    'class' => 'DotPlant\TwitterCards\Module',
                    'twitter_acount' => $this->twitter_acount,
                    'jsonProductData' => $this->jsonProductData
                ],
            ],
            'bootstrap' => [
                'twitterCards' => 'twitterCards',
            ],
        ];
    }

    /**
     * Returns array of module configuration that should be stored in application config.
     * Array should be ready to merge in app config.
     * Used both for console only.
     *
     * @return array
     */
    public function consoleApplicationAttributes()
    {
        return [];
    }

    /**
     * Returns array of module configuration that should be stored in application config.
     * Array should be ready to merge in app config.
     * Used both for web and console.
     *
     * @return array
     */
    public function commonApplicationAttributes()
    {
        return [];
    }

    /**
     * Returns array of key=>values for configuration.
     *
     * @return mixed
     */
    public function keyValueAttributes()
    {
        return [];
    }

    /**
     * Returns array of aliases that should be set in common config
     * @return array
     */
    public function aliases()
    {
        return [
            '@twitterCards' => realpath(dirname(__FILE__).'/../'),
        ];
    }
}