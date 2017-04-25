<?php
class Sql {
	protected $_dbHandle;
	protected $_result;
	private $filter = '';

	// TODO improve security against sql injection
	public function connect($host, $user, $pass, $dbname) {
		try {
			$dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);
			$option = array(
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
			);
			$this->_dbHandle = new PDO($dsn, $user, $pass, $option);
		} catch (PDOException $e) {
			exit('Error: ' . $e->getMessage());
		}
	}

	public function where($where = array()) {
		if (isset($where)) {
			$this->filter .= ' WHERE ';
			$this->filter .= implode(' ', $where);
		}
		
		return $this;
	}

	public function order($order = array()) {
		if (isset($order)) {
			$this->filter .= ' ORDER BY ';
			$this->filter .= implode(',', $order);
		}
		
		return $this;
	}

	public function selectAll() {
		$sql = sprintf("select * from `%s` %s", $this->_table, $this->filter);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();
		
		return $sth->fetchAll();
	}

	public function select($cols = array(), $id) {
		$sql = sprintf("select %s from `%s` where `%s` = :id", $this->formatSelect($cols), $this->_table, $this->_primaryKey);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array (':id' => $id));
		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	public function delete($id) {
		$sql = sprintf("delete from `%s` where `%s` = :id", $this->_table, $this->_primaryKey);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array (':id' => $id));
		
		return $sth->rowCount();
	}

	public function query($sql) {
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();
		
		return $sth->rowCount();
	}

	public function add($data) {
		$sql = sprintf("insert into `%s` %s", $this->_table, $this->formatInsert($data));
		
		return $this->query($sql);
	}

	public function update($id, $data) {
		$sql = sprintf("update `%s` set %s where `id` = '%s'", $this->_table, $this->formatUpdate($data), $id);
		
		return $this->query($sql);
	}
	
	private function formatSelect($cols) {
		$ret = '';
		if (!empty($cols)) {
			if (is_array($cols)) {
				foreach ($cols as &$col) {
					$col = '`' . $col . '`';
				}
				$ret = implode(',', $cols);
			} else {
				$ret = $cols;
			}
		} else {
			$ret = '*';
		}
		return $ret;
	}
	
	// Convert array to insertion queries
	private function formatInsert($data) {
		$fields = array();
		$values = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s`", $key);
			$values[] = empty($value) ? "null" : sprintf("'%s'", $value);
		}
		
		$field = implode(',', $fields);
		$value = implode(',', $values);
		
		return sprintf("(%s) values (%s)", $field, $value);
	}
	
	// Convert array to update queries
	private function formatUpdate($data) {
		$fields = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s` = '%s'", $key, $value);
		}
		
		return implode(',', $fields);
	}
}