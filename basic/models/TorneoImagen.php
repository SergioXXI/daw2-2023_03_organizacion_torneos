<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%torneo_imagen}}".
 *
 * @property int $torneo_id
 * @property int $imagen_id
 *
 * @property Imagen $imagen
 * @property Torneo $torneo
 */
class TorneoImagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%torneo_imagen}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torneo_id', 'imagen_id'], 'required'],
            [['torneo_id', 'imagen_id'], 'integer'],
            [['torneo_id', 'imagen_id'], 'unique', 'targetAttribute' => ['torneo_id', 'imagen_id']],
            [['torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torneo::class, 'targetAttribute' => ['torneo_id' => 'id']],
            [['imagen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['imagen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'torneo_id' => Yii::t('app', 'Torneo ID'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
        ];
    }

    /**
     * Gets query for [[Imagen]].
     *
     * @return \yii\db\ActiveQuery|ImagenQuery
     */
    public function getImagen()
    {
        return $this->hasOne(Imagen::class, ['id' => 'imagen_id']);
    }

    /**
     * Gets query for [[Torneo]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneo()
    {
        return $this->hasOne(Torneo::class, ['id' => 'torneo_id']);
    }

    /**
     * {@inheritdoc}
     * @return TorneoImagenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TorneoImagenQuery(get_called_class());
    }
}
