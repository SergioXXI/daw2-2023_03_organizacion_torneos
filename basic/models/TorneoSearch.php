<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Torneo;

/**
 * TorneoSearch represents the model behind the search form of `app\models\Torneo`.
 */
class TorneoSearch extends Torneo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'participantes_max', 'disciplina_id', 'tipo_torneo_id', 'clase_id'], 'integer'],
            [['nombre', 'descripcion', 'fecha_inicio', 'fecha_limite', 'fecha_fin'], 'safe'],
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
        $query = Torneo::find();

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
            'id' => $this->id,
            'participantes_max' => $this->participantes_max,
            'disciplina_id' => $this->disciplina_id,
            'tipo_torneo_id' => $this->tipo_torneo_id,
            'clase_id' => $this->clase_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_limite' => $this->fecha_limite,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
