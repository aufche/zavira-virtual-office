<?php
function internasional($number){
	$ptn = "/^0/";  // Regex
	return preg_replace($ptn, '+62', $number);
}

function tipe($id){
	$jenis = [1=>'Kos-Kosan','Ruko','Kios','Rumah Tinggal','Tanah Kosong'];
	return $jenis[$id];
}