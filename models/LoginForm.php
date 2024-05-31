<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    /**
     * @var string|null
     */
    public ?string $username = null;

    /**
     * @var string|null
     */
    public ?string $password = null;

    /**
     * @var bool
     */
    public bool $rememberMe = true;

    /**
     * @var bool
     */
    private $_user = false;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [
                ['username', 'password'],
                'trim'
            ],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     */
    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->params['login_expire'] : 0)) {
                return true;
            }

            return false;
        }
        return false;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }
}
