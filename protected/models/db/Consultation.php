<?php

/**
 * This is the model class for table "tbl_consultation".
 *
 * The followings are the available columns in table 'tbl_consultation':
 * @property string $id
 * @property string $id_client
 * @property string $id_lawyer
 * @property string $channel
 * @property string $status
 * @property integer $cost
 * @property string $id_pay
 * @property string $time_start
 * @property string $time_pay
 * @property string $time_cons
 * @property string $time_reviews
 * @property string $time_end
 * @property string $time_cancel
 */
class Consultation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_consultation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_client, id_lawyer, channel, time_start', 'required'),
			array('cost', 'numerical', 'integerOnly'=>true),
			array('id_client, id_lawyer, id_pay', 'length', 'max'=>10),
			array('time_start, time_pay, time_cons, time_reviews, time_end, time_cancel', 'length', 'max'=>20),
			array('status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_client, id_lawyer, channel, status, cost, id_pay, time_start, time_pay, time_cons, time_reviews, time_end, time_cancel', 'safe', 'on'=>'search'),
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
			'id_client' => 'Id Client',
			'id_lawyer' => 'Id Lawyer',
			'channel' => 'Channel',
			'status' => 'Status',
			'cost' => 'Cost',
			'id_pay' => 'Id Pay',
			'time_start' => 'Time Start',
			'time_pay' => 'Time Pay',
			'time_cons' => 'Time Cons',
			'time_reviews' => 'Time Reviews',
			'time_end' => 'Time End',
			'time_cancel' => 'Time Cancel',
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
		$criteria->compare('id_client',$this->id_client,true);
		$criteria->compare('id_lawyer',$this->id_lawyer,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('id_pay',$this->id_pay,true);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_pay',$this->time_pay,true);
		$criteria->compare('time_cons',$this->time_cons,true);
		$criteria->compare('time_reviews',$this->time_reviews,true);
		$criteria->compare('time_end',$this->time_end,true);
		$criteria->compare('time_cancel',$this->time_cancel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Consultation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
