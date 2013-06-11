<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property string $id
 * @property string $type
 * @property string $title
 * @property string $author
 * @property string $source
 * @property string $source_url
 * @property string $source_date
 * @property string $source_bio
 * @property string $body
 * @property string $teaser
 * @property integer $uid
 * @property integer $status
 * @property integer $created
 */
class Article extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'article';
	}



	public static function getMostRecentArticles($num)
	{
		$connection = Yii::app()->db;

		$data = array();

		$sql = "
			select a.title, a.author, a.source, a.teaser, a.source_date, a.created, c.name as category
			from article a
			left join article_category_xref acxr on a.id = acxr.article_id
			left join category c on c.id = acxr.category_id
			order by a.created
			limit {$num};
			";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		if(!empty($result))
		{
			foreach($result as $row)
			{
				$data[$row['category']][] = $row;
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
			array('source_bio, body, teaser', 'required'),
			array('uid, status, created', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>32),
			array('title, author, source, source_url', 'length', 'max'=>255),
			array('source_date', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, title, author, source, source_url, source_date, source_bio, body, teaser, uid, status, created', 'safe', 'on'=>'search'),
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
			'categories' => array(self::MANY_MANY, 'category', 'article_category_xref(id, id)')
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
			'title' => 'Title',
			'author' => 'Author',
			'source' => 'Source',
			'source_url' => 'Source Url',
			'source_date' => 'Source Date',
			'source_bio' => 'Source Bio',
			'body' => 'Body',
			'teaser' => 'Teaser',
			'uid' => 'Uid',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('source_url',$this->source_url,true);
		$criteria->compare('source_date',$this->source_date,true);
		$criteria->compare('source_bio',$this->source_bio,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('teaser',$this->teaser,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}