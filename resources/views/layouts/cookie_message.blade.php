<div id="cookie-message" class="d-none">
    <p class="text-center">
        <i class="fas fa-cookie color1"></i>
        {{ __('The website uses cookies in order to personalise the website.') }}
        <br>
        <a href="{{ route("privacy") }}"
           class="cookie-message-privacy-page small">
            <i class="fas fa-info-circle color1"></i>
            {{ __('More information') }}
        </a>&nbsp;|
        <a href="javascript:void(0)" id="accept-cookie-message"
           class="small">
            <i class="far fa-times-circle color1"></i>
            {{ __('Close') }}
        </a>
    </p>
</div>
<script>
	$(document).ready(function () {
		let cookieName = "cookie-message";
		let $cookieMessage = $('#cookie-message');

		if(!$.getCookie(cookieName)) {
			$cookieMessage.removeClass("d-none");
		}

		$('#accept-cookie-message').click(function () {
			$.setCookie(cookieName, 1, 365);
			$cookieMessage.addClass("d-none");
		})
	});
</script>
