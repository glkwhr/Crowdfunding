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
}