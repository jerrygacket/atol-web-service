<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "printers".
 *
 * @property int $id
 * @property string $printer_id
 * @property string $printer_name
 * @property string $description
 * @property string $connect_string
 * @property string $created_on
 * @property string $updated_on
 */
class PrintersBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'printers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['printer_id', 'printer_name', 'connect_string'], 'required'],
            [['description'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['printer_id', 'printer_name', 'connect_string'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'printer_id' => Yii::t('app', 'Printer ID'),
            'printer_name' => Yii::t('app', 'Printer Name'),
            'description' => Yii::t('app', 'Description'),
            'connect_string' => Yii::t('app', 'Connect String'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }
}
