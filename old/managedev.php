<?php
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
        var id,name,url;
        function savedata(devid,devname,devurl){
            id=devid;
            name=devname;
            url=devurl;
            $("#devname").val(name);
            $("#devurl").val(url);
            $("#devid").val(id);
            $("#delid").val(id);
        }
		$(document).ready(function() {
			// Activate tooltip
			$('[data-toggle="tooltip"]').tooltip();

			// Select/Deselect checkboxes
			var checkbox = $('.custom-checkbox input[type="checkbox"]');
			$("#selectAll").click(function() {
				checkbox = $('.custom-checkbox input[type="checkbox"]');
				if (this.checked) {
					checkbox.each(function() {
						$(this).prop('checked', true).change();
					});
				} else {
					checkbox.each(function() {
						$(this).prop('checked', false).change();
					});
				}
			});
			checkbox.click(function() {
				if (!this.checked) {
					$("#selectAll").prop("checked", false);
				}
			});
			table = $('#deveicelist').DataTable();
		});
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
							<h2>Manage <b>Devices</b></h2>
						</div>
						<div class="col-sm-6" id="timer">

						</div>
					</div>
				</div>
				<table class="table" id='deveicelist'>
					<thead>
						<tr>
							<th>
								<span class="custom-checkbox" style="display:none;">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
							<th>Device Name</th>
							<th>URL</th>
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
										<span class="custom-checkbox" style="display:none;">
											<input type="checkbox" id="<?php echo 'checkbox_' . $row["id"]; ?>" name="options[]" value="1">
											<label for="<?php echo 'checkbox_' . $row["id"]; ?>"></label>
										</span>
									</td>
									<td><?php echo $row["name"] ?></td>
									<td><?php echo $row["url"] ?></td>
									<td>
										<div class="custom-control custom-switch">
                                        <a href="#editModal" onclick="savedata('<?php echo $row['id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['url']; ?>'); " data-toggle="modal"><i class="material-icons">create</i></a> 
                                        <a href="#removeModal" onclick="savedata('<?php echo $row['id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['url']; ?>'); " data-toggle="modal" style="color: red;"><i class="material-icons">clear</i></a>
											
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
					
				</table>

			</div>
			<div class="table-wrapper">
				<div class="table-title">

					<div class="row">
						<div class="col-sm-1">

						</div>
						<div class="col-sm-6">
                        <a onclick="window.location.href='./index.php'" class="btn btn-danger" data-toggle="modal"><i class="material-icons">close</i> <span>Exit</span></a>
							<a href="#addDeviceModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Devices</span></a>
						    
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
    <div id="editModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="editdeviceform" onsubmit="editdevice(); return false;">
					<div class="modal-header">
						<h4 class="modal-title">Edit Device</h4>
						<button type="button" onclick="window.location.href='./managedev.php'" class="close" onclick="location = location.href;" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
                    <input type="hidden" value='' class="form-control" id="delid" name="id">
						<div class="form-group">
							<label>Name</label>
							<input type="text" value='' class="form-control" id="devname" name="name" required>
						</div> 
						<div class="form-group">
							<label>URL</label>
							<input type="text" name="url" id="devurl" class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-success" value="Update">
						</div>
					</div>

				</form>
			</div>
		</div>
    </div>
    <div id="removeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="removedeviceform" onsubmit="removedevice(); return false;">
					<div class="modal-header">
						<h4 class="modal-title">Remove Device</h4>
						<button type="button" onclick="window.location.href='./managedev.php'" class="close" onclick="location = location.href;" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
                    <input type="hidden" value='' class="form-control" id="devid" name="id">
						<div class="form-group">
							<label>Do you really want to remove this device?</label>
						</div> 
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-danger" value="Remove">
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
							<label>Enter Time in Hours:Minutes</label>
							<input type="time" id='addalltimevalue' class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="addtimerall($('#addalltimevalue').val());" class="btn btn-success" value="Add">
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
							<label>Enter Time in Hours:Minutes</label>
							<input type="time" id='removealltimevalue' class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="removetimerall($('#removealltimevalue').val());" class="btn btn-success" value="Remove">
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
							<label>Enter Time in Hours:Minutes</label>
							<input type="time" id='removetimevalue' class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="button" onclick="removetimer($('#removetimevalue').val());" class="btn btn-success" value="Remove">
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
    function editdevice() {
		var data = $("#editdeviceform").serialize();
		$.ajax({
			url: "editdevice.php",
			data: data,
			type: "post",
			success: function(result) {
				$("#editModal .modal-body").html(result);

			}
		});
	}
    function removedevice() {
		var data = $("#removedeviceform").serialize();
		$.ajax({
			url: "deletedevice.php",
			data: data,
			type: "post",
			success: function(result) {
				$("#removeModal .modal-body").html(result);

			}
		});
	}


</script>

</html>