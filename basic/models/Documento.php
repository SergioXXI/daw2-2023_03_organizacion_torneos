<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%documento}}".
 *
 * @property int $id
 * @property string $ruta
 *
 * @property Normativa[] $normativas
 * @property ParticipanteDocumento[] $participanteDocumentos
 * @property Participante[] $participantes
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%documento}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ruta'], 'required'],
            [['ruta'], 'string', 'max' => 250],
            [['ruta'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ruta' => Yii::t('app', 'Ruta'),
        ];
    }

    /**
     * Gets query for [[Normativas]].
     *
     * @return \yii\db\ActiveQuery|NormativaQuery
     */
    public function getNormativas()
    {
        return $this->hasMany(Normativa::class, ['documento_id' => 'id']);
    }

    /**
     * Gets query for [[ParticipanteDocumentos]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteDocumentoQuery
     */
    public function getParticipanteDocumentos()
    {
        return $this->hasMany(ParticipanteDocumento::class, ['documento_id' => 'id']);
    }

    /**
     * Gets query for [[Participantes]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['id' => 'participante_id'])->viaTable('{{%participante_documento}}', ['documento_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DocumentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentoQuery(get_called_class());
    }
}
