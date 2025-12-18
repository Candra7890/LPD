<body onload="send()">
 <form action="{{ $redirect }}" method="POST" id="form-authdata">
  <input type="hidden" name="authData" value="{{ $jwt }}">
  <input type="submit" name="btnSubmit">
 </form> 
</body>

<script type="text/javascript">
	function send(){
		document.getElementById('form-authdata').submit();
	}
</script>