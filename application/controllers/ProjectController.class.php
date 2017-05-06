<?php
class ProjectController extends Controller {
	
	function search() {
		$projectModel = new ProjectModel();
		$keyword = '';
		if (isset($_POST['keyword'])) {
			$keyword = $this->getInput($_POST['keyword']);
		}
		$this->assign('result', $projectModel->selectKeyword($keyword));
		$this->render();
	}
	
	function create() {
		if (!(new UserModel())->checkLogin()) {
			// create page can only be accessed by users
			header('location:' . APP_URL);
		} else {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$data = $this->getData();
				$projectModel = new ProjectModel();
				if ($res = $projectModel->isInvalid($data)) {
					$this->assign('errors', $res);
					$this->assign('mode', 'failed');
				} else {
					if ($projectModel->add($data)) {
						// successfully created a project
						$this->assign('mode', 'succeeded');
					} else {
						// failed to create a project
						$this->assign('mode', 'failed');
					}
				}
			} else {
				$this->assign('mode', 'create'); // show create project page
			}
		}
		$this->assign('title', 'New Project');
		$this->render();
	}
	
	function getData() {
		$data['pname'] = $this->getInput($_POST['pname']);
		$data['description'] = $this->getInput($_POST['description']);
		$data['minamount'] = $this->getInput($_POST['minamount']);
		$data['maxamount'] = $this->getInput($_POST['maxamount']);
		$data['endtime'] = $this->getInput($_POST['endtime']);
		$data['plannedcompletiontime'] = $this->getInput($_POST['plannedcompletiontime']);
		if (!empty($_FILES['profpic']['tmp_name'])) {
			$data['profpic'] = $_FILES['profpic'];
		}
		if (!empty($_POST['tag'])) {
			$data['tag'] = $this->getInput($_POST['tag']);
		}
		return $data;
	}
}