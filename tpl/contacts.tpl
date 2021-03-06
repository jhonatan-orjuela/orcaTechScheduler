<html>
<head>
	<title> Scheduler </title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/header.css" />
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/body.css" />
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/footer.css" />

	<script type="text/javascript" src="../bootstrap/js/jquery-2.0.3.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>

	<script src="https://apis.google.com/js/client:platform.js" async defer>
	</script>

</head>
<body>

{include file='header-logged.tpl'}

<div id="content-contacts" class="container-fluid">
	<div class="row">
		<div id="contacts" class="col-md-12">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<table class="table table-hover table-striped">
						<tr class="info">
							<td><input id="selectAll" name="selectAll" type="checkbox"></td>
							<td>Name</td>
							<td>Email</td>
						</tr>
						
						<!-- SOME SMARTY LOOP HERE TO GENERATE TABLES -->
						<tr>
							<td>
		      					<input class="contactCheck" name="contacts[]" type="checkbox">
	    					</td>
							<td>Name</td>
							<td>Email</td>
						</tr>
						<!-- END OF SOME SMARTY LOOP HERE TO GENERATE TABLES -->
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$("#selectAll").change(function() {
    if(this.checked) {	
        $(".contactCheck").each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"  
            $(this).closest("tr").addClass("success");     
        });
    }else{
        $(".contactCheck").each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"  
        	$(this).closest("tr").removeClass("success");                     
        });
    }
});

$('input[name^=contacts]').change(function() {
	if(this.checked) {
		$(this).closest("tr").addClass("success");
	}
	else {
		$(this).closest("tr").removeClass("success");
		if($("#selectAll").attr("checked", true)) {
			$("#selectAll").attr("checked", false);
		}
	}
});
</script>

<div id="hideThis" style="display: none">
	<span id="signinButton" >
	  <span
	    class="g-signin"
	    data-callback="signinCallback"
	    data-clientid="377351928922-c771ed20ns780hbmv6cjebtrv9p7uqu6.apps.googleusercontent.com"
	    data-cookiepolicy="single_host_origin"
	    data-requestvisibleactions="http://schema.org/AddAction"
	    data-scope="https://www.googleapis.com/auth/plus.login">
	  </span>
	</span>
</div>
<script type="text/javascript">
function signinCallback(authResult) {
  if (authResult['status']['signed_in']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
  } else {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    console.log('Sign-in state: ' + authResult['error']);
  }
}
</script>

</body>
</html>