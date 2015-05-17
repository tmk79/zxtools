<?include 'top.php'?>

<div class="form-block">
<form action="index.php" method="get" class="form-inline">
    <input type="hidden" name="mode" value="<?=$this->mode?>" />
    <input type="hidden" name="action" value="calculate" />
    <div class="form">
        <div class="form-header">Create new spritepack</div>
        <div class="form-content">
            <table>
                <tr>
                    <td>Waves count:</td>
                    <td><input type="text" name="waves_count" value="1" /></td>
                </tr><tr>
                    <td>Oscillations lenght:</td>
                    <td><input type="text" name="lenght" value="96" /></td>
                </tr><tr>
                    <td>Start value:</td>
                    <td><input type="text" name="start_value" value="32" /></td>
                </tr><tr>
                    <td>End value:</td>
                    <td><input type="text" name="end_value" value="0" /></td>
                </tr>
            </table>
        </div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Calculate</a>
		</div>
    </div>
</form>
</div>