document.addEventListener('DOMContentLoaded', function (){
	let body = document.querySelector('body');
	let preloader = document.querySelector('.preloader');
	let logo = document.querySelector('.preloader__logo');
	let header = document.querySelector('header');
	let main = document.querySelector('main');
	let footer = document.querySelector('footer');
	if (!window.localStorage.getItem('preloaderIsShown')) {
		body.classList.add('hidden');
		preloader.classList.add('preloader-show');
		setTimeout(function() {
			logo.classList.add("shown");
		}, 200);
		window.addEventListener('load', function (){
			setTimeout(function(){
				header.classList.add('visible');
				main.classList.add('visible');
				footer.classList.add('visible');
				preloader.classList.remove("preloader-show");
				preloader.classList.add("preloader-hide");
				setTimeout(function(){
					body.classList.remove('hidden');
				}, 1000);
				setTimeout(function() {
					preloader.remove();
				}, 2000);
				window.localStorage.setItem('preloaderIsShown', true);
			}, 1000);
		});
	}else{
		header.classList.add('visible');
		main.classList.add('visible');
		footer.classList.add('visible');
		preloader.remove();
	}
});
