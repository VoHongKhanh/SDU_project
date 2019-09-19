<div class="col-12 col-lg-6 col-xl-5 offset-xl-1 align-top">
  <form class="form-horizontal" method="post" action="?f=trial&s=db">
    <fieldset>
      
      <!-- Form Name -->
      <legend><h2>Server configuration</h2></legend>
      
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="txtServer">Server</label>
        <div class="col-md-12">
          <input id="txtServer" name="txtServer" type="text" 
          placeholder="Database server, for sample: localhost, 127.0.0.1, ..." class="form-control input-md" required="required" 
          value="localhost" />
        </div>
      </div>
      
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="txtUsername">Username</label>
        <div class="col-md-12">
          <input id="txtUsername" name="txtUsername" type="text" 
          placeholder="Username" class="form-control input-md" required="required" 
          value="root" />
        </div>
      </div>
      
      <!-- Password input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="txtPassword">Password</label>
        <div class="col-md-12">
          <input id="txtPassword" name="txtPassword" type="password" 
          placeholder="Password" class="form-control input-md" />
        </div>
      </div>
      
      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="btnConnect"></label>
        <div class="col-md-4">
          <button type="submit" id="btnConnect" name="btnConnect" class="btn btn-primary">Connect</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
<div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
  <div class="iphone-mockup"><img class="device" src="assets/img/crud.jpg"></div>
</div>
