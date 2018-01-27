<?php

class Selects {
	protected $_unitedStates = array('Alabama'=>'AL', 'Alaska'=>'AK', 'Arizona'=>'AZ', 'Arkansas'=>'AR', 'California'=>'CA', 'Colorado'=>'CO', 'Connecticut'=>'CT', 'Delaware'=>'DE', 'Florida'=>'FL', 'Georgia'=>'GA', 'Hawaii'=>'HI', 'Idaho'=>'ID', 'Illinois'=>'IL', 'Indiana'=>'IN', 'Iowa'=>'IA', 'Kansas'=>'KS', 'Kentucky'=>'KY', 'Louisiana'=>'LA', 'Maine'=>'ME', 'Maryland'=>'MD', 'Massachusetts'=>'MA', 'Michigan'=>'MI', 'Minnesota'=>'MN', 'Mississippi'=>'MS', 'Missouri'=>'MO', 'Montana'=>'MT', 'Nebraska'=>'NE', 'Nevada'=>'NV', 'NewHampshire'=>'NH', 'NewJersey'=>'NJ', 'NewMexico'=>'NM', 'NewYork'=>'NY', 'NorthCarolina'=>'NC', 'NorthDakota'=>'ND', 'Ohio'=>'OH', 'Oklahoma'=>'OK', 'Oregon'=>'OR', 'Pennsylvania'=>'PA', 'RhodeIsland'=>'RI', 'SouthCarolina'=>'SC', 'SouthDakota'=>'SD', 'Tennessee'=>'TN', 'Texas'=>'TX', 'Utah'=>'UT', 'Vermont'=>'VT', 'Virginia'=>'VA', 'Washington'=>'WA', 'WestVirginia'=>'WV', 'Wisconsin'=>'WI', 'Wyoming'=>'WY');
	
	protected $_countries = array('UnitedStates'=>'US');
	
	public function _CreateDivLists($area, $name, $addName, $clearName, $loadName, $addFromField, $addToField, $divField, $duplicateMessage) {
		if(isset($_SESSION['regions'])) $regions = $_SESSION['regions']; else $regions = '';
		echo '<fieldset class="form-group">';
			echo '<div class="row">';
				echo '<div class="col-lg-8 col-md-8">';
					echo '<select class="form-control" id="'.$addFromField.'">';
						if($area == 0) {
							foreach($this->_unitedStates as $key => $value) echo '<option value="'.$key.'">'.$key.'</option>';
						} else if($area == 1) {
							foreach($this->_countries as $key => $value) echo '<option value="'.$key.'">'.$key.'</option>';
						}
					echo '</select>';
				echo '</div>';
				echo '<div class="col-lg-4 col-md-4">';
					echo '<button type="button" class="btn btn-primary"  onclick="'.$addName.'()">Add</button>';
				echo '</div>';
			echo '</div>';
			echo '<input type="hidden" name="'.$name.'" id="'.$addToField.'" value="'.$regions.'"/>';
			echo '<div class="add-to-div" id="'.$divField.'"></div>';
		echo '</fieldset>';
		?>
		<script>
			jQuery(document).ready(function() {
				<?php echo $loadName; ?>();
			});
			function <?php echo $loadName; ?>() {
				var y = "<?php echo $regions; ?>";
				var node = document.getElementById("<?php echo $divField; ?>");
				function addTextNode(node, z) {
					var div = document.createElement("div");
					div.className = "added-div";
					div.setAttribute("id", z);
					var span = document.createElement('span');
					span.innerHTML = '<button class="remove-button" onclick="return <?php echo $clearName; ?>(' + z + ')">X</button>';
					var para = document.createElement("P");
					para.className = "added-text";
					var textnode = document.createTextNode(z);
					para.appendChild(textnode);
					div.appendChild(para);
					div.appendChild(span);
					return div;
				}
				if(y != '') {
					var yarr = y.split("_");
					var add;
					for(var i=0; i<yarr.length; i++) {
						console.log(yarr[i]);
						add = addTextNode(node, yarr[i]);
						node.appendChild(add);
					}
				}
			}
			// window.onload = <?php echo $loadName; ?>;
			function <?php echo $addName; ?>() {
				var x = document.getElementById("<?php echo $addFromField; ?>").value;
				var z, y = document.getElementById("<?php echo $addToField; ?>").value;
				var node = document.getElementById("<?php echo $divField; ?>");
				
				function addTextNode(node, z) {
					var div = document.createElement("div");
					div.className = "added-div";
					div.setAttribute("id", z);
					var span = document.createElement('span');
					span.innerHTML = '<button class="remove-button" onclick="return <?php echo $clearName; ?>(' + z + ')">X</button>';
					var para = document.createElement("P");
					para.className = "added-text";
					var textnode = document.createTextNode(z);
					para.appendChild(textnode);
					div.appendChild(para);
					div.appendChild(span);
					return div;
				}
				if(y == "") {
					z = x;
					document.getElementById("<?php echo $addToField; ?>").value = z;
					var add = addTextNode(node, z);
					node.appendChild(add);
				} else {
					var inArray = false;
					var yarr = y.split("_");
					for(var i=0; i<yarr.length; i++) { if(yarr[i] == x) inArray = true; }
					if(inArray) { alert("<?php echo $duplicateMessage; ?>");
					} else {
						w = y + "_" + x;
						document.getElementById("<?php echo $addToField; ?>").value = w;
						var add = addTextNode(node, x);
						node.appendChild(add);
					}
				}
			}
			function <?php echo $clearName; ?>(z) {
				var x, y = document.getElementById("<?php echo $addToField; ?>").value;
				var yarr = y.split("_");
				for(i=0; i<yarr.length; i++) {
					if(z.innerHTML.indexOf(yarr[i]) >= 0) { yarr.splice(i, 1); }
				}
				if(yarr.length == 0) x = "";
				if(yarr.length == 1) x = yarr[0];
				else x = yarr.join("_");
				document.getElementById("<?php echo $addToField; ?>").value = x;
				var node = document.getElementById("<?php echo $divField; ?>");
				node.removeChild(z);
				return false;
			}
		</script>
		<?php
	}
}

