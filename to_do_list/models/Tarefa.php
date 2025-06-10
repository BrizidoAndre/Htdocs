<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarefa".
 *
 * @property int $IdTarefa
 * @property string|null $Descricao
 * @property string|null $Setor
 * @property string|null $DataCadastro
 * @property int|null $IdUsuario
 * @property int|null $IdPrioridade
 * @property int|null $IdStatus
 *
 * @property Prioridade $idPrioridade
 * @property Status $idStatus
 * @property Usuario $idUsuario
 */
class Tarefa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarefa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Descricao','Setor','IdUsuario'], 'required'],
            [['DataCadastro'], 'safe'],
            [['DataCadastro'], 'default','value' => function(){
            return date('Y-m-d');
            }],
            [['IdStatus'], 'default','value' => '1'],
            [['IdUsuario', 'IdPrioridade', 'IdStatus'], 'integer'],
            [['Descricao'], 'string', 'max' => 255],
            [['Setor'], 'string', 'max' => 50],
            [['IdPrioridade'], 'exist', 'skipOnError' => true, 'targetClass' => Prioridade::class, 'targetAttribute' => ['IdPrioridade' => 'IdPrioridade']],
            [['IdStatus'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['IdStatus' => 'IdStatus']],
            [['IdUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['IdUsuario' => 'IdUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdTarefa' => 'Id Tarefa',
            'Descricao' => 'Descrição',
            'Setor' => 'Setor',
            'DataCadastro' => 'Data do Cadastro',
            'IdUsuario' => 'Usuário',
            'IdPrioridade' => 'Prioridade',
            'IdStatus' => 'Status',
        ];
    }

    /**
     * Gets query for [[IdPrioridade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdPrioridade()
    {
        return $this->hasOne(Prioridade::class, ['IdPrioridade' => 'IdPrioridade']);
    }

    /**
     * Gets query for [[IdStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(Status::class, ['IdStatus' => 'IdStatus']);
    }

    /**
     * Gets query for [[IdUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::class, ['IdUsuario' => 'IdUsuario']);
    }
}
