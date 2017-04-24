<?php
class UserModel extends Model {

	public function isInvalid($data) {
		$errors = array();
		foreach ($data as $type => $value) {
			switch ($type) {
				case 'uname':
					// validate username
					if (empty($value)) {
						$errors['unameError'] = "username cannot be empty";
					} else {
						if ($this->hasUname($value)) {
							$errors['unameError'] = "username already exists";
						}
					}
					break;
				case 'upwd':
					// TODO validate password
					if (empty($value)) {
						$errors['upwdError'] = "password cannot be empty";
					} else {

					}
					break;
				case 'name':
					// TODO validate realname
					if (empty($value)) {
						$errors['nameError'] = "name cannot be empty";
					} else {
						if (!preg_match("/^[a-zA-Z ]*$/", $value)) {
							$errors['nameError'] = "invalid name";
						}
					}
					break;
				case 'ccn':
					// TODO validate credit card number
					if (!is_numeric($value)) {
						$errors['ccnError'] = "invalid credit card number";
					}
					break;
				case 'email':
					// TODO validate email address
					if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
						$errors['emailError'] = "invalid email";
					}
					break;
				case 'addr':
					// TODO validate address
					break;
				case 'interest':
					// TODO validate interest
					if (!preg_match("/^[a-zA-Z ]*(,[a-zA-Z ]*)*$/", $value)) {
						$errors['interestError'] = "invalid interest(s)";
					}
			}
		}
		return $errors;
	}
	
	private function hasUname($uname) {
		$uname = $this->_dbHandle->quote($uname);
		$sql = sprintf("select * from `user` where `uname` = %s", $uname);
		$ret = False;
		if ($this->query($sql) == 1) {
			$ret = True;
		}
		return $ret;
	}
}