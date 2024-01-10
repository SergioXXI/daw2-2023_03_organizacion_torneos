<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%imagen}}".
 *
 * @property int $id
 * @property string $ruta
 *
 * @property Clase[] $clases
 * @property Participante[] $participantes
 * @property TorneoImagen[] $torneoImagens
 * @property Torneo[] $torneos
 */
class Imagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%imagen}}';
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
     * Gets query for [[Clases]].
     *
     * @return \yii\db\ActiveQuery|ClaseQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clase::class, ['imagen_id' => 'id']);
    }

    /**
     * Gets query for [[Participantes]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['imagen_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoImagens]].
     *
     * @return \yii\db\ActiveQuery|TorneoImagenQuery
     */
    public function getTorneoImagens()
    {
        return $this->hasMany(TorneoImagen::class, ['imagen_id' => 'id']);
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['id' => 'torneo_id'])->viaTable('{{%torneo_imagen}}', ['imagen_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ImagenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImagenQuery(get_called_class());
    }
}
