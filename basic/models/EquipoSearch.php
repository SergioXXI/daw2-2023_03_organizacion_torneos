<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Equipo;

/**
 * EquipoSearch represents the model behind the search form of `app\models\Equipo`.
 */
class EquipoSearch extends Equipo
{
    public $numParticipantes; //numero de participantes de cada equipo
    public $categoriaNombre;  //nombre de la categoría
    
    /**
     * Reglas de los campos del modelo
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','numParticipantes'], 'integer'],
            [['nombre', 'descripcion', 'categoriaNombre', 'licencia'], 'safe'],
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
     * Crea una instancia de un provedor de datos
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Equipo::find();
        $query->joinWith(['categoria']);

        // add conditions that should always apply here
        $query->joinWith(['participantes'])->groupBy('equipo.id'); //Hay que tener una relación 'participantes' en el modelo Equipo

        //lógica para contar el número de participantes
        $query->select([
            'equipo.*', //selecciona todos los campos de equipo
            'numParticipantes' => 'COUNT(equipo_participante.participante_id)' //se cuentan los participantes del equipo
        ]);
        
        //guarda la informacion en el dataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //se ordenan ascendentemente y descendentemente
        $dataProvider->sort->attributes['categoriaNombre'] = [
            'asc' => ['categoria.nombre' => SORT_ASC],
            'desc' => ['categoria.nombre' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //si no es nulo el numero de participantes se guarda el valor
        if ($this->numParticipantes != null) {
            $query->having(['numParticipantes' => $this->numParticipantes]);
        }

        //se ordenan ascendentemente y descendentemente
        $dataProvider->sort->attributes['numParticipantes']=[
			'asc'=>['numParticipantes'=>SORT_ASC],
			'desc'=>['numParticipantes'=>SORT_DESC],
		];

        // grid filtering conditions
        //se establecen las condiciones para realizar filtros de búsqueda en la vista de index
        $query->andFilterWhere([
            'equipo.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'equipo.nombre', $this->nombre])
            ->andFilterWhere(['like', 'categoria.nombre', $this->categoriaNombre])
            ->andFilterWhere(['like', 'equipo.descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'equipo.licencia', $this->licencia]);

        return $dataProvider;
    }
}
