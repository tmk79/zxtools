<?
class FileTypeMgs extends FileType {

	public $type = 'ZX Multigigasreen Picture';

	static $allowed_ext = array('mgs', 'mg8', 'mg4', 'mg2', 'img');

	protected $png = array();
	
	private $version = 1;
	private $char_size = 8;
	private $border_color_0 = 0;
	private $border_color_1 = 0;
	private $bitplan0 = array(); // 6144 bytes
	private $bitplan1 = array();
	private $attr0 = array(); // 6144 / 3072 / 1536 / 768 bytes
	private $attr1 = array();
	
	const SIZE_8X1 = 1;
	const SIZE_8X2 = 2;
	const SIZE_8X4 = 4;
	const SIZE_8X8 = 8;
	
	public static function is_type($type) {
		return in_array($type, self::$allowed_ext);
	}

	function __construct($param = array()){
		$param = array_merge(array(
				'filename' => false,
				'type' => false,
				'size' => $this->SIZE_8X8,
			)
			,$param
		);
		$this->filename = $param['filename'];
		$this->file_extension = $param['type'];

		if (!empty($this->filename)) {
			$this->open();
		} else {
			$this->create();
		}
	}
	
	public function open() {
		$f = fopen($this->filename, 'rb');
		$mgs_ident = fread($f, 3);
		if ($mgs_ident != 'MGS' && $mgs_ident != 'MGH') {
			$this->error = 'WRONG FILE STRUCTURE';
			return false;
		}
		$this->version = ord(fread($f, 1));
		$this->char_size = ord(fread($f, 1));
		if ($this->version >= 1) {
			$this->border_color_0 = ord(fread($f, 1));
			$this->border_color_1 = ord(fread($f, 1));
		}
		if ($this->file_extension != 'mgs') {
		
			
			fseek($f, 256);
			$this->bitplan0 = $this->read_zx_bitplan($f);
			$this->bitplan1 = $this->read_zx_bitplan($f);
			
			
			
		} else {
			for ($i=0; $i<6144; $i++) {
				$this->bitplan0[$i] = ord(fread($f, 1));
			}
			for ($i=0; $i<6144; $i++) {
				$this->bitplan1[$i] = ord(fread($f, 1));
			}
		}
		
		fclose($f);
	}

	public function getColorAt($x, $y) {
		$colors = array(
			array(0,0,0),
			array(108,108,108),
			array(148,148,148),
			array(255,255,255),
		);
		$bitmask = array(128,64,32,16,8,4,2,1);
		$bit = $x % 8;
		$x = floor($x/8);
		$byte0 = (int)$this->bitplan0[$y*32 + $x];
		$byte1 = (int)$this->bitplan1[$y*32 + $x];
		$pix0 = (bool)($byte0 & $bitmask[$bit]);
		$pix1 = (bool)($byte1 & $bitmask[$bit]);
		$rgb = $colors[2 * $pix1 + $pix0];
		return $rgb;
	}
	
	private function png_key($param) {
		return $param['size'];
	}

	public function render($param = array()) {
		$param = array_merge(array(
				'size' => 1,
				'with_border' => false,
			), $param
		);
		$img = imagecreatetruecolor(256 * $param['size'], 192 * $param['size']);
		for ($y=0; $y<192; $y++) {
			for ($x=0; $x<256; $x++) {
				$rgb = $this->getColorAt($x, $y);
				$color = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
				$xx = $x * $param['size'];
				$yy = $y * $param['size'];
				imagefilledrectangle($img, $xx, $yy, $xx + $param['size'] - 1, $yy + $param['size'] - 1, $color);
			}
		}
		ob_start();
		imagepng($img);
		$this->png[$this->png_key($param)] = ob_get_clean();
	}
	
	public function as_html($param = array()) {
		$param = array_merge(array(
				'size' => 1,
				'with_border' => false,
			), $param
		);
		if (!isset($this->png[$this->png_key($param)])) {
			$this->render($param);
		}
		return 'data:image/jpeg;base64,' . base64_encode($this->png[$this->png_key($param)]);
	}
	
	public function as_png($param = array()) {
		$param = array_merge(array(
				'size' => 1,
				'with_border' => false,
				'base64' => false,
			), $param
		);
		if (!isset($this->png[$this->png_key($param)])) {
			$this->render($param);
		}
		return $param['base64'] ? base64_encode($this->png[$this->png_key($param)]) : $this->png[$this->png_key($param)];
	}


}
?>