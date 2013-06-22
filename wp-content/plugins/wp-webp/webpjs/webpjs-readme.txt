Follow code can you add in the header or anywhere on your website:

<script type="text/javascript" src="js/webpjs-0.0.2.min.js"></script>

or this code. This code only load the js file when webp not supported by browser & is PageSpeed optimized:

<script>
(function(){
	var WebP=new Image();
	WebP.onload=WebP.onerror=function(){
		if(WebP.height!=2){
			var sc=document.createElement('script');
			sc.type='text/javascript';
			sc.async=true;
			var s=document.getElementsByTagName('script')[0];
			sc.src='js/webpjs-0.0.2.min.js';
			s.parentNode.insertBefore(sc,s);
		}
	};
	WebP.src='data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
})();
</script>
