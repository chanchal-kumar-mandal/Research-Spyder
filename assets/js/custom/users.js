
  
function userlogin()
{
    
    
//alert (js_site_url);
   
	var username = $("#username").val();
	var password = $("#password").val();
   

	

	if(username.search(/\S/) == -1){
		$('#username').val('');
		$('#username').attr('placeholder', 'Please provide username.');
		$('#username').addClass('redmessage');
		return false;
	}

	if(password.search(/\S/) == -1){
	  
		$('#password').val('');
		$('#password').attr('placeholder', 'Enter Password.');
		$('#password').addClass('redmessage');

		return false;
	}

	$.ajaxSetup ({cache: false});
	var loadUrl = js_site_url+"login/userlogin";
        

	var formdata = $("#loginFrm").serialize();
	$.ajax({
		type: "POST",
		url: loadUrl,
		dataType:"html",
		data:formdata,
		success:function(responseText)
		{
			//alert(responseText);
			 if(responseText==0){

                            $('#login-alert').fadeIn('slow'); 

                            $('#login-alert').fadeOut(10000);

                        }
                        
                   
                      if(responseText==1)

                        {   

                            

                            window.location.href=js_site_url+"dashboard";

                            

                        }
		},
	   error: function(jqXHR, exception) {
	   		return false;
	 }
	});
	return false;
}
function  resetpassword()
{
    
    
    //alert (js_site_url);
   
	var emailpwd = $("#emailpwd").val();


		var validRegex=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

	if(emailpwd.search(/\S/) == -1){
		$('#emailpwd').val('');
		$('#emailpwd').attr('placeholder', 'Please provide emailid.');
		$('#emailpwd').addClass('redmessage');
		return false;
	}
else if(emailpwd.search(validRegex) == -1){

		$('#emailpwd').val('');

		$('#emailpwd').attr('placeholder', 'Enter valid email id.');

		//return false;

		$('#emailpwd').addClass('redmessage');



		flag=1;

	}


	$.ajaxSetup ({cache: false});
	var loadUrl = js_site_url+"login/sendmail";
        

	var formdata = $("#forgotpsw").serialize();
	$.ajax({
		type: "POST",
		url: loadUrl,
		dataType:"html",
		data:formdata,
		success:function(responseText)
		{
			//alert(responseText);
			 if(responseText==0){

                            $('#login-alert').fadeIn('slow'); 

                            $('#login-alert').fadeOut(10000);

                        }
                        
                   
                    
		},
	   error: function(jqXHR, exception) {
	   		return false;
	 }
	});
	return false;
}


    
    
    
    


