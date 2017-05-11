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
	
	function getFollowingPledges($uname) {
		$sql = "select `uname`, `pid`, `pname`, `amount`, `time` 
				from (select A.`uname`, A.`pid`, `pname`, `amount`, `time` from `pledge` as A inner join `project` as B on A.`pid`=B.`pid`) as C 
				inner join
				(select `uname2` from `follow` where `uname1`=:uname1) as D
				on C.`uname`=D.`uname2`
				order by `time` desc;";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $uname));
		return $sth->fetchAll();
	}
	
	function getFollowingRates($uname) {
		$sql = "select `uname`, `pid`, `pname`, `score`, `time`
				from (select A.`uname`, A.`pid`, `pname`, `score`, `time` from `rate` as A inner join `project` as B on A.`pid`=B.`pid`) as C
				inner join
				(select `uname2` from `follow` where `uname1`=:uname1) as D
				on C.`uname`=D.`uname2`
				order by `time` desc;";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $uname));
		return $sth->fetchAll();
	}
	
	function getFollowingProjects($uname) {
		$sql = "select `uname`, `pid`, `pname`, `posttime`
				from `project` as A
				inner join
				(select `uname2` from `follow` where `uname1`=:uname1) as B
				on A.`uname`=B.`uname2`
				order by `posttime` desc;";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $uname));
		return $sth->fetchAll();
	}
	
	function getFollowingLikes($uname) {
		$sql = "select `uname`, `pid`, `pname`, `time`
				from (select A.`uname`, A.`pid`, `pname`, `time` from `like` as A inner join `project` as B on A.`pid`=B.`pid`) as C
				inner join
				(select `uname2` from `follow` where `uname1`=:uname1) as D
				on C.`uname`=D.`uname2`
				order by `time` desc;";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $uname));
		return $sth->fetchAll();
	}
	
	function getFollowingComments($uname) {
		$sql = "select `uname`, `pid`, `pname`, `content`, `time`
				from (select A.`uname`, A.`pid`, `pname`, `content`, `time` from `comment` as A inner join `project` as B on A.`pid`=B.`pid`) as C
				inner join
				(select `uname2` from `follow` where `uname1`=:uname1) as D
				on C.`uname`=D.`uname2`
				order by `time` desc;";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname1' => $uname));
		return $sth->fetchAll();
	}
}