jQuery(document).ready(function ($) {
	const dismissed = localStorage.getItem("remove-covid-banner");

	console.log(scriptParams.covid_banner_share);

	if (!scriptParams.in_array && dismissed !== "true") {
		$(
			`
        <div id="covid-banner" class="covid-banner">
            <div class="covid-group">
                <div class="covid-img">
                    <img class="coat" src="${
						scriptParams.img_src
					}" style="background-color: transparent;">
                </div>
                <div class="covid-body">
                    <h2 class="covid-header">				${
						scriptParams.covid_banner_header_text !== ""
							? scriptParams.covid_banner_header_text
							: "COVID-19"
					}</h2>
                    <p class="covid-text">${
						scriptParams.covid_banner_body_text !== ""
							? scriptParams.covid_banner_body_text
							: "Stay informed with official news &amp; stats:"
					}</p>
                    <a class="covid-link" href="https://sacoronavirus.co.za/"  target="_blank">
                        <span>${
							scriptParams.covid_banner_link_text !== ""
								? scriptParams.covid_banner_link_text
								: "SAcoronavirus.co.za"
						}</span>
                    </a>
				</div>
				<button id="covid-banner-dismiss-button" class="covid-close-button">
					<div class="covid-close-div">
						<svg
							viewBox="0 0 24 24"
							preserveAspectRatio="xMidYMid meet"
							focusable="false"
							class="style-scope yt-icon"
							style="
								pointer-events: none;
								display: block;
								width: 100%;
								height: 100%;
								fill: rgb(144, 144, 144);
							"
						>
							<g class="style-scope yt-icon">
								<path
									d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"
									class="style-scope yt-icon"
								></path>
							</g>
						</svg>
					</div>
				</button>
			</div>
			${
				scriptParams.covid_banner_share === "true"
					? '<div class="covid-footer"><a href="https://www.bridgement.com/blog/business-advice/how-to-comply-with-covid-19-regulations-for-south-africa-website/" target="_blank">ADD THIS BANNER TO YOUR SITE</a></div>'
					: ""
			}
        	</div>`
		).prependTo("body");

		$("#covid-banner-dismiss-button").click(() => {
			$("#covid-banner").remove();
			localStorage.setItem("remove-covid-banner", "true");
		});

		var bodyPaddingLeft = $("body").css("padding-left");
		var bodyPaddingRight = $("body").css("padding-right");

		if (bodyPaddingLeft != "0px") {
			$("head").append(
				'<style type="text/css" media="screen">.covid-banner{margin-left:-' +
					bodyPaddingLeft +
					";padding-left:" +
					bodyPaddingLeft +
					";}</style>"
			);
		}
		if (bodyPaddingRight != "0px") {
			$("head").append(
				'<style type="text/css" media="screen">.covid-banner{margin-right:-' +
					bodyPaddingRight +
					";padding-right:" +
					bodyPaddingRight +
					";}</style>"
			);
		}
	}
});
