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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_participante_id', 'imagen_id', 'usuario_id'], 'integer'],
            [['fecha_nacimiento', 'licencia','nombreUsuario', 'apellido1Usuario', 'apellido2Usuario'], 'safe'],
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
        $query = Participante::find()->joinWith('usuario');

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

        // grid filtering conditions
        $query->andFilterWhere([
            'participante.id' => $this->id,
            'participante.fecha_nacimiento' => $this->fecha_nacimiento,
            'participante.tipo_participante_id' => $this->tipo_participante_id,
            'participante.imagen_id' => $this->imagen_id,
            'participante.usuario_id' => $this->usuario_id,

        ]);
        $query->andFilterWhere(['like', 'usuario.nombre', $this->nombreUsuario])
              ->andFilterWhere(['like', 'usuario.apellido1', $this->apellido1Usuario])
              ->andFilterWhere(['like', 'usuario.apellido2', $this->apellido2Usuario]);

        $query->andFilterWhere(['like', 'licencia', $this->licencia]);

        return $dataProvider;
    }

}
