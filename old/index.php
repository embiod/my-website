<?php
// exit();
include("connect.php");
//echo "Connected successfully";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Timer Application</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="mystyle.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<script src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

	<script>
		var rowselected;
		var modeldata, modeldataremove, modeldataall, modelremoveall;
		var table;
		var timerstatus = [];
		
	</script>
</head>

<body>
	<div class="container-xl">
		<div class="table-responsive">

			<div class="table-wrapper">
				<div class="table-title" style="text-align: center;font-size: 41px;background: whitesmoke;color: #435d7d;">
					Title of project
				</div>
				<div class="table-title">

					<div class="row">
						<div class="col-sm-6">
							<h2>Device <b>Controller</b></h2>
						</div>
						<div class="col-sm-6" id="timer">

						</div>
					</div>
				</div>
				<table class="table" id='deveicelist'>
					<thead>
						<tr>
							<th>
								<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
							<th>Device Name</th>
							<th>Time Left</th>
							<th>Add Time</th>
							<th>Remove Time</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$sql = "SELECT * FROM device";
						$result = $conn->query($sql);
						$count = 0;
						if ($result->num_rows > 0) {
							// output data of each row
							while ($row = $result->fetch_assoc()) {
								//echo "id: " . $row["id"] . " - Name: " . $row["name"] . " " . $row["ip"] . "<br>";
						?>
								<tr>
									<td>
										<span class="custom-checkbox">
											<input type="checkbox" id="<?php echo 'checkbox_' . $row["id"]; ?>" name="options[]" value="1">
											<label for="<?php echo 'checkbox_' . $row["id"]; ?>"></label>
										</span>
									</td>
									<td><?php echo $row["name"] ?></td>
									<td>0:0:0</td>
									<td><a href="#addTimeModal" onclick="rowselected=<?php echo $count; ?>; " data-toggle="modal"><i class="material-icons">&#xE147;</i></a></td>
									<td><a href="#removeTimeModal" onclick="rowselected=<?php echo $count; ?>;" data-toggle="modal" style="color: red;"><i class="material-icons">&#xE15C;</i></a></td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" value='<?php echo $row["url"] ?>' onclick="rowselected=<?php echo $count; ?>;" id="<?php echo 'button_' . $count; ?>">
											<label class="custom-control-label" for="<?php echo 'button_' . $count; ?>"></label>
										</div>
									</td>
								</tr>
						<?php
								$count++;
							}
						} else {
							echo "0 results";
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><a href="#addallTimeModal" data-toggle="modal"><i style="float: left;" class="material-icons">&#xE147;</i> Add to all</a></td>
							<td><a href="#removeallTimeModal" data-toggle="modal" style="color: red;"><i class="material-icons" style="float: left;">&#xE15C;</i> Remove from all</a></td>

						</tr>
					</tfoot>
				</table>

			</div>
			<div class="table-wrapper">
				<div class="table-title">

					<div class="row">
						<div class="col-sm-1">

						</div>
						<div class="col-sm-6">
							<a onclick="window.location.href='./managedev.php'" class="btn btn-success" data-toggle="modal"><span>Manage Devices</span></a>
							<!--<a href="#addDeviceModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Device</span></a>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="addDeviceModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="adddeviceform" onsubmit="adddevice(); return false;">
					<div class="modal-header">
						<h4 class="modal-title">Add New Device</h4>
						<button type="button" class="close" onclick="location = location.href;" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" required>
						</div>
						<div class="form-group">
							<label>URL</label>
							<input type="text" name="url" class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-success" value="Add">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div id="addTimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Add Time</h4>
						<button type="button" class="close" onclick="$('#addTimeModal .modal-body').html(modeldata);" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Enter Time</label>
							<!--<input type="time" id='addtimevalue' class="form-control" required>-->
							<div>
								<div class="row">
									<div class="col-md-6"><input type="number" value=0 min=0 id='addtimehours' class="form-control" required><small>Hours</small></div>
									<div class="col-md-6"><input type="number" value=0 min=0 id='addtimeminutes' class="form-control" required><small>Minutes</small></div>
								</div>
								<br>
							</div>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="javascript:addtimer($('#addtimehours').val()+':'+$('#addtimeminutes').val());" class="btn btn-success" value="Add">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div id="addallTimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Add Time to all</h4>
						<button type="button" class="close" onclick="$('#addallTimeModal .modal-body').html(modeldataall);" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Enter Time</label>
							<!--<input type="time" id='addtimevalue' class="form-control" required>-->
							<div>
								<div class="row">
									<div class="col-md-6"><input type="number"  value=0 min=0 id='addalltimehours' class="form-control" required><small>Hours</small></div>
									<div class="col-md-6"><input type="number"  value=0 min=0 id='addalltimeminutes' class="form-control" required><small>Minutes</small></div>
								</div>
								<br>
							</div>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="addtimerall($('#addalltimehours').val()+':'+$('#addalltimeminutes').val());" class="btn btn-success" value="Add">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div id="removeallTimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Remove Time from all</h4>
						<button type="button" class="close" onclick="$('#removeallTimeModal .modal-body').html(modelremoveall);" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Enter Time</label>
							<!--<input type="time" id='addtimevalue' class="form-control" required>-->
							<div>
								<div class="row">
									<div class="col-md-6"><input type="number"  value=0 min=0 id='removealltimehours' class="form-control" required><small>Hours</small></div>
									<div class="col-md-6"><input type="number"  value=0 min=0 id='removealltimeminutes' class="form-control" required><small>Minutes</small></div>
								</div>
								<br>
							</div>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="removetimerall($('#removealltimehours').val()+':'+$('#removealltimeminutes').val());" class="btn btn-success" value="Remove">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div id="removeTimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Remove Time</h4>
						<button type="button" class="close" onclick="$('#removeTimeModal .modal-body').html(modeldataremove);" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Enter Time</label>
							<!--<input type="time" id='addtimevalue' class="form-control" required>-->
							<div>
								<div class="row">
									<div class="col-md-6"><input type="number"  value=0 min=0 id='removetimehours' class="form-control" required><small>Hours</small></div>
									<div class="col-md-6"><input type="number"  value=0 min=0 id='removetimeminutes' class="form-control" required><small>Minutes</small></div>
								</div>
								<br>
							</div>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="removetimer($('#removetimehours').val()+':'+$('#removetimeminutes').val());" class="btn btn-success" value="Remove">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="edittimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Edit Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deletetimeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="notification" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Notification</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p></p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
<script>
	function adddevice() {
		var data = $("#adddeviceform").serialize();
		$.ajax({
			url: "adddevice.php",
			data: data,
			type: "post",
			success: function(result) {
				$("#addDeviceModal .modal-body").html(result);

			}
		});
	}
	
	$(document).ready(function() {
			// Activate tooltip
			$('[data-toggle="tooltip"]').tooltip();

			// Select/Deselect checkboxes
			table = $('#deveicelist').DataTable();
			$("#selectAll").click(function() {
				if (this.checked) {
					table.column(0).nodes().each(function(node, index, dt) {
						$(node).find('input[type="checkbox"').prop("checked", true);
					});
				} else {
					table.column(0).nodes().each(function(node, index, dt) {
						$(node).find('input[type="checkbox"').prop("checked", false);
					});
				}
			});
			table = $('#deveicelist').DataTable();
		});
		
		function addtimer(val) {
// 		debugger;
		// alert(rowselected);
		// alert(val);
		//debugger;
		if (val == "") {
			return;
		}
		$("#addTimeModal .modal-body").html(modeldata);
		//var table = $('#deveicelist').DataTable();


		val = val.split(':');
		var oldval = table.row(rowselected).data()[2];
		var olddata = oldval.split(':');
		var oldhr = parseInt(olddata[0]);
		var oldmn = parseInt(olddata[1]);
		var oldsc = parseInt(olddata[2]);


		var oldtime = oldhr * 60 + oldmn;
		var newtime = parseInt(val[0]) * 60 + parseInt(val[1]) + oldtime;

		var newhr = parseInt(newtime / 60);
		var newmn = parseInt(newtime % 60);

		var temp = table.row(rowselected).data();
		temp[2] = newhr + ':' + newmn + ":00";


		table.row(rowselected).data(temp);
		$("#button_" + rowselected).prop("checked", true).change();

		setdevicetimer($("#button_" + rowselected).prop("value"), (newtime * 60) + 100);

		modeldata = $("#addTimeModal .modal-body").html();

		// $("#button_"+rowselected).click();

		$("#addTimeModal .modal-body").html("Added Successfully.");
		timerstatus[rowselected] = 1;
	}

	function addtimerall(timeval) {
		// alert(rowselected);
		// alert(val);
		if (timeval == "") {
			return;
		}
		$("#addallTimeModal .modal-body").html(modeldataall);
		// var table = $('#deveicelist').DataTable();

		table.column(2).nodes().each(function(node, index, dt) {
			//table.cell(node).data('40');
			// console.log($(node.previousElementSibling.previousElementSibling).find('input[type="checkbox"').prop("value"));
			if ($(node.previousElementSibling.previousElementSibling).find('input[type="checkbox"').is(":checked")) {
				timerstatus[index] = 1;
				time = table.cell(node).data();

				timedata = time.split(':');

				hours = parseInt(timedata[0]);
				minutes = parseInt(timedata[1]);
				seconds = parseInt(timedata[2]);


				var val = timeval.split(':');

				var oldtime = hours * 60 + minutes;
				var newtime = parseInt(val[0]) * 60 + parseInt(val[1]) + oldtime;
				if (newtime > 0) {
					// console.log($(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('value'));
					//call settimer method..
					sendonoffcommand($(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('value'), '1');
					setdevicetimer($(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('value'), (newtime * 60) + 100);
					var newhr = parseInt(newtime / 60);
					var newmn = parseInt(newtime % 60);
					// $("#button_" + index).prop("checked", true);
					$(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('checked', true);
					// console.log($("#button_" + 10).prop("value"));
					table.cell(node).data(newhr + ':' + newmn + ":00");
				}
			}

		});
		table.column(5).nodes().to$().each(function(index) {
			$(this).find('.custom-control-input').prop('checked', 'checked');
		});
		table.draw();

		modeldataall = $("#addallTimeModal .modal-body").html();
		$("#addallTimeModal .modal-body").html("Added Successfully.");
	}

	function removetimerall(timeval) {
		// alert(rowselected);
		// alert(val);
		if (timeval == "") {
			return;
		}
		$("#removeallTimeModal .modal-body").html(modelremoveall);
		// var table = $('#deveicelist').DataTable();

		table.column(2).nodes().each(function(node, index, dt) {
			if ($(node.previousElementSibling.previousElementSibling).find('input[type="checkbox"').is(":checked")) {
				//table.cell(node).data('40');
				time = table.cell(node).data();

				timedata = time.split(':');

				hours = parseInt(timedata[0]);
				minutes = parseInt(timedata[1]);
				seconds = parseInt(timedata[2]);


				var val = timeval.split(':');

				var oldtime = hours * 60 + minutes;
				var newtime = oldtime - (parseInt(val[0]) * 60 + parseInt(val[1]));
				if (newtime > 0) {
					var newhr = parseInt(newtime / 60);
					var newmn = parseInt(newtime % 60);
					table.cell(node).data(newhr + ':' + newmn + ":00");
					setdevicetimer($(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('value'), (newtime * 60) + 100);
					
				}
			}
		});

		modelremoveall = $("#removeallTimeModal .modal-body").html();
		$("#removeallTimeModal .modal-body").html("Removed Successfully.");
	}

	function removetimer(val) {
		// alert(rowselected);
		// alert(val);
// 		debugger;
		if (val == "") {
			return;
		}
		$("#removeTimeModal .modal-body").html(modeldataremove);
		// var table = $('#deveicelist').DataTable();


		val = val.split(':');
		var oldval = table.row(rowselected).data()[2];
		var olddata = oldval.split(':');
		var oldhr = parseInt(olddata[0]);
		var oldmn = parseInt(olddata[1]);
		var oldsc = parseInt(olddata[2]);


		var oldtime = oldhr * 60 + oldmn;
		var newtime = oldtime - (parseInt(val[0]) * 60 + parseInt(val[1]));
		if (newtime > 0) {
			var newhr = parseInt(newtime / 60);
			var newmn = parseInt(newtime % 60);

			var temp = table.row(rowselected).data();
			temp[2] = newhr + ':' + newmn + ":00";

			table.row(rowselected).data(temp).invalidate();
			$("#button_" + rowselected).prop('checked', true).change();
			setdevicetimer($("#button_" + rowselected).prop('value'), (newtime * 60) + 100);
			modeldataremove = $("#removeTimeModal .modal-body").html();
			$("#removeTimeModal .modal-body").html("Removed Successfully.");
		}
	}

	function sendonoffcommand(url, stat) {
		// console.log(url + "Power%20" + stat);
		$.ajax({
			url: url + "Power%20" + stat,
			type: "get",
			success: function(result) {
				// console.log("Action completed successfully..");
			}
		});
	}
	$(document).ready(function() {
		var interval;
		var time;
		var minutes;
		var hours;
		var seconds;
		var timedata;




		//rowselected.parentElement.previousElementSibling.innerText="2:2:30"

		function initevent() {
			$("body").on("change", ".custom-control-input", function() {
				timerstatus[rowselected] = 0;
				if (this.checked) {
					console.log('ON');
					sendonoffcommand($(this).val(), '1');

				} else {
					console.log('OFF');
					sendonoffcommand($(this).val(), '0');
					var temp = table.row(rowselected).data();
					temp[2] = "0:0:0";
					table.row(rowselected).data(temp);

				}
			});
		}
		initevent();

		var table = $('#deveicelist').DataTable();

		table.column(5).nodes().each(function(node, index, dt) {
			timerstatus[index] = 0;
			//table.cell(node).data('40');
			// console.log(node);
			//get remaining time for each device
			//getremainingtime('http://cntrlroom1.ddns.net:8011/cm?cmnd=PulseTime1');
			var newtime = 0;
			//console.log($("#button_" + index).val());
// 			debugger;
			$.ajax({
				url: $(node).find('.custom-control-input').prop('value') + "PulseTime1",
				type: "get",
				async: true,
				success: function(result) {
					if (result.PulseTime1.Remaining != undefined) {
						// console.log(result.PulseTime1.Remaining);
						newtime = (result.PulseTime1.Remaining - 100);
						var newhr = 0;
						var newmn = 0;
						var newsec = 0;
						// console.log(newtime);
						if (newtime > 0) {
							newhr = Math.floor(newtime / 3600);
							newtime %= 3600;
							newmn = Math.floor(newtime / 60);
							newsec = newtime % 60;

							// hours = Math.floor(totalSeconds / 3600);
							// totalSeconds %= 3600;
							// minutes = Math.floor(totalSeconds / 60);
							// seconds = totalSeconds % 60;

							$(node).find('.custom-control-input').prop('checked', true);
							timerstatus[index] = 1;
						} else {
							$(node).find('.custom-control-input').prop('checked', false);
						}
						table.cell(node.previousElementSibling.previousElementSibling.previousElementSibling).data(newhr + ':' + newmn + ':' + newsec);
						// $(this).find('.custom-control-input').prop('checked', 'checked');
					}
				}
			});
			//$(this).find('.custom-control-input').prop('checked', 'checked');
			// console.log($(node).find('.custom-control-input').prop('value'));
		});

		//Timer code.
		interval = setInterval(function() {
			// var table = $('#deveicelist').DataTable();
			table.column(2).nodes().each(function(node, index, dt) {
				//table.cell(node).data('40');
				time = table.cell(node).data();

				timedata = time.split(':');

				hours = parseInt(timedata[0]);
				minutes = parseInt(timedata[1]);
				seconds = parseInt(timedata[2]);

				// debugger;
				if (seconds <= 0) {
					if (minutes <= 0) {
						if (hours <= 0) {
							// console.log(timerstatus[index]);
							if (timerstatus[index] == 1) {
								// timerstatus[index] = 0;
								$(node.nextElementSibling.nextElementSibling.nextElementSibling).find('.custom-control-input').prop('checked', false);
								timerstatus[index] == 0;
							}
							// if ($("#button_" + index).prop('checked') == true) {
							// 	$("#button_" + index).prop('checked', false).change();
							// }
							return false;
						} else {
							hours--;
							minutes = 60;
							seconds = 60;
						}
					} else {
						minutes--;
						seconds = 60;
					}
				}

				seconds--;
				table.cell(node).data(hours + ':' + minutes + ':' + seconds);
			});
		}, 1000);
	});

	function setdevicetimer(url, cmd) {
		// console.log(url + "Pulsetime " + cmd);
		$.ajax({
			url: url + "pulsetime " + cmd,
			type: "get",
			success: function(result) {
				//console.log(result);
			}
		});
	}
</script>

</html>