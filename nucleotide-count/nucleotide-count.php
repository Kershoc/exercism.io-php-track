<?php
function nucleotideCount(string $dnaStrand): array
{
	$dnaStrand = strtolower($dnaStrand);
	$nucleotideCount = ['a'=>0, 'c'=>0, 't'=>0, 'g'=>0];
	$chars = str_split($dnaStrand);
	foreach ($chars as $char) {
		if (array_key_exists($char, $nucleotideCount)) {
			$nucleotideCount[$char]++;
		}
	}
	return $nucleotideCount;
}