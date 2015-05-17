<?include 'top.php'?>
<div class="btn-group btn-menu">
    <a class="btn btn-default ajax ajax-reload confirm" href="index.php?mode=<?=$this->mode?>&action=NewCurve&ajax=1"><span class="glyphicon glyphicon-file"></span> New Curve</a>
    <a class="btn btn-default ajax ajax-show" href="index.php?mode=<?=$this->mode?>&action=OpenCurve&ajax=1"><span class="glyphicon glyphicon-floppy-disk"></span> Open Curve</a>
    <a class="btn btn-default ajax ajax-show" href="index.php?mode=<?=$this->mode?>&action=SaveCurve&ajax=1"><span class="glyphicon glyphicon-floppy-disk"></span> Save Curve</a>
    <a class="btn btn-default ajax ajax-show" href="index.php?mode=<?=$this->mode?>&action=AddCurve&ajax=1">Add Curve</a>
    <a class="btn btn-default animate-curve" href="#">Animate Curve</a>
</div>

<div><?=$vars->image->as_html(array('zoom' => 2))?></div>
<div>Total curve lenght: <?=$this->curve_lenght?></div>

<div>
    <?foreach ($this->curve as $curve_id=>$curve) {?>
        <form class="ajax-form ajax-reload" action="index.php?mode=<?=$this->mode?>&action=EditCurve&curve_id=<?=$curve_id?>" method="post">
            <div class="form" style="float:left;margin: 5px;">
                <div class="form-header">Curve #<?=$curve_id?></div>
                <div class="form-content">
                    <table>
                        <tr>
                            <td align="right">Type:</td>
                            <td>
                                <select name="curve[type]">
                                    <option value="0"<?=$curve['type'] == 0 ? ' selected="selected"' : ''?>>cos</option>
                                    <option value="1"<?=$curve['type'] == 1 ? ' selected="selected"' : ''?>>sin</option>
                                </select>
                            </td>
                        </tr><tr>
                            <td align="right">Amplitude:</td>
                            <td><input type="text" name="curve[amplitude]" value="<?=$curve['amplitude']?>" /></td>
                        </tr><tr>
                            <td align="right">Lenght:</td>
                            <td><input type="text" name="curve[lenght]" value="<?=$curve['lenght']?>" /></td>
                        </tr><tr>
                            <td>Start deg:</td>
                            <td><input type="text" name="curve[start_deg]" value="<?=$curve['start_deg']?>" /></td>
                        </tr><tr>
                            <td>End deg:</td>
                            <td><input type="text" name="curve[end_deg]" value="<?=$curve['end_deg']?>" /></td>
                        </tr><tr>
                            <td></td>
                            <td>
                                <a class="btn btn-default submit" href="#">Save</a>
                                <a class="btn btn-default ajax ajax-reload confirm" href="index.php?mode=<?=$this->mode?>&action=DeleteCurve&curve_id=<?=$curve_id?>">Delete</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>  
        </form>
    <?}?>
</div>
<div class="clearfix"></div>