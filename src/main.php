<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>V4V CRUD v1.0</title>
<link rel="stylesheet" href="<?=getResourse('assets/bootstrap/css/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?=getResourse('assets/fonts/font-awesome.min.css')?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
<link rel="stylesheet" href="<?=getResourse('assets/css/Header-Blue.css')?>">
<style type="text/css">
@import url("<?=getResourse('assets/css/style.css')?>");
</style>
</head>

<body>
<div>
  <div class="header-blue">
    <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
      <div class="container"><a class="navbar-brand" href="/">V4V CRUD v1.0</a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse"
                        id="navcol-1">
          <ul class="nav navbar-nav">
<!--             <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Free Trial</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Purchase</a></li>
 -->            <li class="nav-item" role="presentation">
            	<a class="nav-link active" href="#" data-toggle="modal" data-target="#frmAboutUs">About us</a>
            </li>
          </ul>
          <form class="form-inline mr-auto" target="_self">
            <div class="form-group">
              <input class="form-control search-field" type="search" id="search-field" name="search">
            </div>
          </form>
          <span class="navbar-text"> </span>
          <a class="btn btn-light action-button" role="button" href="#" id="sdu_btnSignUp">
          	<i class="fa fa-user-plus"></i>&nbsp;Sign Up</a>
          <a class="btn btn-light action-button" role="button" href="#" id="sdu_btnLogin">
          	<i class="fa fa-key"></i>&nbsp;Login</a>
        </div>
      </div>
    </nav>
    <div class="container hero">
      <div class="row">
<?php
		if ($func == "") {
        	include("default.php");
	    } else if ($func == "trial") {
	        if ($step == "sv") {
	          	include("ServerConfiguration.php");
	        } else if ($step == "db") {
          		include("DatabaseConfiguration.php");
	        } else if ($step == "tb") {
          		include("TableList.php");
	        }
	    }
?>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="frmAboutUs">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><strong>About us</strong></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <strong>Author:</strong> Võ Hồng Khanh<br/>
        <strong>Email:</strong> khanhvohong@gmail.com<br/>
        <strong>Job:</strong> Lecturer of FPT University Cần Thơ<br/>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<script src="<?=getResourse('assets/js/jquery.min.js')?>"></script> 
<script src="<?=getResourse('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>