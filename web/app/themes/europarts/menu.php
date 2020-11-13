<?php
$mysqli = new mysqli("localhost", "europarts", "LBeyJDOVyHovKT2M", "europarts");

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
function menuList($mysqli, $parent, $level){
	$result = $mysqli->query("SELECT * FROM ep_term_taxonomy AS tt INNER JOIN ep_terms AS t ON tt.term_id = t.term_id WHERE taxonomy LIKE 'product_cat' AND parent = ".$parent);
	$output = '';
	if($result->num_rows){
		$output = '<ul>';
		foreach($result as $node){
			if($node['name'] != 'Uncategorized'){
				$newlevel = $level +1;
				$subOutput = menuList($mysqli, $node['term_id'], $newlevel); 
				$output .= '<li id="item-'.$node['term_id'].'" class="item level-'.$level.' '.($subOutput ? 'parent' : '' ).'">
					<a href="/'.$node['slug'].'">'.$node['name'].'</a>';
					$output .= $subOutput;
				$output .= '</li>';
			}
		}
		$output .= '</ul>';
	}
	return $output;
}
?>
<div class="nav">
<?php
echo menuList($mysqli, 0, 0); 
$mysqli->close();
?>
</div>
