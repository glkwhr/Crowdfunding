<?php
class ProjectController extends Controller {

	function search($type = 'all') {
		$projectModel = new ProjectModel();
		$keyword="";
		if (isset($_POST['keyword'])) {
			$keyword = $this->getInput($_POST['keyword']);
		}
		$this->assign('result', $projectModel->selectKeyword($keyword, $type));
		$this->render();
	}
	
	function user($uname="") {
		$projectModel = new ProjectModel();
		$this->assign('result', $projectModel->selectKeyword($uname, 'user'));
		$this->render();
	}
	
	function comment($pid="") {
		if (empty($pid)) {
			header("location:" . APP_URL . "/project/search");
		}
		if (!(new UserModel())->checkLogin()) {
			header("location:" . APP_URL . "/user/login");
		} else {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
				$data['uname'] = $this->getInput($_SESSION['user']['username']);
				$data['pid'] = $this->getInput($pid);
				$data['content'] = $this->getInput($_POST['comment']);
				$commentModel = new CommentModel();
				if (!$commentModel->isInvalid($data)) {
					$commentModel->add($data);
				}
			}
			header("location:" . APP_URL . "/project/view/" . $pid);
		}
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

	function edit($pid) {
		$userModel = new UserModel();
		$projectModel = new ProjectModel();
		if ($userModel->checkLogin()) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$data = $this->getData();
				$res = array();
				if ($res = $projectModel->isNewInvalid($pid,$data)) {
					$this->assign('errors', $res);
					$this->assign('mode', 'failed');
				} else {
					if ($projectModel->update($pid, $data)) {
						// successfully updated
						$this->assign('mode', 'succeeded');
					} else {
						// failed to update
						$this->assign('mode', 'failed');
					}
				}
			} else {
				$this->assign('mode', 'edit');
			}
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$olddata = $projectModel->select($pid);
			$this->assign('data', $olddata);
			$this->assign('title', 'Project Edit');
			$this->render();
		} else {
			header("location:" . APP_URL . "/user/login");
		}
	}
	
	function view($pid) {
		if (empty($pid)) {
			header("location:" . APP_URL . "/project/search");
		}
		// mode: guest, user, owner
		$projectModel = new ProjectModel();
		$mode = 'guest';
		if (empty($row = $projectModel->select($pid))) {
			// project doesn't exist
			$mode = 'notfound';
		} else {
			$this->assign('row', $row);
			if ((new UserModel())->checkLogin()) {
				// user or owner
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
				if ($row['uname'] == $_SESSION['user']['username']) {
					$mode = 'owner';
				} else {
					$mode = 'user';
				}
			}
			
			// get comments
			if (!empty($comments = (new CommentModel())->getComment($pid))) {
				$this->assign('hasComment', true);
				$this->assign('comments', $comments);
			} else {
				$this->assign('hasComment', false);
			}
		}
		$this->assign('mode', $mode);
		$this->render();
	}
	
	function getData() {
		$data['pname'] = $this->getInput($_POST['pname']);
		$data['description'] = $this->getInput($_POST['description']);
		if (isset($_POST['minamount'])) {
			$data['minamount'] = $this->getInput($_POST['minamount']);
		}
		if (isset($_POST['maxamount'])) {
			$data['maxamount'] = $this->getInput($_POST['maxamount']);
		}
		if (isset($_POST['endtime'])) {
			$data['endtime'] = $this->getInput($_POST['endtime']);
		}
		if (isset($_POST['plannedcompletiontime'])) {
			$data['plannedcompletiontime'] = $this->getInput($_POST['plannedcompletiontime']);
		}
		if (isset($_POST['progress']) && !empty($_POST['progress'])) {
			$data['progress'] = $this->getInput($_POST['progress']);
		}
		if (!empty($_FILES['profpic']['tmp_name'])) {
			$data['profpic'] = $_FILES['profpic'];
		}
		if (!empty($_POST['tag'])) {
			$data['tag'] = $this->getInput($_POST['tag']);
		}
		return $data;
	}
}
