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
		return $this->selectAll();
	}
	
    function isInvalid($data) {
         $errors = array();
         foreach ($data as $type => $value) {
             switch ($type) {
                 case 'pid':
                     break;
                 case 'pname':
                     if (empty($value)) {
                         $errors['pnameError'] = "project name cannot be empty";
                     }
                     break;
                 case 'uname':
                     if (empty($value)) {
                         $errors['unameError'] = "uname cannot be empty";
                     }
                     break;
                 case 'description':
                     break;
                 case 'profpic':
                     break;
                 case 'tag':
                     break;
                 case 'minamount':
                     if(empty($value)) {
                         $errors['minamountError'] = "minamount cannot be empty";
                     }
                     else {
                         if (!is_numeric($value)) {
                             $errors['minamountError'] = "invalid minamount";
                         }
                     }
                     break;
                 case 'maxamount':
                     if(empty($value)) {
                         $errors['maxamountError'] = "maxamount cannot be empty";
                     }
                     else {
                         if (!is_numeric($value)) {
                             $errors['maxamountError'] = "invalid maxamount";
                         }
                     }
                     break;
                 case 'curamount':
                     if(empty($value)) {
                         $errors['curamountError'] = "curamount cannot be empty";
                     }
                     else {
                         if (!is_numeric($value)) {
                             $errors['curamountError'] = "invalid curamount";
                         }
                     }
                     break;
                 case 'posttime':
                     if (empty($value)) {
                         $errors['posttimeError'] = "posttime cannot be empty";
                     }
                     break;
                 case 'status':
                     if (empty($value)) {
                         $errors['statusError'] = "status cannot be empty";
                     }
                     break;
                 case 'endtime':
                     if (empty($value)) {
                         $errors['endtimeError'] = "endtime cannot be empty";
                     }
                     break;
                 case 'actualendtime':
                     break;
                 case 'plannedcompletiontime':
                     if(empty($value)) {
                     $errors['plannedcompletiontimeError'] = "plannedcompletiontime cannot be empty";
                     }
                     break;
                 case 'actualcompletiontime':
                     break;
                 case 'progress':
                     break;
             }
         }
         return $errors;
    }
}
