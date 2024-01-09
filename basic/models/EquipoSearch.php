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
    public $numParticipantes;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id','numParticipantes'], 'integer'],
            [['nombre', 'descripcion', 'licencia'], 'safe'],
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
        $query = Equipo::find();

        // add conditions that should always apply here

        /*$query->joinWith(['participantes'])->groupBy('equipo.id'); //Hay que tener una relación 'participantes' en el modelo Equipo

        //Se añade la lógica para contar el número de participantes
        $query->select([
            'equipo.*', //Se selecciona todos los campos de equipo
            'numParticipantes' => 'COUNT(equipo_participante.participante_id)' // Cuenta los participantes
        ]);*/
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /*if ($this->numParticipantes != null) {
            $query->having(['numParticipantes' => $this->numParticipantes]);
        }*/

        $dataProvider->sort->attributes['numParticipantes']=[
			'asc'=>['numParticipantes'=>SORT_ASC],
			'desc'=>['numParticipantes'=>SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'categoria_id' => $this->categoria_id,
            'numParticipantes' => $this->numParticipantes,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'licencia', $this->licencia]);

        return $dataProvider;
    }
}
