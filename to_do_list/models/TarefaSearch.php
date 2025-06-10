<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tarefa;

/**
 * TarefaSearch represents the model behind the search form of `app\models\Tarefa`.
 */
class TarefaSearch extends Tarefa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdTarefa', 'IdUsuario', 'IdPrioridade', 'IdStatus'], 'integer'],
            [['Descricao', 'Setor', 'DataCadastro'], 'safe'],
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
    public function search($params, $status = 1)
    {
        $query = Tarefa::find();

        // add conditions that should always apply here

        $query->andWhere(['IdStatus' => $status]);

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
            'IdTarefa' => $this->IdTarefa,
            'DataCadastro' => $this->DataCadastro,
            'IdUsuario' => $this->IdUsuario,
            'IdPrioridade' => $this->IdPrioridade,
            'IdStatus' => $this->IdStatus,
        ]);

        $query->andFilterWhere(['like', 'Descricao', $this->Descricao])
            ->andFilterWhere(['like', 'Setor', $this->Setor]);

        return $dataProvider;
    }
}
