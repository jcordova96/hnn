<?php

/**
 * This is the model class for table "seo".
 *
 * The followings are the available columns in table 'seo':
 * @property string $id
 * @property string $type
 * @property string $nid
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $robots
 */
class Seo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Seo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'length', 'max'=>16),
			array('nid', 'length', 'max'=>10),
			array('url, title', 'length', 'max'=>255),
			array('robots', 'length', 'max'=>50),
			array('description, keywords', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, nid, url, title, description, keywords, robots', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'nid' => 'Nid',
			'url' => 'Url',
			'title' => 'Title',
			'description' => 'Description',
			'keywords' => 'Keywords',
			'robots' => 'Robots',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('nid',$this->nid,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('robots',$this->robots,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}