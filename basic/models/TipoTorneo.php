<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tipo_torneo}}".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Torneo[] $torneos
 */
class TipoTorneo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tipo_torneo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['tipo_torneo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TipoTorneoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipoTorneoQuery(get_called_class());
    }
}
