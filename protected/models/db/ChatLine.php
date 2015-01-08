<?php

/**
 * This is the model class for table "tbl_chat_line".
 *
 * The followings are the available columns in table 'tbl_chat_line':
 * @property string $id
 * @property string $id_consultation
 * @property string $msg
 * @property string $type
 * @property string $origin
 * @property string $ts
 */
class ChatLine extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_chat_line';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_consultation, msg, type, origin, ts', 'required'),
			array('id_consultation', 'length', 'max'=>10),
			array('ts', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_consultation, msg, type, origin, ts', 'safe', 'on'=>'search'),
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
			'id_consultation' => 'Id Consultation',
			'msg' => 'Msg',
			'type' => 'Type',
			'origin' => 'Origin',
			'ts' => 'Ts',
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
		$criteria->compare('id_consultation',$this->id_consultation,true);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('origin',$this->origin,true);
		$criteria->compare('ts',$this->ts,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChatLine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
