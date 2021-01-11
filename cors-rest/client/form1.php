<!--
Copyright 2021 Fernando Martinez

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
-->
<html>
<head>
<script>
    // Notice that this script displays 3 buttons to run each of the 3 requests shown below, and only logs the results
    // via console.log(). It does not produce any html output, so you will need to show the browser's console to see what
    // happens when you execute a request.

    // change baseurl to match the host and port and uri, so that you are pointing to this sample's server index.php in your own installation
    // if you do change the port, you will have to update it on the startserver script as well
var baseurl = 'http://localhost:8087/mygithub/code-lib/samples/corstest/server/index.php';

// Submits a GET request to retrieve the list of users
function sendGet() {
	const xhr = new XMLHttpRequest();
    var geturl = baseurl+'?clkey=rest/all';
	xhr.open('GET', geturl);
	xhr.onreadystatechange = function () {
	  // In local files, status is 0 upon success in Mozilla Firefox
	  if(xhr.readyState === XMLHttpRequest.DONE) {
		var status = xhr.status;
		if (status === 0 || (status >= 200 && status < 400)) {
		  // The request has been completed successfully
		  console.log(xhr.responseText);
		} else {
		   console.log('error');
		}
	  }
	};
	xhr.send();
}

// submit a POST request to add a new user
function sendPost() {
	const xhr = new XMLHttpRequest();
    var posturl = baseurl+'?clkey=rest/all';
	xhr.open('POST', posturl);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.onreadystatechange = function () {
	  // In local files, status is 0 upon success in Mozilla Firefox
	  if(xhr.readyState === XMLHttpRequest.DONE) {
		var status = xhr.status;
		if (status === 0 || (status >= 200 && status < 400)) {
		  // The request has been completed successfully
		  console.log(xhr.responseText);
		} else {
		   console.log('error');
		}
	  }
	};
	xhr.send('{"username":"john","email":"john@example.com"}');
}

// submit a PUT request to update an existing user
function sendPut() {
    const xhr = new XMLHttpRequest();
    var puturl = baseurl+'?clkey=rest/all';
    xhr.open('PUT', puturl);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        // In local files, status is 0 upon success in Mozilla Firefox
        if(xhr.readyState === XMLHttpRequest.DONE) {
            var status = xhr.status;
            if (status === 0 || (status >= 200 && status < 400)) {
                // The request has been completed successfully
                console.log(xhr.responseText);
            } else {
                console.log('error');
            }
        }
    };
    xhr.send('{"username":"john","email":"john2@example.com"}');
}
</script>
</head>
<body>
	<a href="#" onclick="sendGet();">Send Get</a><br>
	<button onclick="sendPost();">Send Post</button>
    <button onclick="sendPut();">Send Put</button>
</body>
</html>
