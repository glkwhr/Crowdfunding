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
		
	}
}