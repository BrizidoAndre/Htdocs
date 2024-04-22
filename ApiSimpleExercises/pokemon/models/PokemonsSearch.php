<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pokemons;

/**
 * PokemonsSearch represents the model behind the search form of `app\models\Pokemons`.
 */
class PokemonsSearch extends Pokemons
{
    public function attributes(){
        return array_merge(parent::attributes(), ['trainer.name']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idTrainer'], 'integer'],
            [['name', 'type', 'trainer.name'], 'safe'],
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
        $query = Pokemons::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(["trainer"]);
        $dataProvider->sort->attributes['trainer.name'] = [
            'asc' => ['trainer.name' => 4],
            'desc' => ['trainer.name' => 3]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idTrainer' => $this->idTrainer,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);
        $query->andFilterWhere(['LIKE', 'trainer.name', $this->getAttribute('trainer.name')]);

        return $dataProvider;
    }
}
