<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%participante}}".
 *
 * @property int $id
 * @property string $fecha_nacimiento
 * @property string $licencia
 * @property int $tipo_participante_id
 * @property int|null $imagen_id
 * @property int|null $usuario_id
 *
 * @property Documento[] $documentos
 * @property EquipoParticipante[] $equipoParticipantes
 * @property Equipo[] $equipos
 * @property Imagen $imagen
 * @property ParticipanteDocumento[] $participanteDocumentos
 * @property TipoParticipante $tipoParticipante
 * @property Usuario $usuario
 */
class Participante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%participante}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento', 'licencia', 'tipo_participante_id'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['tipo_participante_id', 'imagen_id', 'usuario_id'], 'integer'],
            [['licencia'], 'string', 'max' => 250],
            [['licencia'], 'unique'],
            [['usuario_id'], 'unique'],
            [['tipo_participante_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoParticipante::class, 'targetAttribute' => ['tipo_participante_id' => 'id']],
            [['imagen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['imagen_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'licencia' => Yii::t('app', 'Licencia'),
            'tipo_participante_id' => Yii::t('app', 'Tipo Participante ID'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
        ];
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery|DocumentoQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::class, ['id' => 'documento_id'])->viaTable('{{%participante_documento}}', ['participante_id' => 'id']);
    }

    /**
     * Gets query for [[EquipoParticipantes]].
     *
     * @return \yii\db\ActiveQuery|EquipoParticipanteQuery
     */
    public function getEquipoParticipantes()
    {
        return $this->hasMany(EquipoParticipante::class, ['participante_id' => 'id']);
    }

    /**
     * Gets query for [[Equipos]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::class, ['id' => 'equipo_id'])->viaTable('{{%equipo_participante}}', ['participante_id' => 'id']);
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
     * Gets query for [[ParticipanteDocumentos]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteDocumentoQuery
     */
    public function getParticipanteDocumentos()
    {
        return $this->hasMany(ParticipanteDocumento::class, ['participante_id' => 'id']);
    }

    /**
     * Gets query for [[TipoParticipante]].
     *
     * @return \yii\db\ActiveQuery|TipoParticipanteQuery
     */
    public function getTipoParticipante()
    {
        return $this->hasOne(TipoParticipante::class, ['id' => 'tipo_participante_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return ParticipanteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParticipanteQuery(get_called_class());
    }
}
