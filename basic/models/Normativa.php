<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%normativa}}".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $documento_id
 *
 * @property Documento $documento
 * @property TorneoNormativa[] $torneoNormativas
 * @property Torneo[] $torneos
 */
class Normativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%normativa}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'documento_id'], 'required'],
            [['documento_id'], 'integer'],
            [['nombre'], 'string', 'max' => 250],
            [['descripcion'], 'string', 'max' => 1000],
            [['nombre'], 'unique'],
            [['documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Documento::class, 'targetAttribute' => ['documento_id' => 'id']],
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
            'documento_id' => Yii::t('app', 'Documento ID'),
        ];
    }

    /**
     * Gets query for [[Documento]].
     *
     * @return \yii\db\ActiveQuery|DocumentoQuery
     */
    public function getDocumento()
    {
        return $this->hasOne(Documento::class, ['id' => 'documento_id']);
    }

    /**
     * Gets query for [[TorneoNormativas]].
     *
     * @return \yii\db\ActiveQuery|TorneoNormativaQuery
     */
    public function getTorneoNormativas()
    {
        return $this->hasMany(TorneoNormativa::class, ['normativa_id' => 'id']);
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['id' => 'torneo_id'])->viaTable('{{%torneo_normativa}}', ['normativa_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return NormativaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NormativaQuery(get_called_class());
    }
}
