<?php
class ProjectModel extends Model {

	function selectKeyword($keyword, $type='all') {
		if (!empty($keyword)) {
			$keyword = '%' . $keyword . '%';
			if ($type == 'all') {
				$conds['pname'] = $keyword;
				$conds['description'] = $keyword;
				$conds['tag'] = $keyword;
			} else {
				$conds[$type] = $keyword;
			}
			$this->where($this->getFilter($conds, Sql::OP_LIKE, Sql::LOGIC_OR));
		}
		return $this->selectAll();
	}

	function add($data) {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$data['pid'] = $this->count()['count(pid)'] + 1;
		if (isset($data['profpic'])) {
			$data['profpic'] = $this->acceptFile($data['profpic']);
		}
		$data['uname'] = $_SESSION['user']['username'];
		$data['curamount'] = 0;
		$data['posttime'] = date("Y-m-d");
		$data['status'] = "crowdfunding";
		return parent::add($data);
	}

	function isInvalid($data) {
		$errors = array();
		foreach ($data as $type => $value) {
			switch ($type) {
				case 'pid' :
					break;
				case 'pname' :
					if (empty($value)) {
						$errors['pnameError'] = "project name cannot be empty";
					}
					break;
				case 'uname' :
					if (empty($value)) {
						$errors['unameError'] = "user name cannot be empty";
					}
					break;
				case 'description' :
					break;
				case 'profpic' :
					// TODO validate the file
					break;
				case 'tag' :
					if (! preg_match("/^[a-zA-Z ]*(,[a-zA-Z ]*)*$/", $value)) {
						$errors['tagError'] = "invalid tag(s)";
					}
					break;
				case 'minamount' :
					if (empty($value)) {
						$errors['minError'] = "min fund amount cannot be empty";
					} else {
						if (! is_numeric($value)) {
							$errors['minError'] = "invalid min fund amount";
						}
					}
					break;
				case 'maxamount' :
					if (empty($value)) {
						$errors['maxError'] = "max fund amount cannot be empty";
					} else {
						if (! is_numeric($value)) {
							$errors['maxError'] = "invalid max fund amount";
						} else {
							if (isset($data['minamount'])) {
								if (! empty($data['minamount'])) {
									if ($value < $data['minamount']) {
										$errors['maxError'] = "invalid max fund amount";
									}
								} else
									$errors['maxError'] = "invalid max fund amount";
							} else
								$errors['maxError'] = "invalid max fund amount";
						}
					}
					
					break;
				case 'curamount' :
					if (empty($value)) {
						$errors['curamountError'] = "current fund amount cannot be empty";
					} else {
						if (! is_numeric($value)) {
							$errors['curamountError'] = "invalid current fund amount";
						}
					}
					break;
				case 'posttime' :
					if (empty($value)) {
						$errors['posttimeError'] = "post project time cannot be empty";
					}
					break;
				case 'status' :
					if (empty($value)) {
						$errors['statusError'] = "project status cannot be empty";
					}
					break;
				case 'endtime' :
					if (empty($value)) {
						$errors['endtimeError'] = "funding endtime cannot be empty";
					} else {
						if (strtotime($value) < strtotime(date("Y-m-d"))) {
							$errors['endtimeError'] = "invalid funding endtime";
						}
					}
					break;
				case 'actualendtime' :
					break;
				case 'plannedcompletiontime' :
					if (empty($value)) {
						$errors['pctError'] = "project planned completion time cannot be empty";
					} else {
						if (strtotime($value) < strtotime(date("Y-m-d"))) {
							$errors['pctError'] = "invalid project planned completion time";
						}
					}
					break;
				case 'actualcompletiontime' :
					break;
				case 'progress' :
					break;
			}
		}
		return $errors;
	}

	private function acceptFile($file) {
		$uptype = explode(".", $file["name"]);
		$newname = date("Y-m-d-h-m-s") . ".".$uptype[1];
		move_uploaded_file($file["tmp_name"], IMG_PROJ_PATH . "profile/" . $newname);
		return $newname;
	}
}
