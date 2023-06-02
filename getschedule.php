<?php
	if (isset($_GET["aFName"])&& isset($_GET["pFName"])){
		extract($_GET);
		session_start();
	$_SESSION["aFName"] = $_GET["aFName"];
		require_once("connect.php");
		?>
	
<!DOCTYPE html>
<html lang="en" >
<head>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/github.min.css">
<style type="text/css"></style>

</head>
<body>
  <style>
  @media (min-width: 576px) {
      .jumbotron {
        padding: 1rem 2rem;
      }
    }

    .tdaction {
      width: 15%;
    }

    .tdSr {
      width: 7%;
    }

    strong {
    font-size: 24px !important;
}

    input.largerCheckbox {
      width: 20px;
      height: 20px;
    }
  .time-cell {
      
  cursor: pointer;
  text-align: center;
  font-weight: bold;
  color: blue;
}
  *{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
}
body{
    font-family: Helvetica;
    -webkit-font-smoothing: antialiased;
    background: rgba( 71, 147, 227, 1);
}
h2{
    text-align: center;
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: white;
    padding: 30px 0;
}

/* Table Styles */

.table-wrapper{
    margin: 10px 70px 70px;
    box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
}

.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    background-color: white;
}

.fl-table td, .fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width:767) {
    .fl-table {
        display: block;
        width: 40px;
    }
    .table-wrapper:before{
        content: "Scroll horizontally >";
        display: block;
        text-align: right;
        font-size: 11px;
        color: white;
        padding: 0 0 10px;
    }
    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        height: 60px;
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        width: 120px;
        font-size: 13px;
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tbody td {
        display: block;
        text-align: center;
    }
}</style>
 <form method="POST" action="test.php">
<?php	$query = "SELECT s.pFName, s.pillID,s.pill1 ,s.pill2, s.pill3 ,s.pill4
FROM schedule s
JOIN patient p ON s.pFName = p.pFName
JOIN junction j ON p.pID = j.pID
JOIN admin a ON j.adminID = a.adminID
WHERE a.aFName = '{$aFName}';";
  
		$result = mysqli_query($con, $query);
//	print_r(mysqli_fetch_assoc($result));
		if (!$result) {
			die(mysqli_error($con));
		}

		if (mysqli_num_rows($result) !=0) {
			$row = mysqli_fetch_assoc($result);?>
			  <div class="table-wrapper">
    <table id = "empTable" class="fl-table" >
          <thead>
      <tr>
        <th>patient name</th>
        <th>first pill time</th>
        <th>second pill time</th>
        <th>Header 4</th>
        <th>Header 5</th>
      </tr>
    </thead>
    <tbody>
		      
 <?php  while($row =mysqli_fetch_assoc($result))
{ ?>
      <tr >

  <td class="pFName" name="pFName"><?= $row['pFName'];?></td>
  <td class="time-cell clickable pill4" name="pill4[]"><?= $row['pill1'];?></td>
  <td class="time-cell clickable pill4" name="pill4[]"><?= $row['pill2'];?></td>
  <td class="time-cell clickable pill4" name="pill4[]"><?= $row['pill3'];?></td>
  <td class="time-cell clickable pill4" name="pill4[]"><?= $row['pill4'];?></td>
</tr>

</div>
</div>
   <?php }
    mysqli_close($con);
		}
	}
?>
</tbody>
</table>
<p><input type="submit" name="submit" value="Save changes" ></p>
  </form>
</form>
	</div>


			<div class="input-group clockpicker-with-callbacks">
				<input type="text" class="form-control" value="10:10">
			</div>
 <table>
     <th>head</th>
     <tr>
         <td>
            	<div class="input-group clockpicker-with-callbacks">
				<input type="text" class="form-control" value="10:10">
			</div> 
         </td>
          <td>
            	<div class="input-group clockpicker-with-callbacks">
				<input type="text" class="form-control" value="10:10">
			</div> 
         </td>
     </tr>
 </table>
    </span>
  </div>
</td>

	

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="dist/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}

</script>
<script type="text/javascript" src="assets/js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>



<style>
.highlight {
  background-color: yellow;
}
</style>
<script>
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('clickable')) {
    event.target.classList.toggle('highlight');
  }
});
</script>

</td>
<script>
$(function() {
  $('.clickable').click(function() {
    var td = $(this);
    td.find('.clockpicker').show()
      .clockpicker({
        afterDone: function(time) {
          td.text(time);
          td.find('.clockpicker').hide();
          td.addClass('highlight');
        }
      });
  });
});
</script>



</body>
 </html>