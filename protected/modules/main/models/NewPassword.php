<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class NewPassword extends CFormModel
{
	public $password;
	public $password_repeat;
	public $link;

	public function rules()
	{
		return array(
			array('password, password_repeat, link', 'required'),
            array('password, password_repeat', 'length', 'min'=>6, 'max'=>30,'tooShort'=>'Пароль повинен мати мінімально 6 символів','tooLong'=>'Пароль повинен мати максимально 30 символів'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password','message'=>'Паролі не співпадають')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>'Пароль',
			'password_repeat'=>'Повторите пароль',
		);
	}
}
