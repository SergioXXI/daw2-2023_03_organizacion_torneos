<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partido".
 *
 * @property int $id
 * @property int $jornada
 * @property string $fecha
 * @property int $torneo_id
 * @property int $direccion_id
 *
 * @property Direccion $direccion
 * @property Equipo[] $equipos
 * @property PartidoEquipo[] $partidoEquipos
 * @property Torneo $torneo
 */
class Partido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jornada', 'torneo_id', 'direccion_id'], 'required'],
            [['jornada', 'torneo_id', 'direccion_id'], 'integer'],
            [['fecha'], 'safe'],
            [['torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torneo::class, 'targetAttribute' => ['torneo_id' => 'id']],
            [['direccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direccion::class, 'targetAttribute' => ['direccion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jornada' => Yii::t('app', 'Jornada'),
            'fecha' => Yii::t('app', 'Fecha'),
            'torneo_id' => Yii::t('app', 'Torneo ID'),
            'direccion_id' => Yii::t('app', 'Direccion ID'),
        ];
    }

    /**
     * Gets query for [[Direccion]].
     *
     * @return \yii\db\ActiveQuery|DireccionQuery
     */
    public function getDireccion()
    {
        return $this->hasOne(Direccion::class, ['id' => 'direccion_id']);
    }

    /**
     * Gets query for [[Equipos]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::class, ['id' => 'equipo_id'])->viaTable('partido_equipo', ['partido_id' => 'id']);
    }

    /**
     * Gets query for [[PartidoEquipos]].
     *
     * @return \yii\db\ActiveQuery|PartidoEquipoQuery
     */
    public function getPartidoEquipos()
    {
        return $this->hasMany(PartidoEquipo::class, ['partido_id' => 'id']);
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
     * @return PartidoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PartidoQuery(get_called_class());
    }
}
