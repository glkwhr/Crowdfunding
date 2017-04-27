<?php
class ProjectController extends Controller {
	
	function search() {
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			
		} else {
			// show all
			$result = (new ProjectModel())->selectAll();
		}
		$this->assign('result', $result);
		$this->render();
	}
}