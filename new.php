<?php
for ($i=0;$i<20;$i++){
	$aa[$i]=$i;
}

echo array_search(2, $aa);
echo array_search(4, $aa);   // $key = 1;

?>