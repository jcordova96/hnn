<?php

/**
 * This is the model class for table "user_blog_author_xref".
 *
 * The followings are the available columns in table 'user_blog_author_xref':
 * @property string $id
 * @property string $user_id
 * @property string $blog_author_id
 */
class UserBlogAuthorXref extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserBlogAuthorXref the static model class
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
		return 'user_blog_author_xref';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, blog_author_id', 'required'),
			array('user_id, blog_author_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, blog_author_id', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'blog_author_id' => 'Blog Author',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('blog_author_id',$this->blog_author_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function deleteAllForUser($user_id)
    {
        $fResult =  $this->deleteAll('user_id=:user_id',array(':user_id'=>$user_id));
        return $fResult;
    }

    public function assignBlogAuthors($user_id,$blog_author_ids)
    {
        foreach($blog_author_ids as $blog_author_id)
        {
            $ubax = new UserBlogAuthorXref();
            $ubax->user_id = $user_id;
            $ubax->blog_author_id = $blog_author_id;
            $ubax->save();

            unset($ubax);
        }
    }
}