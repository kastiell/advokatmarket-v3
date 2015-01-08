<?php

/**
 * This is the model class for table "tbl_lawyer".
 *
 * The followings are the available columns in table 'tbl_lawyer':
 * @property string $id
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property string $type_work
 * @property string $exp
 * @property string $spec
 * @property string $country
 * @property string $city_edu
 * @property string $vnz
 * @property string $faculty
 * @property string $year_leave
 * @property string $phone
 * @property string $city
 * @property string $street
 * @property string $apartment
 * @property string $site
 */
class Lawyer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_lawyer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, first_name, phone', 'required'),
			array('id, year_leave', 'length', 'max'=>10),
			array('name, first_name, last_name, country, city_edu, phone, city, street, apartment, site', 'length', 'max'=>80),
			array('vnz, faculty', 'length', 'max'=>100),
			array('type_work, exp, edu_picture, spec', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, first_name, last_name, type_work, exp, spec, country, city_edu, vnz, faculty, year_leave, phone, city, street, apartment, site', 'safe', 'on'=>'search'),
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
            'lawyer_tbl'=>array(self::HAS_ONE, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'type_work' => 'Type Work',
			'exp' => 'Exp',
			'spec' => 'Spec',
			'country' => 'Country',
			'city_edu' => 'City Edu',
			'vnz' => 'Vnz',
			'faculty' => 'Faculty',
			'year_leave' => 'Year Leave',
			'phone' => 'Phone',
			'city' => 'City',
			'street' => 'Street',
			'apartment' => 'Apartment',
			'site' => 'Site',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('type_work',$this->type_work,true);
		$criteria->compare('exp',$this->exp,true);
		$criteria->compare('spec',$this->spec,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city_edu',$this->city_edu,true);
		$criteria->compare('vnz',$this->vnz,true);
		$criteria->compare('faculty',$this->faculty,true);
		$criteria->compare('year_leave',$this->year_leave,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('apartment',$this->apartment,true);
		$criteria->compare('site',$this->site,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lawyer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
