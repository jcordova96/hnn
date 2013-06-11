<?php

/**
 * This is the model class for table "blog".
 *
 * The followings are the available columns in table 'blog':
 * @property string $id
 * @property string $uid
 * @property string $type
 * @property string $title
 * @property string $author
 * @property string $source
 * @property string $body
 * @property string $teaser
 * @property integer $status
 * @property integer $created
 */
class Blog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Blog the static model class
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
		return 'blog';
	}

	public static function getBlogByAuthor($author_id)
	{
		$connection = Yii::app()->db;

		$data = array();

		$sql = "
			select b.id, b.title, b.author, b.source, b.teaser, b.created
			from blog b
			where b.author_id = {$author_id}
			order by b.created desc
			limit 100;
			";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		if(!empty($result))
		{
			foreach($result as $row)
			{
				$row['teaser'] = strip_tags($row['teaser']);
				$row['tn_img'] = File::getTnImage($row['id'], 'hnn_b_type');
				$data[] = $row;
			}
		}

		return $data;
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('body, teaser', 'required'),
			array('status, created', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>11),
			array('type', 'length', 'max'=>32),
			array('title, author, source', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, type, title, author, source, body, teaser, status, created', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'type' => 'Type',
			'title' => 'Title',
			'author' => 'Author',
			'source' => 'Source',
			'body' => 'Body',
			'teaser' => 'Teaser',
			'status' => 'Status',
			'created' => 'Created',
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
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('teaser',$this->teaser,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}