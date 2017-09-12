<?php
# a PHP script to generate a markdown document of the smartAPI elements from the full specification document
# creator: Michel Dumontier

$file = "3.0.0.md";
$parent_doc = 'https://github.com/SmartAPI/smartAPI-Specification/blob/OpenAPI.next/versions/3.0.0.md';
$str = file_get_contents($file);

preg_match_all("/#### <a name=\"([^\"]+)\"><\/a>([^\n]+)/",$str, $header_labels);
foreach($header_labels[2] AS $id => $label) {$header_labels[2][$id] = trim($label);}
function getHeaderLink($label)
{
	global $header_labels;
	echo $label.PHP_EOL;
	$id = array_search($label, $header_labels[2]);
	return $header_labels[1][$id];
}
$list = preg_split("/#### <a name=\"[^\"]+\"><\/a>/",$str, -1);

array_shift($list);
array_shift($list);
array_shift($list);
array_shift($list);
array_shift($list);
foreach($list as $i => $item) {
  $a = explode("\n",$item, 2);
  $object_label = trim($a[0]);

  // now find the smartapi section
  $record = false;
  $buf = '';
  $a = explode("\n",$a[1]);
  foreach($a AS $b) {
	
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

				// field
				preg_match("/<a name=\"([^\"]+)\"><\/a>(.*)/",$cols[0],$m);
				$link = trim($m[1]);
				$field = trim($m[2]);
				
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
				$mylist[$object_label][$field]['link'] = $link;	
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
fwrite($fp,"smartAPI specific elements automatically generated from <a href=\"$parent_doc\">parent document</a>".PHP_EOL);
fwrite($fp,"Object | Field | Recommendation | Datatype | Description".PHP_EOL);
fwrite($fp,"---|:---:|:---:|:---:|---".PHP_EOL);
foreach($mylist AS $object => $o) {
	foreach($o as $field => $field_desc) {
		fwrite($fp,
		'<a href="'.$parent_doc.'#'.getHeaderLink($object).'">'.$object.'</a>'
		."|".'<a href="'.$parent_doc.'#'.$field_desc['link'].'">'.$field.'</a>'
		."|".$field_desc['rec']
		."|".$field_desc['datatype']
		."|".$field_desc['desc']
		.PHP_EOL);
	}
}
fclose($fp);

echo "$file generated".PHP_EOL;