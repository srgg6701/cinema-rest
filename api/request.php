<pre>
<?php
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "http://127.0.0.1/projects/cinema-rest/api/response.php");

	curl_setopt($curl, CURLOPT_HEADER, 1);
	
	if($method=$_GET['method']){
		switch ($method) {
			/*case 'delete':
				curl_setopt($curl, CURLOPT_DELETE, 1);
				break;*/
			case 'post':
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "nickname=Amigo&age=119&gender=male&color=green");
				break;
			case 'put':
				curl_setopt($curl, CURLOPT_PUT, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "nickname=Amigo&age=119&gender=male&color=green");
				break;
		}
	}
	
	$a = curl_exec($curl);
	curl_close($curl);
	echo $a;
?>
</pre>