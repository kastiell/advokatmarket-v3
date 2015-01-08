<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    // Будем хранить id.
    protected $_id;
    protected $_role;
    protected $_login;
    protected $_ts_reg;
    protected $_last_login;

	public function authenticate()
	{
        $user = User::model()->find('LOWER(login)=?', array(strtolower($this->username)));

        if(($user===null)||!CPasswordHelper::verifyPassword($this->password, $user->password)){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else{
            $this->_id = $user->id;

            $this->setState('role', $user->role);
            $this->setState('login', $user->login);
            $this->setState('ts_reg', $user->ts_reg);
            $this->setState('last_login', $user->last_login);

            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
	}

    public function getId(){
        return $this->_id;
    }
}