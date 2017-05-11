<?php
class RateModel extends Model {
	
	function add($input) {
		$data['uname'] = $input['uname'];
		$data['pid'] = $input['pid'];
		$data['score'] = $input['score'];
		$data['time'] = date('Y-m-d h-m-s');
		return parent::add($data);
	}
	
	function countRate($pid) {
		$sql = "select count(distinct `uname`) as c from `rate` where `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetch()['c'];
	}
	
	function avgScore($pid) {
		$sql = "select avg(`score`) as c from `rate` where `pid`=:pid";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetch()['c'];
	}
	
	function exists($uname, $pid) {
		$sql = "select * from `rate` where `pid`=:pid and `uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid, ':uname' => $uname));
		return !empty($sth->fetch());
	}
	
	function getHistory($uname) {
		$sql = "select `rate`.`pid` as `pid`, `rate`.`uname`, `pname`, `score`, `time` from `rate` inner join `project` on `rate`.`pid`=`project`.`pid` where `rate`.`uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $uname));
		return $sth->fetchAll();
	}
}