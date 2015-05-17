<?
class ControllerIndex extends AppController {

	public function __construct() {
		parent::__construct(__CLASS__);
	}

	/*--- ACTIONS ---*/
	public function actionIndex() {
		$this->RenderView($this->mode, 'index');
	}

	public function actionGetConfirmForm() {
		$vars = new stdClass();
		$vars->question = isset($_POST['question']) ? $_POST['question'] : false;
		$vars->href = isset($_POST['href']) ? $_POST['href'] : false;
		$vars->class = isset($_POST['cl']) ? $_POST['cl'] : false;
		$this->RenderView($this->mode, 'confirm_form', $vars);
	}

}