?>


<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>Multiple Select Using Bootstrap</title>
	<meta name="description" content="Select multiples">
	<meta name="author" content="Trigve Hagen">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<style>
	<?php
		echo '.add-to-div { clear:float;margin-top:15px;border:1px solid #ccc;border-radius:4px;width:100%;display:block;overflow:auto;padding-bottom:10px;min-height:40px; }';
		echo '.add-to-div-duals { clear:float;border:1px solid #ccc;border-radius:4px;width:100%;display:block;overflow:auto;padding-bottom:10px;min-height:40px; }';
		echo '.added-div { float:left;border:1px solid #ddd;border-radius:3px;padding:5px;margin:10px 0px 0px 10px; }';
		echo '.added-text { margin:0;float:left; }';
		echo '.remove-button { margin:0;padding:0px 5px;margin-left:5px;border:1px solid #ddd;border-radius:3px;float:left; }';
	?>
	</style>

</head>

<body>
	<div class="col-md-3">
	</div>
	<div class="col-md-6">
	<h4>Pick multiple, then post with form.</h4>
		<?php
			$obj = new Selects();
			echo '<fieldset class="form-group" style="margin-bottom:0;">';
				echo '<label for="states" style="margin:0;padding:0;">U.S. State</label>';
			echo '</fieldset>';
			$obj->_CreateDivLists(0, 'state', 'taxRateStateUpload', 'removeTaxRateState', 'loadTaxRateState', 'handling-rate-state-upload', 'handling-rate-state-upload-area', 'handling-rate-state-upload-div', 'That State has already been selected');
			
			echo '<fieldset class="form-group" style="margin-bottom:0;">';
				echo '<label for="states" style="margin:0;padding:0;">Countrys</label>';
			echo '</fieldset>';
			$obj->_CreateDivLists(1, 'country', 'taxRateCountryUpdate', 'removeTaxRateCountryUpdate', 'loadTaxRateCountryUpdate', 'handling-rate-country-update', 'handling-rate-country-update-area', 'handling-rate-country-update-div', 'That Country has already been selected');
		?>
	</div>
	<div class="col-md-3">
	</div>
	
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>