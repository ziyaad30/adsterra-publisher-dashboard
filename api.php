<?php
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$lastDayThisMonth = date("Y-m-d");
$url = 'https://api3.adsterratools.com/publisher/'.$_GET['id'].'/stats.json?group_by[]=date&start_date='.$_GET['start_day'].'&finish_date='.$_GET['end_day'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
if(curl_error($ch)) { 
echo 'error:' . curl_error($ch);
};
curl_close($ch);

$array = json_decode($json, true);
$result = $array['items'];
$data_points = array();

$totalCTR = '0';
$totalCPM = '0';
$totalClicks = '0';
$totalImpressions = '0';
$totalRevenue = '0';

foreach ($result as $arr) 
{
    
    $date = strtotime($arr['date']);
    $chart_date = date('Y, m, d, G, i, s', strtotime($arr['date']));
    $javaScriptTimestamp = $date * 1000;
    
    $totalCTR+= $arr['ctr'];
    $totalCPM+= $arr['cpm'];
    $totalClicks+= $arr['clicks'];
    $totalImpressions+= $arr['impression'];
    $totalRevenue+= $arr['revenue'];
    
    $data_points[] = 
                     array(
                     'date' => $arr['date'],
                     'month' => $javaScriptTimestamp,
                     'value' => $arr['revenue'],
                     'impressions' => $totalImpressions,
                     'daily_impressions' => $arr['impression'],
                     'ctr' => $totalCTR,
                     'cpm' => $totalCPM,
                     'revenue' => $totalRevenue,
                     'clicks' => $totalClicks
                );
    
}

echo json_encode($data_points, JSON_NUMERIC_CHECK);
?>