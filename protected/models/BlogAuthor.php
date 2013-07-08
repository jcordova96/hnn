<?php

/**
 * This is the model class for table "blog_author".
 *
 * The followings are the available columns in table 'blog_author':
 * @property string $id
 * @property string $author
 * @property string $description
 */
class BlogAuthor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BlogAuthor the static model class
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
		return 'blog_author';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, author, description', 'safe', 'on'=>'search'),
		);
	}

    public static function getAuthors()
    {
        $connection = Yii::app()->db;

        $data = array();

        $sql = "
			select id, author
			from blog_author
			where author != ''
			order by author;
			";

        $command = $connection->createCommand($sql);
        $result = $command->queryAll();

        if(!empty($result))
        {
            foreach($result as $row)
            {
                $data[$row['id']] = $row['author'];
            }
        }

        return $data;
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
			'author' => 'Author',
			'description' => 'Description',
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
		$criteria->compare('author',$this->author,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}