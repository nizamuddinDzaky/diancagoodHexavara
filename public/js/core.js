function rupiah_to_int(rupiah) {
	if (rupiah != '') {
		return parseInt(rupiah.substring(0, rupiah.length-3).replace(/\,/g, '').replace('Rp ', ''));
	}
	return 0;
}

$(document).ready(function () {
	$(".input-money").inputmask({ alias : "currency", prefix: 'Rp ' });
})