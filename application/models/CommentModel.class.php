<?php
class CommentModel extends Model {
	
	function isInvalid($data) {
		$errors = array();
		foreach ($data as $type => $value) {
			switch ($type) {
				case 'uname':
					break;
				case 'pid':
					break;
				case 'content':
					break;
				case 'time':
					break;
			}
		}
		return $errors;
	}
	
	function add($data) {
		$data['time'] = date("Y-m-d-h-m-s");
		return parent::add($data);
	}
	
	function getComment($pid) {
		$sql = "select * from `comment` where `pid` = :pid order by `time` desc";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
}