<?php
class PledgeModel extends Model {
	
	function add($data) {
		$data['charged'] = '0';
		$data['time'] = date('Y-m-d h-m-s');
		return parent::add($data);
	}
	
	function countBackers($pid) {
		$sql = "select count(distinct `uname`) as c from `pledge` where `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetch()['c'];
	}
	
	function exists($uname, $pid) {
		$sql = "select * from `pledge` where `pid`=:pid and `uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid, ':uname' => $uname));
		return !empty($sth->fetch());
	}
	
	function getHistory($uname) {
		$sql = "select `pledge`.`pid` as `pid`, `pledge`.`uname`, `pname`, `amount`, `time` from `pledge` inner join `project` on `pledge`.`pid`=`project`.`pid` where `pledge`.`uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $uname));
		return $sth->fetchAll();
	}
}