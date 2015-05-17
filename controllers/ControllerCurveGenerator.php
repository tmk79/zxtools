<?
class ControllerCurveGenerator extends AppController {

	public $defaults = array(
		'curve' => array(),
        'curve_data' => array(),
	);

    public $curve;
    public $curve_data;
    public $curve_lenght = 0;

	public function __construct() {
		parent::__construct(__CLASS__);
        if (!isset($_SESSION[$this->mode])) {
			$_SESSION[$this->mode] = array();
            $_SESSION[$this->mode]['curve'] = array();
        }
		foreach ($this->defaults as $key => $val) {
			if (!isset($_SESSION[$this->mode][$key])) {
				$_SESSION[$this->mode][$key] = $val;
			}
			$this->$key = ($_SESSION[$this->mode][$key]);
		}
    }

	public function __destruct() {
		foreach ($this->defaults as $key=>$val) {
			unset($_SESSION[$this->mode][$key]);
			$_SESSION[$this->mode][$key] = ($this->$key);
		}
	}
    
    /*--- ACTIONS ---*/
	public function actionIndex() {
        $vars = new stdClass();
        $this->renderCurve();
        $vars->image = $this->image;
		$this->RenderView($this->mode, 'index', $vars);
	}
    
    public function actionNewCurve() {
        $this->curve = array();
    }
    public function actionSaveCurve() {
        if (isset($_GET['save']) && is_array($_GET['save'])) {
            $filename = isset($_GET['save']['filename']) ? $_GET['save']['filename'] : '';
            header('Content-type: application/zxt');
            header('Content-Disposition: attachment; filename="curve_' . addslashes($filename) . '.zxt"');
            $save = (object)array (
                'id' => 'zx tools',
                'type' => $this->mode,
                'curve' => $this->curve,
            );
            echo json_encode($save);
        } else {
            $this->RenderView($this->mode, 'save');
        }
    }
    public function actionOpenCurve() {
        if (isset($_FILES['file']['tmp_name'])) {
            if (!empty($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
                $open = file_get_contents($_FILES['file']['tmp_name']);
                $open = json_decode($open);
                if (is_object($open) && isset($open->id) && $open->id=='zx tools' && isset($open->type) && $open->type==$this->mode && isset($open->curve) && is_array($open->curve)) {
                    $this->curve = array();
                    foreach ($open->curve as $curve) {
                        $this->curve[] = (array)$curve;
                    }
                } else {
                    die('frong file');
                }
            }
        } else {
            $this->RenderView($this->mode, 'open');
        }
    }
    
    
    public function actionDeleteCurve() {
        $curve_id = isset($_GET['curve_id']) ? (int)$_GET['curve_id'] : false;
        if ($curve_id !== false) {
            unset($this->curve[$curve_id]);
            $tmp = array_values($this->curve);
            $this->curve = $tmp;
        }
    }

    public function actionEditCurve() {
        $curve_id = isset($_GET['curve_id']) ? (int)$_GET['curve_id'] : false;
        if (isset($_POST['curve']) && is_array($_POST['curve'])) {
            $type = isset($_POST['curve']['type']) ? (int)$_POST['curve']['type'] : 0;
            $amplitude = isset($_POST['curve']['amplitude']) ? (int)$_POST['curve']['amplitude'] : 32;
            $lenght = isset($_POST['curve']['lenght']) ? (int)$_POST['curve']['lenght'] : 32;
            $start_deg = isset($_POST['curve']['start_deg']) ? (int)$_POST['curve']['start_deg'] : 0;
            $end_deg = isset($_POST['curve']['end_deg']) ? (int)$_POST['curve']['end_deg'] : 360;
            if ($curve_id !== false) {
                $this->curve[$curve_id] = array(
                    'type' => $type,
                    'amplitude' => $amplitude,
                    'lenght' => $lenght,
                    'start_deg' => $start_deg,
                    'end_deg' => $end_deg,
                );
            } else {
                $this->curve[$curve_id] = array(
                    'type' => $type,
                    'amplitude' => $amplitude,
                    'lenght' => $lenght,
                    'start_deg' => $start_deg,
                    'end_deg' => $end_deg,
                );
            }
        } else {
            $this->RenderView($this->mode, 'add_curve');
        }
    }
    
    public function actionAddCurve() {
        if (isset($_POST['curve']) && is_array($_POST['curve'])) {
            $type = isset($_POST['curve']['type']) ? (int)$_POST['curve']['type'] : 0;
            $amplitude = isset($_POST['curve']['amplitude']) ? (int)$_POST['curve']['amplitude'] : 32;
            $lenght = isset($_POST['curve']['lenght']) ? (int)$_POST['curve']['lenght'] : 32;
            $start_deg = isset($_POST['curve']['start_deg']) ? (int)$_POST['curve']['start_deg'] : 0;
            $end_deg = isset($_POST['curve']['end_deg']) ? (int)$_POST['curve']['end_deg'] : 360;
            $this->curve[] = array(
                'type' => $type,
                'amplitude' => $amplitude,
                'lenght' => $lenght,
                'start_deg' => $start_deg,
                'end_deg' => $end_deg,
            );
            $this->actionIndex();
        } else {
            $this->RenderView($this->mode, 'add_curve');
        }
    }
    
    private function renderCurve() {
        $this->curve_lenght = 0;
        $this->curve_amplitude = 0;
        $this->curve_data = array();
        foreach ($this->curve as $curve) {
            $this->curve_lenght += $curve['lenght'];
            if ($this->curve_amplitude < $curve['amplitude']) {
                $this->curve_amplitude = $curve['amplitude'];
            }
        }
        $this->image = new FileTypeImage(array(
            'type' => 'png',
            'size_x' => $this->curve_lenght,
            'size_y' => $this->curve_amplitude * 2 + 1,
        ));
        $x0 = 0;
        $color = imagecolorallocate($this->image->img, 80,80,80);
        foreach ($this->curve as $curve) {
            for ($x = 0; $x < $curve['lenght']; $x++) {
                $deg = $curve['start_deg'] + $x * ($curve['end_deg'] - $curve['start_deg']) / $curve['lenght'];
                $y = 0;
                switch ($curve['type']) {
                    case 0:
                        $y = round($curve['amplitude'] * cos(pi() * $deg/180));
                        break;
                    case 1:
                        $y = round($curve['amplitude'] * sin(pi() * $deg/180));
                        break;
                }
                $this->curve_data[] = $y;
                imagesetpixel($this->image->img, $x0 + $x, $this->curve_amplitude - $y, $color);
                imagefilledrectangle($this->image->img, $x0+$x, $this->curve_amplitude, $x0+$x, $this->curve_amplitude - $y, $color);
            }
            $x0 += $curve['lenght'];
        }
        $color = imagecolorallocate($this->image->img, 255,255,255);
        //imagefilledrectangle($this->image->img, 0, $this->curve_amplitude, $this->curve_lenght, $this->curve_amplitude, $color);
    }
}