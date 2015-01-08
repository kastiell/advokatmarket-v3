<?php

/**
 * This is the model class for table "tbl_request_lead".
 *
 * The followings are the available columns in table 'tbl_request_lead':
 * @property string $id
 * @property string $id_lead
 * @property string $id_lawyer
 * @property string $cost_service
 * @property string $status
 * @property integer $deadline
 * @property string $type_work
 * @property string $link
 * @property integer $direct
 * @property string $time_expected
 * @property string $time_cancel
 * @property string $time_frozen
 * @property string $time_accepted
 * @property string $time_process
 */
class RequestLead extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_request_lead';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_lead, id_lawyer, time_expected', 'required'),
			array('deadline, direct', 'numerical', 'integerOnly'=>true),
			array('id_lead, id_lawyer', 'length', 'max'=>10),
			array('cost_service', 'length', 'max'=>11),
			array('time_expected, time_cancel, time_frozen, time_accepted, time_process', 'length', 'max'=>20),
			array('status, type_work, link', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_lead, id_lawyer, cost_service, status, deadline, type_work, link, direct, time_expected, time_cancel, time_frozen, time_accepted, time_process', 'safe', 'on'=>'search'),
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
            'request_lawyer'=> array(self::HAS_ONE, 'Lawyer', 'id_lawyer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_lead' => 'Id Lead',
			'id_lawyer' => 'Id Lawyer',
			'cost_service' => 'Cost Service',
			'status' => 'Status',
			'deadline' => 'Deadline',
			'type_work' => 'Type Work',
			'link' => 'Link',
			'direct' => 'Direct',
			'time_expected' => 'Time Expected',
			'time_cancel' => 'Time Cancel',
			'time_frozen' => 'Time Frozen',
			'time_accepted' => 'Time Accepted',
			'time_process' => 'Time Process',
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
		$criteria->compare('id_lead',$this->id_lead,true);
		$criteria->compare('id_lawyer',$this->id_lawyer,true);
		$criteria->compare('cost_service',$this->cost_service,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('deadline',$this->deadline);
		$criteria->compare('type_work',$this->type_work,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('direct',$this->direct);
		$criteria->compare('time_expected',$this->time_expected,true);
		$criteria->compare('time_cancel',$this->time_cancel,true);
		$criteria->compare('time_frozen',$this->time_frozen,true);
		$criteria->compare('time_accepted',$this->time_accepted,true);
		$criteria->compare('time_process',$this->time_process,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RequestLead the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
