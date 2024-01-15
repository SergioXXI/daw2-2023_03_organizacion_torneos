<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReservaMaterial;

/**
 * ReservaMaterialSearch represents the model behind the search form of `app\models\ReservaMaterial`.
 */
class ReservaMaterialSearch extends ReservaMaterial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'material_id'], 'integer'],
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
        $query = ReservaMaterial::find();

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
            'reserva_id' => $this->reserva_id,
            'material_id' => $this->material_id,
        ]);

        return $dataProvider;
    }
}
