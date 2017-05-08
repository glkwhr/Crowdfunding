<?php
class FollowModel extends Model {
	
	function hasFollowed($user1, $user2) {
		// user1 follows user2
		$sql = "select * from `follow` where `uname1`=:uname1 and `uname2`=:uname2";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $user1, ':uname2' => $user2));
		return !empty($sth->fetch());
	}
	
	function add($data) {
		$data['time'] = date("Y-m-d h:m:s");
		return parent::add($data);
	}
	
	function delete($data) {
		$sql = "delete from `follow` where `uname1`=:uname1 and `uname2`=:uname2";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $data['uname1'], ':uname2' => $data['uname2']));
		return $sth->rowCount();
	}
}