<?php

$queryArr = [];
// if ($jsonSearch["query"] === "Kosong"){

// }else{
    
// }
array_push($queryArr, [

'multi_match' => [
    'query' => "QQQ",
    'fields' => "AAAA",
    'operator' => 'and'
]]


);

print_r($queryArr);

?>