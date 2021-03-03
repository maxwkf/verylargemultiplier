<?php
$time_start = microtime(true); 
//////////////////

$number1 = '398075086424064937397125500550386491199064362342526708406385189575946388957261768583317';
$number2 = '472772146107435302536223071973048224632914695302097116459852171130520711256363590397527';

$product = $number1 * $number2;


$na1 = array_map('intval', str_split($number1));
$na2 = array_map('intval', str_split($number2));
var_dump([$na1,$na2]);
$resultArray = [];
foreach($na1 as $cnum1) {
	$currentResultArray = [];
	foreach($na2 as $cnum2) {
		$currentResultArray[] = $cnum1*$cnum2;
		
		
	}
	$resultArray[] = $currentResultArray;
}
var_dump($resultArray);



$processing1 = [];


foreach ($resultArray as $rowNum => $row) {
    foreach ($row as $colNum => $datum) {
        $processing1[$rowNum+$colNum][] = $datum;
    }
}

var_dump($processing1);


$processing2 = array_map(function($data){
    return array_sum($data);
}, $processing1);

var_dump($processing2);


$stepNextNum = 0;

$processing3 = [];
for($i = count($processing2)-1; $i>=0; $i--) {
    $element = $processing2[$i];

    $splitedNum = array_map('intval', str_split($element));
    
    $currentElementDetail = [];
    if (count($splitedNum) > 1) {
        $currentElementDetail['stepNext'] = intval(implode("",array_slice($splitedNum, 0, count($splitedNum)-1)));
        
        $currentElementDetail['currentNum'] = $splitedNum[count($splitedNum)-1];
    } else {
        $currentElementDetail['stepNext'] = 0;
        $currentElementDetail['currentNum'] = $splitedNum[0];
    }
    $processing3[] = $currentElementDetail;
    
    
}
var_dump($processing3);
$processing4 = [];

foreach ($processing3 as $p4Key => &$p3Detail) {
    
//     if (isset($$processing3[$p4Key-1]) && $processing3[$p4Key-1]['stepNext']) {

        $prevStepNext = $processing3[$p4Key-1]['stepNext'];
    
        $currentNum = $p3Detail['currentNum'] + $prevStepNext;
        
        
        $mod = $currentNum%10;
        if ($currentNum >= 10) {
            
            
            $p3Detail['stepNext'] += ($currentNum - $mod)/10;
            
            
        }
        
        
        
        $processing4[] = $mod;
    
}

if ($processing3[count($processing3)-1]['stepNext']>0) {
    $processing4[] = $processing3[count($processing3)-1]['stepNext'];
}

var_dump($processing4);

$result = implode("",array_reverse($processing4));

var_dump($result);

die;
//////////////////
$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes otherwise seconds
$execution_time_in_s = ($time_end - $time_start);

//execution time of the script
echo '<p><b>Total Execution Time:</b> '.$execution_time_in_s.' Secs == ' . ($execution_time_in_s/60). ' Mins</p>';

echo '<div>';
echo "<p style='text-align:right;'>{$number1}</p>";
echo "<p style='text-align:right;'>{$number2}</p>";
echo "<p style='text-align:right; border-top: 1px solid DimGray'>{$product}</p>";
echo '</div>';
