<?php
function bytes_to_string($size, $precision = 0)
{
    $sizes = array(_('YB'), _('ZB'), _('EB'), _('PB'), _('TB'), _('GB'), _('MB'), _('KB'), _('bytes'));
    $total = count($sizes);
    while($total-- && $size > 1024) $size /= 1024;
    $return['num'] = round($size, $precision);
    $return['str'] = $sizes[$total];
    return $return;
}
function time_ago($tm,$rcs = 0)
{
    $cur_tm = time(); $dif = $cur_tm-$tm;
    $pds = array('second','minute','hour','day','week','month','year','decade');
    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

    $no = floor($no); if($no <> 1) $pds[$v] .='s';
    $x=sprintf(_(sprintf('%%d %s ago', $pds[$v])), $no);
    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
    return $x;
}