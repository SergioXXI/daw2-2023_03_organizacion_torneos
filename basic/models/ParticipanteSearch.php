<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Participante;


/**
 * ParticipanteSearch represents the model behind the search form of `app\models\Participante`.
 */
class ParticipanteSearch extends Participante
{

    public $nombreUsuario;
    public $apellido1Usuario;
    public $apellido2Usuario;
    public $nombreTipoParticipante;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'imagen_id', 'usuario_id'], 'integer'],
            [['fecha_nacimiento', 'licencia','nombreUsuario', 'apellido1Usuario', 'apellido2Usuario', 'nombreTipoParticipante'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Participante::find()->joinWith(['usuario', 'tipoParticipante']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $dataProvider->sort->attributes['nombreUsuario'] = [
            'asc' => ['usuario.nombre' => SORT_ASC],
            'desc' => ['usuario.nombre' => SORT_DESC],
        ];


        $dataProvider->sort->attributes['apellido1Usuario'] = [
            'asc' => ['usuario.apellido1' => SORT_ASC],
            'desc' => ['usuario.apellido1' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['apellido2Usuario'] = [
            'asc' => ['usuario.apellido2' => SORT_ASC],
            'desc' => ['usuario.apellido2' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['nombreTipoParticipante'] = [
            'asc' => ['tipo_participante.nombre' => SORT_ASC],
            'desc' => ['tipo_participante.nombre' => SORT_DESC],
        ];


        // grid filtering conditions
        $query->andFilterWhere([
            'participante.id' => $this->id,
            'participante.fecha_nacimiento' => $this->fecha_nacimiento,
            'participante.imagen_id' => $this->imagen_id,
            'participante.usuario_id' => $this->usuario_id,

        ]);
        $query->andFilterWhere(['like', 'usuario.nombre', $this->nombreUsuario])
              ->andFilterWhere(['like', 'usuario.apellido1', $this->apellido1Usuario])
              ->andFilterWhere(['like', 'usuario.apellido2', $this->apellido2Usuario]);


        $query->andFilterWhere(['like', 'tipo_participante.nombre', $this->nombreTipoParticipante]);

        $query->andFilterWhere(['like', 'licencia', $this->licencia]);

        return $dataProvider;
    }

}
