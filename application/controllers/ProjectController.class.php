<?php
class ProjectController extends Controller {

	function search($type = 'all') {
		$projectModel = new ProjectModel();
		$keyword="";
		if (isset($_POST['keyword'])) {
			$keyword = $this->getInput($_POST['keyword']);
		}
		$this->assign('result', $projectModel->selectKeyword($keyword, $type));
		
		if ((new UserModel())->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$this->assign('user', $_SESSION['user']['username']);
			$this->assign('likeModel', new LikeModel());
		}
		
		$this->render();
	}
	
	function user($uname="") {
		$projectModel = new ProjectModel();
		$this->assign('result', $projectModel->selectKeyword($uname, 'user'));
		
		if ((new UserModel())->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$this->assign('user', $_SESSION['user']['username']);
			$this->assign('likeModel', new LikeModel());
		}
		
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
	
	function pledge() {
		$userModel = new UserModel();
		if ($userModel->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$data = $userModel->select($_SESSION['user']['username'], array('uname', 'ccn'));
			if (empty($data['ccn'])) {
				$this->assign('mode', 'noccn');
			} else {
			unset($data['ccn']);
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if (isset($_POST['pid']) && isset($_POST['pledge'])) {
						$data['pid'] = $_POST['pid'];
						$data['amount'] = $_POST['pledge'];
						$pledgeModel = new PledgeModel();
						if ($pledgeModel->add($data)) {
							$this->assign('data', $data);
							$this->assign('mode', 'succeeded');
						} else {
							$this->assign('mode', 'failed');
						}
					} else {
						$this->assign('mode', "failed");
					}
				}
			}
		} else {
			header("location:" . APP_URL . "user/login");
		}
		$this->render();
	}
	
	function rate() {
		$userModel = new UserModel();
		if ($userModel->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$data = $userModel->select($_SESSION['user']['username'], array('uname'));
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (isset($_POST['pid']) && isset($_POST['rate'])) {
					$data['pid'] = $_POST['pid'];
					$data['score'] = $_POST['rate'];
					$pledgeModel = new PledgeModel();
					$rateModel = new RateModel();
					// TODO check the project status
					if ($pledgeModel->exists($data['uname'], $data['pid']) && !$rateModel->exists($data['uname'], $data['pid'])) {
						if ($rateModel->add($data)) {
							$this->assign('mode', 'succeeded');
						} else {
							$this->assign('mode', 'failed');
						}
					} else {
						$this->assign('mode', 'denied');
					}
				} else {
					$this->assign('mode', 'failed');
				}
				$this->assign('data', $data);
			}
			$this->render();
		} else {
			header("location:" . APP_URL . "user/login");
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
			$olddata = $projectModel->select($pid);
			$this->assign('data', $olddata);
			$this->assign('title', 'Project Edit');
			$this->render();
		} else {
			header("location:" . APP_URL . "/user/login");
		}
	}
	
	function deleteSample($data) {
		$data = explode(' ', $data);
		if (!unlink(SAMPLE_PROJ_PATH . $data[0] . "/" . $data[1])) {
			
		}
		(new SampleModel())->delete($data);
		header("location:" . APP_URL . "/project/view/" . $data[0]);
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
			$likeModel = new LikeModel();
			$this->assign('likeCount', $likeModel->countLiked($pid));
			$rateModel = new RateModel();
			$pledgeModel = new PledgeModel();
			if ((new UserModel())->checkLogin()) {
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}				
				$this->assign('hasLiked', $likeModel->hasLiked($_SESSION['user']['username'], $pid));
				$this->assign('hasPledged', $pledgeModel->exists($_SESSION['user']['username'], $pid));
				$this->assign('hasRated', $rateModel->exists($_SESSION['user']['username'], $pid));
			}			
			
			$this->assign('backerCount', $pledgeModel->countBackers($pid));
			
			$this->assign('rateCount', $rateModel->countRate($pid));
			$this->assign('avgScore', number_format($rateModel->avgScore($pid), 1));
			
			// get samples
			if (!empty($samples = (new SampleModel())->getSample($pid))) {
				$this->assign('hasSample', true);
				$this->assign('samples', $samples);
			} else {
				$this->assign('hasSample', false);
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
	
	function like($pid) {
		if (empty($pid) || empty($row = (new ProjectModel())->select($pid, array('pid', 'pname', 'uname')))) {
			header("location:" . APP_URL);
		}
		$guest = "";
		if ((new UserModel())->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$guest = $_SESSION['user']['username'];
		}
		if (empty($guest)) {
			header("location:" . APP_URL . "/user/login");
		} else {
			$likeModel = new LikeModel();
			$this->assign('pid', $row['pid']);
			$this->assign('pname', $row['pname']);
			if ($likeModel->hasLiked($guest, $pid)) {
				$this->assign('mode', 'liked');
			} else {
				if ($likeModel->add(array('uname'=>$guest, 'pid'=>$pid))) {
					$this->assign('mode', 'succeeded');
				} else {
					$this->assign('mode', 'failed');
				}
			}
		}
		$this->render();
	}
	
	function unlike($pid) {
		if (empty($pid) || empty($row = (new ProjectModel())->select($pid, array('pid', 'pname', 'uname')))) {
			header("location:" . APP_URL);
		}
		$guest = "";
		if ((new UserModel())->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$guest = $_SESSION['user']['username'];
		}
		if (empty($guest)) {
			header("location:" . APP_URL . "/user/login");
		} else {
			$likeModel = new LikeModel();
			$this->assign('pid', $row['pid']);
			$this->assign('pname', $row['pname']);
			if (!$likeModel->hasLiked($guest, $pid)) {
				$this->assign('mode', 'notliked');
			} else {
				if ($likeModel->delete(array('uname'=>$guest, 'pid'=>$pid))) {
					$this->assign('mode', 'succeeded');
				} else {
					$this->assign('mode', 'failed');
				}
			}
		}
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
		if (!empty($_FILES['sample']['tmp_name'])) {
			$data['sample'] = $_FILES['sample'];
		}
		if (!empty($_POST['tag'])) {
			$data['tag'] = $this->getInput($_POST['tag']);
		}
		return $data;
	}
}
