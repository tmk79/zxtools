<?
class ControllerChunkSpriter8x8 extends AppController {

	public $defaults = array(
		'sprites_color_mode' => 0,
		'sprites_bits_mode' => 0,
		'sprites_size_x' => 1,
		'sprites_size_y' => 1,
		'chunks_size_x' => 8,
		'chunks_size_y' => 8,
		'chunks' => array(
			0 => array (0,0,0,0,0,0,0,0),
			1 => array (255,255,255,255,255,255,255,255),
		),
		'sprites' => array(),
	);

	public $sprites_color_mode_def = array (
		0 => 'monochrome',
		1 => 'standart color',
		2 => 'gigascreen color 8x8',
	);

	public $sprites_bits_mode_def = array (
		0 => 'standart',
		1 => 'gigascreen',
	);
	
	public function __construct() {
		parent::__construct(__CLASS__);
		if (!isset($_SESSION[$this->mode])) {
			$_SESSION[$this->mode] = array();
			$file = FileTypeImage::init(array('type' => 'png'));
			$_SESSION['imgCapturePng'] = $file->as_binary();
			$_SESSION['imgCaptureMime'] = $file->as_mime(array('zoom' => 2));
		}
		foreach ($this->defaults as $key => $val) {
			if (!isset($_SESSION[$this->mode][$key])) {
				$_SESSION[$this->mode][$key] = ($val);
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
		$this->RenderView($this->mode, 'index');
	}

	public function actionViewSprites() {
		$vars = new stdClass();
		$vars->chunks = $this->renderChunks();
		$vars->sprites = $this->renderSprites();
		$vars->chunks_usage = $this->getChunksUsage();
		$vars->chunks_bytesize = sizeof($vars->chunks) * 8;
		//$vars->sprites_bytesize = $this->calcSpritesBytesize();
		$this->RenderView($this->mode, 'view', $vars);
	}
	
	public function actionSpriteEdit() {
		$selected_sprite_id = isset($_GET['selected_sprite_id']) ? $_GET['selected_sprite_id'] : 0;
		if (isset($_POST['sprite'])) {
			header('Location: index.php?ajax=1&mode=' . $this->mode . '&action=ViewSprites');
		}
		$vars = new stdClass();
		$vars->sprite_id = $selected_sprite_id;
		$vars->chunks = $this->renderChunks();
		$vars->sprite = $this->renderSprite($selected_sprite_id);
		$vars->chunks_usage = $this->getChunksUsage();
		$vars->chunks_bytesize = sizeof($vars->chunks) * 8;
		//$vars->sprites_bytesize = $this->calcSpritesBytesize();
		$this->RenderView($this->mode, 'edit_sprite', $vars);
	}
	
	public function actionSave() {
		if (isset($_GET['save']) && is_array($_GET['save'])) {
			header('Content-type: application/asm');
			header('Content-Disposition: attachment; filename="spritepack.asm"');
			$save_sprites_mode = isset($_GET['save']['sprites_mode']) ? (int)$_GET['save']['sprites_mode'] : 0;
			$save_chunks_mode = isset($_GET['save']['chunks_mode']) ? (int)$_GET['save']['chunks_mode'] : 0;
			$save_with_code = isset($_GET['save']['with_code']);
			$html_chunks = "\r\n;--- CHUNKS DATA:\r\n";
			$html_sprites = "\r\n;--- SPRITES DATA:\r\n";
			$html_sprites_size = "\r\n;--- SPRITES SIZE X,Y:\r\n";
			foreach	($this->sprites as $sprite_id=>$sprite) {
				$html_sprites .= "SPR_" . $sprite_id . "\r\n";
				$html_sprites_size .= "SPR_SIZE_" . $sprite_id . "\tDB\t" . sizeof($sprite[0]) . "," . sizeof($sprite) . "\r\n";
				foreach ($sprite as $y=>$xline) {
					$html_sprites .= "SPR_" . $sprite_id . "_" . $y . "\t";
					if ($save_sprites_mode == 0) { //db chunk_id * 8
						$html_sprites .= "DB\t8*" . implode(", 8*", $xline);						
					} elseif ($save_sprites_mode == 1) { // db chunk_id
						$html_sprites .= "DB\t" . implode(",", $xline);
					} else { // dw chunk_id_address
						if ($save_chunks_mode == 0) {
							$html_sprites .= "DW\tCHUNK_" . implode(", CHUNK_", $xline);
						} else {
							$html_sprites .= "DW\tCHUNKS+" . implode(", CHUNKS+", $xline);
						}
					}
					$html_sprites .= "\r\n";
				}
			}
			if ($save_chunks_mode == 0) { //linear chunks mode
				foreach	($this->chunks as $chunk_id=>$chunk) {
					$html_chunks .= "CHUNK_" . $chunk_id . "\tDB\t" . implode(",", $chunk) . "\r\n";
				}
			} else { //hi-adr chunks mode
				$chunks = array();
				$html_chunks .= "CHUNKS\r\n";
				for ($i=0; $i<8; $i++) {
					$html_chunks .= "\tDB\t";
					for ($j=0; $j<256; $j++) {
						$html_chunks .= ($j!=0 ? ',' : '') . (isset($this->chunks[$j][$i]) ? $this->chunks[$j][$i] : 0);
					}
					$html_chunks .= "\r\n";
				}
			}
			
			echo '<pre>';
			echo $html_sprites_size . $html_sprites . $html_chunks;
		} else {
			$this->RenderView($this->mode, 'save');
		}
	}

	public function actionNew() {
		if (isset($_POST['new']) && is_array($_POST['new'])) {
			$this->defaults['sprites_size_x'] = isset($_POST['new']['sprites_size_x']) ? (int)$_POST['new']['sprites_size_x'] : 0;
			$this->defaults['sprites_size_y'] = isset($_POST['new']['sprites_size_y']) ? (int)$_POST['new']['sprites_size_y'] : 0;
			foreach ($this->defaults as $key=>$val) {
				$_SESSION[$this->mode][$key] = $this->$key;
				$this->$key = $val;
			}
			echo json_encode(array(
				'vars' => array(
					'sprites_size_x' => $this->sprites_size_x,
					'sprites_size_y' => $this->sprites_size_y,
				),
				'tools_info' => $this->toolInfo(),
			));
		} else {
			$this->RenderView($this->mode, 'new');
		}
	}
	
	public function actionCapture() {
		$capture_x = isset($_POST['capture_x']) ? (int)$_POST['capture_x'] : false;
		$capture_y = isset($_POST['capture_y']) ? (int)$_POST['capture_y'] : false;
		$size_x = isset($_POST['size_x']) ? (int)$_POST['size_x'] : false;
		$size_y = isset($_POST['size_y']) ? (int)$_POST['size_y'] : false;
		$imgdata = $_SESSION['imgCapturePng'];
		if ($capture_x !== false && $capture_y !== false && $size_x != 0 && $size_y != 0) {
			$img = imagecreatefromstring($imgdata);
			$sprite = array();
			for ($y=0; $y<$size_y; $y++) {
				for ($x=0; $x<$size_x; $x++) {
					$chunk = array();
					for ($yb=0; $yb<8; $yb++) {
						$yy = $capture_y * 8 + $y * 8 + $yb;
						$chunk[$yb] = 0;
						for ($xb=0; $xb<8; $xb++) {
							$xx = $capture_x * 8 + $x * 8 + $xb;
							$color = imagecolorat($img, $xx, $yy);
							if ($color != 0) {
								$chunk[$yb] += pow(2, (7 - $xb));
							}
						}
					}
					$sprite[$y][$x] = $this->addChunk($chunk);
				}
			}
			$sprite_id = array_search($sprite, $this->sprites);
			if ($sprite_id === false) {
				$this->sprites[] = $sprite;
				$sprite_id = sizeof($this->sprites) - 1;
			}
		}
		echo json_encode(array(
			'tools_info' => $this->toolInfo(),
		));
	}
	
	public function actionSpriteSort() {
		$selected_sprite_id = isset($_GET['selected_sprite_id']) ? $_GET['selected_sprite_id'] : 0;
		$sort_direction = isset($_GET['sort_direction']) ? $_GET['sort_direction'] : 0;
		if (is_numeric($selected_sprite_id)) {
			$id = $selected_sprite_id + ($sort_direction ? +1 : -1);
			if ($id >= 0 && $id < sizeof($this->sprites)) {
				$spr = $this->CopySprite($this->sprites[$selected_sprite_id]);
				unset ($this->sprites[$selected_sprite_id]);
				$this->sprites[$selected_sprite_id] = $this->CopySprite($this->sprites[$id]);
				unset($this->sprites[$id]);
				$this->sprites[$id] = $this->CopySprite($spr);
			}
		}
		header('Location: index.php?ajax=1&mode=' . $this->mode . '&action=ViewSprites');
	}
	
	public function CopySprite(&$spr) {
		$spr_dest = array();
		foreach ($spr as $y=>$x_data) {
			$spr_dest[$y] = array();
			foreach($x_data as $x=>$byte) {
				$spr_dest[$y][] = $byte;
			}
		}
		return $spr_dest;
	}
	
	public function actionSpriteDelete() {
		$selected_sprite_id = isset($_GET['selected_sprite_id']) ? (int)$_GET['selected_sprite_id'] : 0;
		unset($this->sprites[$selected_sprite_id]);
		$tmp = array_values($this->sprites);
		unset($this->sprites);
		$this->sprites = $tmp;
		header('Location: index.php?ajax=1&mode=' . $this->mode . '&action=ViewSprites');
	}
	
	
	/*--- FUNCTIONS ---*/
	public function toolInfo() {
		$chunks_qty = sizeof($this->chunks);
		$sprites_qty = sizeof($this->sprites);
		$size_x = $this->sprites_size_x ? $this->sprites_size_x : 'custom';
		$size_y = $this->sprites_size_y ? $this->sprites_size_y : 'custom';
		$html = '<span>SizeX: <span>' . $size_x . '</span></span>';
		$html .= '<span>SizeY: <span>' . $size_y . '</span></span>';
		$html .= '<span>ChunksQty: <span>' . $chunks_qty . '</span></span>';
		$html .= '<span>SpritesQty: <span>' . $sprites_qty . '</span></span>';
		return $html;
	}
	
	function addChunk($chunk) {
		$chunk_id = array_search($chunk, $this->chunks);
		if ($chunk_id === false) {
			$this->chunks[] = $chunk;
			$chunk_id = sizeof($this->chunks) - 1;
		}
		return $chunk_id;
	}

	function renderSprites() {
		$imgs = array();
		for ($sprite_id=0; $sprite_id<sizeof($this->sprites); $sprite_id++) {
			$imgs[$sprite_id] = $this->renderSprite($sprite_id);
		}
		return $imgs;
	}
	
	function renderSprite($sprite_id) {
		$size_y = sizeof($this->sprites[$sprite_id]);
		$size_x = sizeof($this->sprites[$sprite_id][0]);
		$img = new FileTypeImage(array('size_x' => $size_x * 8, 'size_y' => $size_y * 8));
		for ($y=0; $y<$size_y; $y++) {
			for ($x=0; $x<$size_x; $x++) {
				$chunk_id = $this->sprites[$sprite_id][$y][$x];
				$chunk = $chunks[$chunk_id];
				for ($yb=0; $yb<8; $yb++) {
					$yy = $y * 8 + $yb;
					$byte = $chunk[$yb];
					for ($xb=0; $xb<8; $xb++) {
						$bit = (bool)(pow(2, (7 - $xb)) & $byte);
						$color = imagecolorallocate($img->img, 255 * $bit, 255 * $bit, 255 * $bit);
						$xx = $x * 8 + $xb;
						imagefilledrectangle($img->img, $xx, $yy, $xx + 1, $yy + 1, $color);
					}
				}
			}
		}
		return $img;
	}
	
	
	function renderChunks() {
		$imgs = array();
		foreach ($this->chunks as $chunk_id=>$chunk) {
			$imgs[$chunk_id] = new FileTypeImage(array('size_x' => 8, 'size_y' => 8));
			for ($yb=0; $yb<8; $yb++) {
				$byte = $chunk[$yb];
				for ($xb=0; $xb<8; $xb++) {
					$bit = (bool)(pow(2, (7 - $xb)) & $byte);
					$color = imagecolorallocate($imgs[$chunk_id]->img, 255 * $bit, 255 * $bit, 255 * $bit);
					imagefilledrectangle($imgs[$chunk_id]->img, $xb, $yb, $xb + 1, $yb + 1, $color);
				}
			}
		}
		return $imgs;
	}
	
	function getChunksUsage() {
		$chunks_used = array();
		foreach ($this->sprites as $sprite_id=>$sprite) {
			foreach ($sprite as $y=>$line) {
				foreach ($line as $x=>$chunk_id) {
					if (!isset($chunks_used[$chunk_id])) {
						$chunks_used[$chunk_id] = array();
					}
					$chunks_used[$chunk_id][] = array(
						'sprite_id' => $sprite_id,
						'x' => $x,
						'y' => $y,
					);
				}
			}
		}
		return $chunks_used;
	}

}
?>