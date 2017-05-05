<?php
class Sql {

	const LOGIC_AND = 1;
	const LOGIC_OR = 2;
	const OP_EQ = 3;
	const OP_LIKE = 4;

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

	public function where($filter) {
		if (!empty($filter)) {
			$this->filter .= ' WHERE ';
			$this->filter .= $filter;
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

		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function select($id, $cols = array()) {
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

	public function count() {
		$sql = sprintf("select count(pid) from `%s`", $this->_table);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();
		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	public function add($data) {
		$sql = sprintf("insert into `%s` %s", $this->_table, $this->formatInsert($data));

		return $this->query($sql);
	}

	public function update($id, $data) {
		$sql = sprintf("update `%s` set %s where `%s` = :id", $this->_table, $this->formatUpdate($data), $this->_primaryKey);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute(array(':id' => $id));
		return $sth->rowCount();
	}

	protected function getFilter($conds, $op, $logic) {
		$ret = '';
		switch ($op) {
			case Sql::OP_EQ:
				$op = '=';
				break;
			case Sql::OP_LIKE:
				$op = 'like';
				break;
			default:
				break;
		}
		switch ($logic) {
			case Sql::LOGIC_AND:
				$logic = ' and ';
				break;
			case Sql::LOGIC_OR:
				$logic = ' or ';
				break;
			default:
				break;
		}
		foreach ($conds as $key => $value) {
			if (!empty($ret)) {
				$ret .= $logic;
			}
			$ret .= '`' . $key . '`' . $op . $this->_dbHandle->quote($value);
		}
		return $ret;
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
			$fields[] = sprintf("`%s` = %s", $key, $this->_dbHandle->quote($value));
		}

		return implode(',', $fields);
	}
}
