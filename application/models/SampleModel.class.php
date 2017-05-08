<?php
class SampleModel extends Model {
	
	function getSample($pid) {
		$sql = "select * from `sample` where `pid` = :pid order by `uploadtime` desc";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':pid' => $pid));
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function delete($data=array()) {
		$sql = "delete from `sample` where `pid` = :pid and `filename` = :filename";
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array (':pid' => $data[0], ':filename' => $data[1]));
		return $sth->rowCount();
	}
}