<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $id
 * @property string $login
 * @property string $password
 * @property string $ts_reg
 * @property string $last_login
 * @property string $role
 */
class User extends CActiveRecord
{
    const GUEST = 'guest';
    const CLIENT = 'client';
    const LAWYER = 'lawyer';
    const DLAWYER = 'dactv_lawyer';
    const COMPANY = 'company';
    const DCOMPANY = 'dactv_company';
    const ADMIN = 'admin';


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, ts_reg, last_login, role', 'required'),
			array('login', 'length', 'max'=>80),
			array('password, role', 'length', 'max'=>60),
			array('ts_reg, last_login', 'length', 'max'=>20),
            array('login', 'unique', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, password, ts_reg, last_login, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'lawyer_tbl'=>array(self::HAS_ONE, 'Lawyer', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'password' => 'Password',
			'ts_reg' => 'Ts Reg',
			'last_login' => 'Last Login',
			'role' => 'Role',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('ts_reg',$this->ts_reg,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
