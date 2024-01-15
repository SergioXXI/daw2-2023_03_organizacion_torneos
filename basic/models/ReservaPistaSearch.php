<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReservaPista;

/**
 * ReservaPistaSearch represents the model behind the search form of `app\models\ReservaPista`.
 */
class ReservaPistaSearch extends ReservaPista
{
    public $reservaFecha;
    public $pistaNombre;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'pista_id'], 'integer'],
            [['reservaFecha', 'pistaNombre'], 'safe'],
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
        $query = ReservaPista::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //Esto permite ordenar segun la reserva fecha
        $orden = $dataProvider->getSort();
        $orden->attributes['reservaFecha'] = [
            'asc' => ['fecha' => SORT_ASC],
            'desc' => ['fecha' => SORT_DESC],
        ];
        //Esto permite ordenar segun la pista nombre
        $orden->attributes['pistaNombre'] = [
            'asc' => ['nombre' => SORT_ASC],
            'desc' => ['nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        //Realizar el join con la tabla Reserva en caso de ser necesario
        if(isset($orden->attributeOrders['reservaFecha']) || !empty($this->reservaFecha))
            $query->joinWith(['reserva']);
        
        //Realizar el join con la tabla Pista en caso de ser necesario
        if(isset($orden->attributeOrders['pistaNombre']) || !empty($this->pistaNombre))
            $query->joinWith(['pista']);


        // grid filtering conditions
        $query->andFilterWhere([
            'reserva_id' => $this->reserva_id,
            'pista_id' => $this->pista_id,
        ]);

        //Filtrado mediante la fecha de la tabla reserva
        $query->andFilterWhere(['like','reserva.fecha',$this->reservaFecha]);

        //Filtrado mediante el nombre de la tabla pista
        $query->andFilterWhere(['like','pista.nombre',$this->pistaNombre]);

        return $dataProvider;
    }
}
