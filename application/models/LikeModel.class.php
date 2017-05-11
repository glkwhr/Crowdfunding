<?php
class LikeModel extends Model {
	
	function hasLiked($user, $pid) {
		$sql = "select * from `like` where `uname`=:uname and `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $user, ':pid' => $pid));
		return !empty($sth->fetch());
	}
	
	function countLiked($pid) {
		$sql = "select count(distinct `uname`) as c from `like` where `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetch()['c'];
	}
	
	function add($data) {
		$data['time'] = date("Y-m-d h:m:s");
		return parent::add($data);
	}
	
	function delete($data) {
		$sql = "delete from `like` where `uname`=:uname and `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $data['uname'], ':pid' => $data['pid']));
		return $sth->rowCount();
	}
	
	function getHistory($uname) {
		$sql = "select `like`.`pid` as `pid`, `like`.`uname`, `pname`, `time` from `like` inner join `project` on `like`.`pid`=`project`.`pid` where `like`.`uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $uname));
		return $sth->fetchAll();
	}
}