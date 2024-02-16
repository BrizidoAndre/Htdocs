<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Professor;

/**
 * ProfessorSearch represents the model behind the search form of `app\models\Professor`.
 */
class ProfessorSearch extends Professor
{
    public function attributes(){
        return array_merge(parent::attributes(), ["usuario.nome"]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['materia','usuario.nome'], 'safe'],
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
        $query = Professor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['usuario']);
        $dataProvider->sort->attributes['usuario.nome']=[
            'asc' => ['usuario.nome'=>SORT_ASC],
            'desc' => ['usuario.nome' =>SORT_DESC],
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
            'idLogin' => $this->idLogin,
        ]);

        $query->andFilterWhere(['like', 'materia', $this->materia]);
        $query->andFilterWhere(['like', 'usuario.nome', $this->getAttribute('usuario.nome')]);

        return $dataProvider;
    }
}
