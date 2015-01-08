<?php

/**
 * This is the model class for table "tbl_lead".
 *
 * The followings are the available columns in table 'tbl_lead':
 * @property string $id
 * @property string $id_client
 * @property integer $id_request_lead
 * @property string $status
 * @property integer $cost_lead
 * @property string $ask
 * @property string $type_ask
 * @property integer $direct
 * @property string $title_ask
 * @property string $time_make
 * @property string $time_list
 * @property string $time_accepted
 * @property string $time_cancel
 * @property string $time_exit
 * @property string $time_success
 * @property string $time_process
 */
class Lead extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_lead';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_client, ask, time_make', 'required'),
			array('id_request_lead, cost_lead, direct', 'numerical', 'integerOnly'=>true),
			array('id_client', 'length', 'max'=>10),
			array('time_make, time_list, time_accepted, time_cancel, time_exit, time_success, time_process', 'length', 'max'=>20),
			array('status, type_ask, title_ask', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_client, id_request_lead, status, cost_lead, ask, type_ask, direct, title_ask, time_make, time_list, time_accepted, time_cancel, time_exit, time_success, time_process', 'safe', 'on'=>'search'),
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
            'lead_client'=> array(self::BELONGS_TO, 'Client', 'id_client'),
            'lead_request'=> array(self::HAS_ONE, 'RequestLead', 'id_lead'),
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
			'id_request_lead' => 'Id Request Lead',
			'status' => 'Status',
			'cost_lead' => 'Cost Lead',
			'ask' => 'Ask',
			'type_ask' => 'Type Ask',
			'direct' => 'Direct',
			'title_ask' => 'Title Ask',
			'time_make' => 'Time Make',
			'time_list' => 'Time List',
			'time_accepted' => 'Time Accepted',
			'time_cancel' => 'Time Cancel',
			'time_exit' => 'Time Exit',
			'time_success' => 'Time Success',
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
		$criteria->compare('id_client',$this->id_client,true);
		$criteria->compare('id_request_lead',$this->id_request_lead);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('cost_lead',$this->cost_lead);
		$criteria->compare('ask',$this->ask,true);
		$criteria->compare('type_ask',$this->type_ask,true);
		$criteria->compare('direct',$this->direct);
		$criteria->compare('title_ask',$this->title_ask,true);
		$criteria->compare('time_make',$this->time_make,true);
		$criteria->compare('time_list',$this->time_list,true);
		$criteria->compare('time_accepted',$this->time_accepted,true);
		$criteria->compare('time_cancel',$this->time_cancel,true);
		$criteria->compare('time_exit',$this->time_exit,true);
		$criteria->compare('time_success',$this->time_success,true);
		$criteria->compare('time_process',$this->time_process,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lead the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
