<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partido_equipo".
 *
 * @property int $partido_id
 * @property int $equipo_id
 * @property int $puntos Puntos de ese equipo en ese partido
 *
 * @property Equipo $equipo
 * @property Partido $partido
 */
class PartidoEquipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partido_equipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partido_id', 'equipo_id', 'puntos'], 'required'],
            [['partido_id', 'equipo_id', 'puntos'], 'integer'],
            [['partido_id', 'equipo_id'], 'unique', 'targetAttribute' => ['partido_id', 'equipo_id']],
            [['partido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partido::class, 'targetAttribute' => ['partido_id' => 'id']],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'partido_id' => Yii::t('app', 'Partido ID'),
            'equipo_id' => Yii::t('app', 'Equipo ID'),
            'puntos' => Yii::t('app', 'Puntos'),
        ];
    }

    /**
     * Gets query for [[Equipo]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::class, ['id' => 'equipo_id']);
    }

    /**
     * Gets query for [[Partido]].
     *
     * @return \yii\db\ActiveQuery|PartidoQuery
     */
    public function getPartido()
    {
        return $this->hasOne(Partido::class, ['id' => 'partido_id']);
    }

    /**
     * {@inheritdoc}
     * @return PartidoEquipoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PartidoEquipoQuery(get_called_class());
    }
}
