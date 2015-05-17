<?
class ControllerTgDampedOscillations extends AppController {

	public function __construct() {
		parent::__construct(__CLASS__);
	}

    /*--- ACTIONS ---*/
	public function actionIndex() {
		$this->RenderView($this->mode, 'index');
	}
    
    public function actionCalculate() {
        $vars = new stdClass();
        print_r($_GET);
        $vars->waves_count = isset($_GET['waves_count']) ? (int)$_GET['waves_count'] : false;
        $vars->lenght = isset($_GET['lenght']) ? (int)$_GET['lenght'] : false;
        $vars->start_value = isset($_GET['start_value']) ? (int)$_GET['start_value'] : false;
        $vars->end_value = isset($_GET['end_value']) ? (int)$_GET['end_value'] : false;
        if ($vars->waves_count < 1) {
            $vars->waves_count = 1;
        }
        if ($vars->lenght < 1) {
            $vars->lenght = 1;
        }
        $vars->amplitude = 2 * abs($vars->start_value - $vars->end_value);
        $vars->image = new FileTypeImage(array(
            'type' => 'png',
            'size_x' => $vars->lenght,
            'size_y' => $vars->amplitude,
        ));
        $vars->result = array();
        for ($x=0; $x<$vars->lenght; $x++) {
            $val = $vars->amplitude/2 * cos();
        }
        
        
        $color = imagecolorallocate($vars->image->img, 255, 255, 255);
        //$vars->image->img
        
        $this->RenderView($this->mode, 'calculate', $vars);
    }

}