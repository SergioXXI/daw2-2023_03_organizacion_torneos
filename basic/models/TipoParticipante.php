<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tipo_participante}}".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 *
 * @property Participante[] $participantes
 */
class TipoParticipante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tipo_participante}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 500],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[Participantes]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['tipo_participante_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TipoParticipanteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipoParticipanteQuery(get_called_class());
    }
}
