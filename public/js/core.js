function rupiah_to_int(rupiah) {
	if (rupiah != '') {
		return parseInt(rupiah.substring(0, rupiah.length-3).replace(/\,/g, '').replace('Rp ', ''));
	}
	return 0;
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function sweet_alert(icon = 'success', title , text, showCancelButton =  false, cancelButtonText ='Tidak', confirmButtonText = 'OK'){
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        reverseButtons: !0,
        showCancelButton : showCancelButton,
        cancelButtonText : cancelButtonText,
        confirmButtonText : confirmButtonText
    })
}

function copy_to_clipboard(tag) {
	let elem = document.getElementById(tag);
  var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;

}


$(document).ready(function () {
	$(".input-money").inputmask({ alias : "currency", prefix: 'Rp ' });
    $('#search-navbar').click(function () {
        $('#form-search-navbar').submit();
    })
})