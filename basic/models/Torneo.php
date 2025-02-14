<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "torneo".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $participantes_max
 * @property int $disciplina_id
 * @property int $tipo_torneo_id
 * @property int $clase_id
 * @property int $fecha_inicio
 * @property int $fecha_limite
 *
 * @property Categoria[] $categorias
 * @property Clase $clase
 * @property Disciplina $disciplina
 * @property Equipo[] $equipos
 * @property Imagen[] $imagens
 * @property Normativa[] $normativas
 * @property Partido[] $partidos
 * @property Premio[] $premios
 * @property TipoTorneo $tipoTorneo
 * @property TorneoCategoria[] $torneoCategorias
 * @property TorneoEquipo[] $torneoEquipos
 * @property TorneoImagen[] $torneoImagens
 * @property TorneoNormativa[] $torneoNormativas
 */
class Torneo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public static function tableName()
    {
        return 'torneo';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'participantes_max', 'disciplina_id', 'tipo_torneo_id', 'clase_id'], 'required'],
            [['participantes_max', 'disciplina_id', 'tipo_torneo_id', 'clase_id'], 'integer'],
            [['fecha_inicio', 'fecha_limite'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 1000],
            [['disciplina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Disciplina::class, 'targetAttribute' => ['disciplina_id' => 'id']],
            [['tipo_torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTorneo::class, 'targetAttribute' => ['tipo_torneo_id' => 'id']],
            [['clase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clase::class, 'targetAttribute' => ['clase_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'participantes_max' => 'Participantes Max',
            'disciplina_id' => 'Disciplina ID',
            'tipo_torneo_id' => 'Tipo Torneo ID',
            'clase_id' => 'Clase ID',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_limite' => 'Fecha Limite',
        ];
    }
    
    public function subirImagen($destino)
    {
        if ($this->validate()) {
            $destino = \Yii::getAlias('@webroot') . '/' . $destino;
            if (!is_dir($destino)) {
                mkdir($destino, 0777, true);
            }
            $rutaFichero = $destino . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return $this->imageFile->saveAs($rutaFichero);
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery|CategoriaQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['id' => 'categoria_id'])->viaTable('torneo_categoria', ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[Clase]].
     *
     * @return \yii\db\ActiveQuery|ClaseQuery
     */
    public function getClase()
    {
        return $this->hasOne(Clase::class, ['id' => 'clase_id']);
    }

    /**
     * Gets query for [[Disciplina]].
     *
     * @return \yii\db\ActiveQuery|DisciplinaQuery
     */
    public function getDisciplina()
    {
        return $this->hasOne(Disciplina::class, ['id' => 'disciplina_id']);
    }

    /**
     * Gets query for [[Equipos]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::class, ['id' => 'equipo_id'])->viaTable('torneo_equipo', ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery|ImagenQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagen::class, ['id' => 'imagen_id'])->viaTable('torneo_imagen', ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[Normativas]].
     *
     * @return \yii\db\ActiveQuery|NormativaQuery
     */
    public function getNormativas()
    {
        return $this->hasMany(Normativa::class, ['id' => 'normativa_id'])->viaTable('torneo_normativa', ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[Partidos]].
     *
     * @return \yii\db\ActiveQuery|PartidoQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partido::class, ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[Premios]].
     *
     * @return \yii\db\ActiveQuery|PremioQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premio::class, ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[TipoTorneo]].
     *
     * @return \yii\db\ActiveQuery|TipoTorneoQuery
     */
    public function getTipoTorneo()
    {
        return $this->hasOne(TipoTorneo::class, ['id' => 'tipo_torneo_id']);
    }

    /**
     * Gets query for [[TorneoCategorias]].
     *
     * @return \yii\db\ActiveQuery|TorneoCategoriaQuery
     */
    public function getTorneoCategorias()
    {
        return $this->hasMany(TorneoCategoria::class, ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoEquipos]].
     *
     * @return \yii\db\ActiveQuery|TorneoEquipoQuery
     */
    public function getTorneoEquipos()
    {
        return $this->hasMany(TorneoEquipo::class, ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoImagens]].
     *
     * @return \yii\db\ActiveQuery|TorneoImagenQuery
     */
    public function getTorneoImagens()
    {
        return $this->hasMany(TorneoImagen::class, ['torneo_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoNormativas]].
     *
     * @return \yii\db\ActiveQuery|TorneoNormativaQuery
     */
    public function getTorneoNormativas()
    {
        return $this->hasMany(TorneoNormativa::class, ['torneo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TorneoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TorneoQuery(get_called_class());
    }
}