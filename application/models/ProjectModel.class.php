<?php
class ProjectModel extends Model {
	
	function selectKeyword($keyword) {
		if (!empty($keyword)) {
			$keyword = '%' . $keyword . '%';
			$conds['pname'] = $keyword;
			$conds['description'] = $keyword;
			$conds['tag'] = $keyword;
			$this->where($this->getFilter($conds, Sql::OP_LIKE, Sql::LOGIC_OR));
		}
		return $this->selectAll();;
	}
}