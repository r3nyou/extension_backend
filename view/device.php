<button id='start'>start</button>

<div id="content"></div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://cdn.bootcss.com/socket.io/2.0.3/socket.io.js'></script>

<script>
const socket = io('http://127.0.0.1:3120');

const uid = 'B2221E95F7C673FFA205A97D40A8CDE9';

socket.on('connect', function() {
    socket.emit('login', uid);
});

const contentDiv = document.getElementById('content');
socket.on('new msg', function(content) {
    //console.log(content);
    contentDiv.innerHTML += `<p>${content}</p>`;
});

$("#start").click(function() {
	/*
	$.get( url, { to: uid, content: 'test' } )
		.done(function( data ) {
			//alert( "Data Loaded: " + data );
		});
	*/
	let data = JSON.stringify({
			'to': uid,
			'content': 'test',			
		});
	
	socket.emit('device msg', data);
});
</script>