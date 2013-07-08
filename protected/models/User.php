<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $pass
 * @property string $mail
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $created
 * @property integer $login
 * @property integer $status
 */
class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */

    private $oAuthManager = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created, login, status', 'numerical', 'integerOnly' => true),
            array('first_name, middle_name, last_name', 'length', 'max' => 32),
            array('mail', 'length', 'max' => 64),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, mail, first_name, middle_name, last_name, created, login, status', 'safe', 'on' => 'search'),
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
            'categories'=>array(self::MANY_MANY, 'category',
                'user_category_xref(user_id, category_id)'),
            'blog_authors'=>array(self::MANY_MANY, 'BlogAuthor',
                'user_blog_author_xref(user_id, blog_author_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'pass' => 'Pass',
            'mail' => 'Mail',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'created' => 'Created',
            'login' => 'Login',
            'status' => 'Status',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('pass', $this->pass, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('middle_name', $this->middle_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('created', $this->created);
        $criteria->compare('login', $this->login);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function revokeAllRoles()
    {
        if ($this->oAuthManager === null)
            $this->oAuthManager = Yii::app()->authManager;

        $aUserRoleInfo = $this->oAuthManager->getAuthAssignMents($this->mail);

        foreach ($aUserRoleInfo as $sUserRole => $oCAuthItem)
        {
            if (!$this->oAuthManager->revoke($sUserRole, $this->mail))
            {
                Throw new Exception("User role revoke action failed.");
            }
        }

        return true;
    }

    public function assignRoles($aRole)
    {
        if ($this->oAuthManager === null)
            $this->oAuthManager = Yii::app()->authManager;;

        foreach ($aRole as $sRole)
        {
            if (!$this->oAuthManager->assign($sRole, $this->mail))
            {
                Throw new Exception("User role assign action failed.");
            }
        }

        return true;
    }
}