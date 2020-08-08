<?php
declare(strict_types=1);

 function steps(int $i)
 {
    if ($i < 1) {
		throw new InvalidArgumentException("Only positive numbers are allowed");
    }
    
	$count = 0;
	while ($i !== 1) {
		if ($i%2 === 0) {
			$i /= 2;
		} else {
			$i = 3*$i + 1;
		}
		$count++;
    }
    
    return $count;
 }
