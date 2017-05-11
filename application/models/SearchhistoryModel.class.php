<?php
class SearchhistoryModel extends Model {
	
	function add($data) {
		$data['time'] = date('Y-m-d h-m-s');
		if (!$this->exists($data)) {
			return parent::add($data);
		} else {
			return $this->updateTime($data);
		}
	}
	
	function updateTime($data) {
		$sql = sprintf("update `searchhistory` set `time`=:time where `uname`=:uname and`keyword`=:keyword");
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(
				':time' => $data['time'],
				':uname' => $data['uname'],
				':keyword' => $data['keyword']
		));
		return $sth->rowCount();
	}
	
	function exists($data) {
		$sql = "select * from `searchhistory` where `keyword`=:keyword and `uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':keyword' => $data['keyword'], ':uname' => $data['uname']));
		return !empty($sth->fetch());
	}
	
	function getHistory($uname) {
		$sql = "select * from `searchhistory` where `uname`=:uname";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':uname' => $uname));
		return $sth->fetchAll();
	}
	
	function clear($uname) {
		$sql = sprintf("delete from `searchhistory` where `uname` = :uname");
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array (':uname' => $uname));
		
		return $sth->rowCount();
	}
}