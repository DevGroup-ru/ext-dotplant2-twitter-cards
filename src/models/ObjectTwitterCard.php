<?php

namespace DotPlant\TwitterCards\models;

use Yii;

/**
 * This is the model class for table "{{%object_twitter_card}}".
 *
 * @property integer $id
 * @property integer $object_id
 * @property integer $object_model_id
 * @property integer $active
 * @property string $title
 * @property string $description
 * @property string $image
 */
class ObjectTwitterCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%object_twitter_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'object_model_id', 'title', 'description'], 'required', 'enableClientValidation'=>false],
            [['object_id', 'object_model_id', 'active'], 'integer'],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
            'object_model_id' => 'Object Model ID',
            'active' => 'Active',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
        ];
    }
}
