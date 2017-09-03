<?php

use WHMCS\Application;

require("../init.php");

/*
*** USAGE SAMPLES ***

<script language="javascript" src="feeds/productpricing.php?pid=1&currency=1&billingcycle=semiannually"></script>

<script language="javascript" src="feeds/productpricing.php?pid=5&currency=2&billingcycle=semiannually"></script>

*/
    $whmcs = Application::getInstance();
    $pid = $whmcs->get_req_var('pid');
    $currencyid = $whmcs->get_req_var('currencyid');
    $billingcycle = $whmcs->get_req_var('billingcycle');
    
    // Verify user input for pid exists, is numeric, and as is a valid id
    if (is_numeric($pid)) {
        $result = select_query("tblproducts", "", array("id" => $pid));
        $data = mysql_fetch_array($result);
        $pid = $data['id'];
        $paytype = $data['paytype'];
    } else {
        $pid = '';
    }

    if (!$pid) {
        widgetoutput('Product ID Not Found');
    }

    $currencyid = $whmcs->get_req_var('currency');
    // Support for older currencyid variable
    if (!$currencyid) {
        $currencyid = $whmcs->get_req_var('currencyid');
    }
    if (!is_numeric($currencyid)) {
        $currency = array();
    } else {
        $currency = getCurrency('', $currencyid);
    }

    if (!$currency || !is_array($currency) || !isset($currency['id'])) {
        $currency = getCurrency();
    }
    $currencyid = $currency['id'];

    $result = select_query("tblpricing","",array("type"=>"product","currency"=>$currencyid,"relid"=>$pid));
    $data = mysql_fetch_array($result);
    $msetupfee = $data['msetupfee'];
    $qsetupfee = $data['qsetupfee'];
    $ssetupfee = $data['ssetupfee'];
    $asetupfee = $data['asetupfee'];
    $bsetupfee = $data['bsetupfee'];
    $tsetupfee = $data['tsetupfee'];
    $monthly = $data['monthly'];
    $quarterly = $data['quarterly'];
    $semiannually = $data['semiannually'];
    $annually = $data['annually'];
    $biennially = $data['biennially'];
    $triennially = $data['triennially'];

    $systemurl = App::getSystemUrl();

    if ($paytype=="free") {

        $output .= $_LANG['orderfree'];

    } elseif ($paytype=="onetime") {

        $output .= formatCurrency($monthly);
        if ($msetupfee!="0.00") $output .= " + ".formatCurrency($msetupfee)." ".$_LANG['ordersetupfee'];

    } elseif ($paytype=="recurring") {

        if (($billingcycle =="triennially") AND ($triennially>=0)) {
            $output .= formatCurrency($triennially/36); 
        }

        if (($billingcycle =="biennially") AND ($biennially>=0)) {
            $output .= formatCurrency($biennially/24);  
        }

        if (($billingcycle =="annually") AND ($annually>=0)) {
            $output .= formatCurrency($annually/12);    
        }

        if (($billingcycle =="semiannually") AND ($semiannually>=0)) {
            $output .= formatCurrency($semiannually/6);       
        }

        if (($billingcycle =="quartely") AND ($quarterly>=0)) {
            $output .= formatCurrency($quarterly/3); 
        }

        if (($billingcycle =="monthly") AND ($monthly>=0)) {
            $output .= formatCurrency($monthly);
        }


    }


    widgetoutput($output);

function widgetoutput($value) {
    echo "document.write('".addslashes($value)."');";
    exit;
}
    $data = mysql_fetch_array($result);
    $msetupfee = $data['msetupfee'];
    $qsetupfee = $data['qsetupfee'];
    $ssetupfee = $data['ssetupfee'];
    $asetupfee = $data['asetupfee'];
    $bsetupfee = $data['bsetupfee'];
    $tsetupfee = $data['tsetupfee'];
    $monthly = $data['monthly'];
    $quarterly = $data['quarterly'];
    $semiannually = $data['semiannually'];
    $annually = $data['annually'];
    $biennially = $data['biennially'];
    $triennially = $data['triennially'];

    $systemurl = App::getSystemUrl();

    if ($paytype=="free") {

        $output .= $_LANG['orderfree'];

    } elseif ($paytype=="onetime") {

        $output .= formatCurrency($monthly);
        if ($msetupfee!="0.00") $output .= " + ".formatCurrency($msetupfee)." ".$_LANG['ordersetupfee'];

    } elseif ($paytype=="recurring") {

        if (($billingcycle =="triennially") AND ($triennially>=0)) {
            $output .= formatCurrency($triennially/36); 
        }

        if (($billingcycle =="biennially") AND ($biennially>=0)) {
            $output .= formatCurrency($biennially/24);  
        }

        if (($billingcycle =="annually") AND ($annually>=0)) {
            $output .= formatCurrency($annually/12);    
        }

        if (($billingcycle =="semiannually") AND ($semiannually>=0)) {
            $output .= formatCurrency($semiannually/6);       
        }

        if (($billingcycle =="quartely") AND ($quarterly>=0)) {
            $output .= formatCurrency($quarterly/3); 
        }

        if ($monthly>=0) {
            $output .= formatCurrency($monthly);
        }


    }


    widgetoutput($output);

function widgetoutput($value) {
    echo "document.write('".addslashes($value)."');";
    exit;
}
