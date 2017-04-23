<?php

class Model extends Sql
{
	protected $_model;
	protected $_table;

	public function __construct()
	{
		// Connect to DB
		$this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		// Get class name of the model
		$this->_model = get_class($this);
		// Delete "Model" in the end of the name
		$this->_model = substr($this->_model, 0, -5);

		// The table name should be the same as the Class
		$this->_table = strtolower($this->_model);
	}
}