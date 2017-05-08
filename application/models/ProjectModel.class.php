<?php
class ProjectModel extends Model {

	function selectKeyword($keyword, $type='all') {
		if (!empty($keyword)) {
			$keyword = '%' . $keyword . '%';
			switch ($type) {
				case 'all':
					$conds['pname'] = $keyword;
					$conds['description'] = $keyword;
					$conds['tag'] = $keyword;
					break;
				case 'tag':
					$conds['tag'] = $keyword;
					break;
				case 'user':
					$conds['uname'] = $keyword;
					break;
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
		$data['curamount'] = '0';
		$data['posttime'] = date("Y-m-d");
		$data['status'] = "crowdfunding";
		return parent::add($data);
	}

	function update($pid,$data) {
		if (isset($data['profpic'])) {
			$data['profpic'] = $this->acceptFile($data['profpic']);
		}
		if (isset($data['sample'])) {
			$dst = SAMPLE_PROJ_PATH . $pid . "/";
			if (!is_dir($dst)) {
				mkdir($dst, 0777, true);
			}
			move_uploaded_file($data['sample']["tmp_name"], $dst . $data['sample']['name']);
			(new SampleModel())->add(array('pid'=>$pid, 'filename'=>$data['sample']['name'], 'uploadtime'=>date("Y-m-d h:m:s")));
			unset($data['sample']);
		}
		return parent::update($pid,$data);
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
					if ((($value["type"] == "image/gif")
					|| ($value["type"] == "image/jpeg")
					|| ($value["type"] == "image/pjpeg")
					|| ($value["type"] == "image/png"))
					&& ($value["size"] < 100000)) {
					}
					else {
						$errors['profpicError'] = "invalid profpic file";
					}
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
				case 'progressing' :

					break;
			}
		}
		return $errors;
	}

	function isNewInvalid($pid,$data) {
		$projectModel = new ProjectModel();
		$olddata = $projectModel->select($pid);
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
				if ((($value["type"] == "image/gif")
				|| ($value["type"] == "image/jpeg")
				|| ($value["type"] == "image/pjpeg")
				|| ($value["type"] == "image/png"))
				&& ($value["size"] < 1000000)) {
				} else {
						$errors['profpicError'] = "invalid profpic file";
					}
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
					if ($value < $olddata['progress'] || $value < 0 || $value > 100) {
						$errors['progressError'] = "invalid progress value";
					}
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
