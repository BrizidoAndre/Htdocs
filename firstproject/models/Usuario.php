<?php

namespace app\models;

use tests\closeConnectionsNoCleanup\ThirdCest;
use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $login
 * @property string $senha
 * @property string $nome
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'senha'], 'required', 'message' => 'Por favor preencha todos os campos'],
            [['nome'], 'required', 'message' => 'O nome não está preenchido'],
            [['login', 'senha', 'nome'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Email',
            'senha' => 'Senha',
            'nome' => 'Nome',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => "id"]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     *{@inheritDoc}
     */
    public static function findByUsername($username)
    {
        return self::findOne(['login' => $username]);
    }
    public function validatePassword($password)
    {
        return $this->senha ===$password;
    }
}
