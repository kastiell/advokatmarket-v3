<?php

/**
 * This is the model class for table "tbl_located_region".
 *
 * The followings are the available columns in table 'tbl_located_region':
 * @property string $id
 * @property string $region_ua
 * @property string $region_ru
 * @property string $region_full_ua
 * @property string $region_full_ru
 */
class LocatedRegion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_located_region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_ua, region_ru, region_full_ua, region_full_ru', 'required'),
			array('region_ua', 'length', 'max'=>60),
			array('region_ru, region_full_ua, region_full_ru', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, region_ua, region_ru, region_full_ua, region_full_ru', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'region_ua' => 'Region Ua',
			'region_ru' => 'Region Ru',
			'region_full_ua' => 'Region Full Ua',
			'region_full_ru' => 'Region Full Ru',
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
		$criteria->compare('region_ua',$this->region_ua,true);
		$criteria->compare('region_ru',$this->region_ru,true);
		$criteria->compare('region_full_ua',$this->region_full_ua,true);
		$criteria->compare('region_full_ru',$this->region_full_ru,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LocatedRegion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
