<form class="ajax-form ajax-reload waitbox" action="index.php?mode=<?=$this->mode?>&action=AddCurve&ajax=1" method="post">
    <div class="form">
        <div class="form-header">Add Curve</div>
        <div class="form-content">
            <table>
                <tr>
                    <td align="right">Type:</td>
                    <td>
                        <select name="curve[type]">
                            <option value="0">cos</option>
                            <option value="1">sin</option>
                        </select>
                    </td>
                </tr><tr>
                    <td align="right">Amplitude:</td>
                    <td><input type="text" name="curve[amplitude]" value="32" /></td>
                </tr><tr>
                    <td align="right">Lenght:</td>
                    <td><input type="text" name="curve[lenght]" value="32" /></td>
                </tr><tr>
                    <td>Start deg:</td>
                    <td><input type="text" name="curve[start_deg]" value="0" /></td>
                </tr><tr>
                    <td>End deg:</td>
                    <td><input type="text" name="curve[end_deg]" value="360" /></td>
                </tr>
            </table>
        </div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Add</a>
			<a class="btn btn-default popup-cancel" href="#">Cancel</a>
		</div>
    </div>
</form>