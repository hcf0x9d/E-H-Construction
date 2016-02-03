<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>E&amp;H Construction Site Administration</title>

<script src="/library/scripts/jquery-1.8.0.min.js"></script>
</head>

<body>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
    	<td colspan="3" bgcolor="#222222" style="padding:20px;text-align:center;">
        	<img src="/images/eh-construction-logo.png" />
        </td>
    </tr>
    <tr>
	<form id="loginForm" name="loginForm" method="post" action="">
		<td>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
				<tr>
                	<td><strong>Admin Login </strong></td>
                </tr>
                <tr>
                	<td width="294"><input name="username" type="text" placeholder="User Name"></td>
                </tr>
                <tr>
                	<td><input type="password" name="password" placeholder="Password"></td>
                </tr>
                <tr>
                	<td><input type="submit" name="Submit" value="Login"></td>
                </tr>
			</table>
		</td>
	</form>
	</tr>
</table>

<script>
    $(function () {
        $('#loginForm').submit(function (e) {
            e.preventDefault();
            
            var data = $('#loginForm').serialize();
            
            $.ajax({
                url: 'models/log.php',
                data: data,
                type: 'post',
                success: function(response) {
                    if (response === '1') {
                        window.location.href = 'projects/index.php';
                        
                    } else {
                        $('#loginForm').addClass('error');
                        
                    }
                 }
            });
        });
    });
</script>

</body>
</html>