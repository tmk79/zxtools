<?
class App {
    private static $_apl;
	private $class_path = null;

    public static function apl() {
        if (null === self::$_apl) {
            self::$_apl = new self();
        }
        return self::$_apl;
	}

    private function __construct() {
        $this->class_path = dirname(__FILE__);
		$this->controller_path = dirname(__FILE__) . '/../controllers';
        spl_autoload_register(array('App', 'autoload'));
    }

    public function __get($prop_name) {
        if (!isset($this->$prop_name)) {
			echo (int)$class_name->is_singleton;
			$this->$prop_name = $class_name::getInstance();
            //$this->$prop_name = new $class_name();
        }
        return $this->$prop_name;
    }
    
    public function __destruct() {
        spl_autoload_unregister(array('App', 'autoload'));
    }

    public function autoload($class) {
        $class_file = $this->class_path . '/' . $class . '.php';
		$controller_file = $this->controller_path . '/' . $class . '.php';
        if (file_exists($class_file)) {
            require_once($class_file);
		} elseif (file_exists($controller_file)) {
			require_once($controller_file);
        } else {
			return false;
		}
    }
}
?>