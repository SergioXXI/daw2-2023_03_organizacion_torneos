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
    public $jornada;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'participantes_max', 'disciplina_id', 'tipo_torneo_id', 'clase_id'], 'integer'],
            [['nombre', 'descripcion', 'fecha_inicio', 'fecha_limite', 'fecha_fin', 'jornada'], 'safe'],
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
            'fecha_fin' => $this->fecha_fin,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function searchEventos($params)
    {
        $query = Torneo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith(['partidos']);
        
        $query->andFilterWhere(['like','nombre',$this->nombre]);
        $query->andFilterWhere(['like','clase_id',$this->clase_id]);
        $query->andFilterWhere(['like','disciplina_id',$this->disciplina_id]);
        $query->andFilterWhere(['like','partido.jornada',$this->jornada]);
        
        $query->andWhere([
            'or',
            ['>=', 'fecha_inicio', date('Y-m-d H:i:s')],
            ['>=', 'fecha_fin', date('Y-m-d H:i:s')],
            ['>=', 'fecha_limite', date('Y-m-d H:i:s')],
            ['>=', 'partido.fecha', date('Y-m-d')],
        ]);
        
        return $dataProvider;
    }
}
