<?php $this->load->view('site/templates/header'); ?>

<section class="container">

    <div class="row">
		<form method="post" action="site/user/changePasssword">
        <div class="col-md-4 col-md-offset-4">
        <h3>Reset Password</h3><br />
              <div class="form-group">
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
                    <label>New Password</label>
                    <input type="password" class="form-control" style="margin:0" name="newPassword" id="newPassword"/>
                    <div style="color:red;" id="passErr"></div>

              </div>
						
			 <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" class="form-control" style="margin:0" name="confPassword" id="confPassword"/>
                  <div style="color:red;" id="confpassErr"> </div>
             </div>								
		     <div class="form-group" style="margin-bottom:15px">
                   <input type="submit" class="btn btn-block btn-primary" onclick="return validatePwd();" value="Reset Password" />
                   <span id="loadErr"></span>
             </div>
       </div>
	   </form>
   </div>     

</section>

<?php 

$this->load->view('site/templates/footer');

?>

<script>
function validatePwd(){
	
	$('#passErr').html( '' );
	$('#confpassErr').html( '' );

	if( $('input[name=newPassword]').val().trim().length  < 6 ) {
		$('#passErr').html( 'Password Length Should be greater than 6 Character' );
		return false;
	} 
	
	if( $('input[name=newPassword]').val().trim() == "" ) {
		$('#passErr').html( "Enter Password" );
		return false;
	} 

	if( $('input[name=newPassword]').val().trim() != $('#confPassword').val() ){
		$('#confpassErr').html( "Password doesn't Match" );
		return false;
		 
	} 
	
	if( $('#confPassword').val().trim() == "" ){
		$('#confpassErr').html( "Please Confirm your password" );
		return false;
	} 
	
	return true;
}
</script>

 