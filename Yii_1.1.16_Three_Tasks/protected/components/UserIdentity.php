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
	public function authenticate()
	{
		if(empty(Yii::app()->params['auth_file']) or !file_exists(Yii::app()->params['auth_file']))
			return !$this->errorCode = self::ERROR_PASSWORD_INVALID;
		
		$handle = fopen(Yii::app()->params['auth_file'], 'r');

		while (!feof($handle)) {
			$buffer = fgets($handle);
			$user = preg_split("/[\s]+/", $buffer, null, PREG_SPLIT_NO_EMPTY);

			if(empty($user[0]) or empty($user[1]))
				continue;

			if($user[0] == $this->username and $user[1] == $this->password)
				return !$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode = self::ERROR_PASSWORD_INVALID;
	}
}