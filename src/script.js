const postsElem = document.querySelector("#resources .posts");
const form = document.querySelector("#resources form");

function getFeed(paramsStr) {
	fetch(`/wp-json/wp/v2/get_feed/?${paramsStr}`)
	// fetch(`/wp-json/wp/v2/get_feed`)
	  .then(response => response.text())
	  .then(html => addFeed(html));
}

function addFeed(html) {
	postsElem.innerHTML = html;
}

if(form) {
	form.addEventListener("change", e => {
		const formData = new FormData(form);
		const params = {};
		for(const [key, val] of formData.entries()) {
			params[key] = params[key] ? [...params[key], val] : [val];
		}
		const paramsStr = Object.keys(params).map(key => {
			return [key, params[key]].map(encodeURIComponent).join("=");
		}).join("&");
		getFeed(paramsStr);
	});
}