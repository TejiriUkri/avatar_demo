function start_sending()
{

$('#response').html("please wait sending...");

// var number = $('#message').val();
var message = $('#message').val();
var path_url = "indexe.php";


$.ajax({

	type: "POST",
	url: path_url,
	data: {
		// numbers: number_loop(number),
		message: message
	},

	success: function(data) {
		console.log(data);
		var json = $.parseJSON(data);
		if (json.response == "success") {
			$('#response').html("Message Sent Successfully");
		}else{
			$('#response').html("Message Not Sent Successfully");
		}
	}
});


}

// var i = 0;

// function number_loop(numbers){

// 	var number = numbers[i];
// 	$("#current-number").html("please wait we are sending...");
// 	if (++i < numbers.length) {
// 		setTimeout(start_sending, 1000);
// 	}
// 	return number;
// }