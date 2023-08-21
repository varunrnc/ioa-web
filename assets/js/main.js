$(document).ready(function(){



});


function set_discount(regular_price,selling_price,show_rate){
	$(selling_price).keyup(function(){
		var r_price = $(regular_price).val();
		var s_price = $(selling_price).val();
		if(r_price != '' && s_price != ''){
			var d_rate = Math.round(100-(s_price/r_price*100));
			$(show_rate).val(d_rate+'% ');
		}
	});
}