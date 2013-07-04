<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    private $_id;

    public function authenticate()
    {
        $record = User::model()->findByAttributes(array('mail' => $this->username));
        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($record->pass !== crypt($this->password, $record->pass))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $record->id;

            $fullname = (trim($record->middle_name) == "") ? trim($record->first_name) . " " . trim($record->last_name) : trim($record->first_name) . " " . trim($record->middle_name) . " " . trim($record->last_name);
            $this->setState('fullname', $fullname);

            //log last login
            $record->login = strtotime("now");
            $record->update();

            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;

//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
    }
}