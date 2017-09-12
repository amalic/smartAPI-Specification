<?php

$file = "3.0.0.md";
$str = file_get_contents($file);

$list = preg_split("/#### <a name=\"[^\"]+\"><\/a>/",$str, -1); // <a name="[^\"]+"></a>OpenAPI Object
array_shift($list);
array_shift($list);
array_shift($list);
array_shift($list);
array_shift($list);
foreach($list as $item) {
  $a = explode("\n",$item, 2);
  $object_label = trim($a[0]);

//echo $object_label.PHP_EOL;
  
  // now find the smartapi section
  $record = false;
  $buf = '';
  $a = explode("\n",$a[1]);
  foreach($a AS $b) {
	// echo "line: $b".PHP_EOL;
	
	if($record === true) {
		//if(strlen(trim($b)) == 0) $record = false;
		if(strstr($b,"####")) $record = false;
		else {
			$buf .= $b.PHP_EOL;

			if(strstr($b,"<a name=")) {
				$cols = explode("|",$b);
				
				$datatype = str_replace('`','',$cols[1]);
				if(strstr($datatype,"[[")) {
					preg_match("/\[\[([^\]]+)\]/",$datatype,$m);
					if(isset($m[1])) $datatype = $m[1];
				}
				$desc = $cols[2];		
				preg_match("/a>(.*)/",$cols[0],$m);
				$field = trim($m[1]);
				
				// recommendation
				preg_match('/\*\*([^\*]+)/',$desc,$m); //([^*]+)**/',$desc,$m);
				$rec = '';
				if(isset($m[1])) {
					$rec = $m[1];
					$desc = substr($desc, strlen($rec)+5);
				}
				$desc = str_replace("https://github.com/WebsmartAPI/OpenAPI-Specification/blob/OpenAPI.next/versions/3.0.md#","https://github.com/SmartAPI/smartAPI-Specification/blob/OpenAPI.next/versions/3.0.0.md", $desc);
				
				$mylist[$object_label][$field]['rec'] = $rec;		
				$mylist[$object_label][$field]['desc'] = trim($desc);		
				$mylist[$object_label][$field]['datatype'] = $datatype;	
			}
		}
	}
	if(strstr($b,"##### smartAPI") !== FALSE) {
		$record = true;
	}
  }

}


// markdown
$file = "smartapi-list.md";
$fp = fopen($file,"w");
fwrite($fp,"Object | Field | Recommendation | Datatype | Description".PHP_EOL);
fwrite($fp,"---|:---:|:---:|:---:|---".PHP_EOL);
foreach($mylist AS $object => $o) {
	foreach($o as $field => $field_desc) {
		fwrite($fp,$object
		."|".$field
		."|".$field_desc['rec']
		."|".$field_desc['datatype']
		."|".$field_desc['desc']
		.PHP_EOL);
	}
}
fclose($fp);

echo "$file generated".PHP_EOL;