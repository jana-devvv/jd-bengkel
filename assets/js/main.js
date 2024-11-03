function showErrors(errors) {
	$("#form .form-group").removeClass("has-error has-feedback");
	$("#form .form-text").text("");

	$.each(errors, function (key, value) {
		let keyFeedback = key + "-feedback"
		$("#" + keyFeedback).remove()

		if (value !== "") {
			let element = $("#" + key);
			let icon = element.closest('.input-icon');
			let feedback = `<small id="${keyFeedback}" class="form-text text-muted">${value}</small>`
			element.closest(".form-group").addClass("has-error has-feedback");

			if(icon.length) {
				icon.after(feedback)
			} else {
				element.after(feedback)
			}
		}
	});
}

const rupiah = (number) => {
	return new Intl.NumberFormat("id-ID", {
		style: "currency",
		currency: "IDR",
	}).format(number);
};

$(document).ready(function() {
	$(".input-number").on("input", function () {
		var value = $(this).val();
	
		value = value.replace(/[^0-9]/g, "");
	
		$(this).val(value);
	});
	
	$('.toggle-password').click(function() {
		const passwordInput = $(this).siblings('.input-password');
		const type = passwordInput.attr('type') === 'password' ? 'text' : 'password'
		passwordInput.attr('type', type)
		$(this).find('i').toggleClass('fa-eye fa-eye-slash')
	})
})