<?php
 function canAttack(array $p1, array $p2){
    list( $p1x, $p1y ) = $p1;
    list( $p2x, $p2y ) = $p2;
    if (inSame($p1x, $p2x) || inSame($p1y, $p2y) || inDiagonal($p1x, $p1y, $p2x, $p2y)) {
        return true;
    }
    return false; 
 }

 function inSame(int $x, int $y) {
    return $x == $y;
 }

 function inDiagonal(int $x1, int $y1, int $x2, int $y2) {
    return abs($x1-$x2) == abs($y1-$y2);
 }

 function placeQueen(int $x, int $y){
    if ($x<0 || $y <0) {
        throw new InvalidArgumentException("The rank and file numbers must be positive.");
    }
    if ($x>7 || $y >7) {
        throw new InvalidArgumentException("The position must be on a standard size chess board.");
    }
    return true;
}
