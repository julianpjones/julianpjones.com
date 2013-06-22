//
// Wrapper foe use of libwebp
//
// Parses all img tags, decompress the webp images and draws them as PNG
//
function createRequestObject() {
	var ro;
	var browser = navigator.appName;
	if (browser == "Microsoft Internet Explorer") {
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		ro = new XMLHttpRequest();
	}
	return ro;
}

function convertBinaryToArray(binary) {
	var arr = new Array();
	var num = binary.length;
	var i;
	for (i = 0; i < num; ++i)
		arr.push(binary.charCodeAt(i));
	return arr;
}

function WebPDecodeAndDraw(canvasid, data) {
	// /--------- libwebpjs 0.2.0 decoder code start
	// ---------------------------------------------
	// var WebPImage = { width:{value:0},height:{value:0} };
	var decoder = new WebPDecoder();

	data = convertBinaryToArray(data);// unkonvertierung in char

	// Config, you can set all arguments or what you need, nothing no objeect
	var config = decoder.WebPDecoderConfig;
	var output_buffer = config.j;
	var bitstream = config.input;

	if (!decoder.WebPInitDecoderConfig(config)) {
		alert("Library version mismatch!\n");
		return -1;
	}

	// var StatusCode = decoder.VP8StatusCode;

	status = decoder.WebPGetFeatures(data, data.length, bitstream);
	if (status != 0) {
		alert('error');
	}

	// var mode = decoder.WEBP_CSP_MODE;
	output_buffer.J = 4;

	status = decoder.WebPDecode(data, data.length, config);

	ok = (status == 0);
	if (!ok) {
		alert("Decoding of %s failed.\n");
		// fprintf(stderr, "Status: %d (%s)\n", status,
		// kStatusMessages[status]);
		return -1;
	}

	// alert("Decoded %s. Dimensions: "+output_buffer.width+" x
	// "+output_buffer.height+""+(bitstream.has_alpha.value ? " (with alpha)" :
	// "")+". Now saving...\n");
	var bitmap = output_buffer.c.RGBA.ma;
	// var bitmap = decoder.WebPDecodeARGB(data, data.length, WebPImage.width,
	// WebPImage.height);

	// /--------- libwebpjs 0.2.0 decoder code end
	// ---------------------------------------------

	if (bitmap) {
		// Draw Image
		var biHeight = output_buffer.height;
		var biWidth  = output_buffer.width;
		var canvas   = document.getElementById(canvasid);
		var iwidth   = canvas.width;
		var iheight  = canvas.height;

		canvas.width = biWidth;
		canvas.height = biHeight;

		var context = canvas.getContext('2d');
		var output = context.createImageData(canvas.width, canvas.height);
		var outputData = output.data;

		for ( var h = 0; h < biHeight; h++) {
			for ( var w = 0; w < biWidth; w++) {
				outputData[0 + w * 4 + (biWidth * 4) * h] = bitmap[1 + w * 4 + (biWidth * 4) * h];
				outputData[1 + w * 4 + (biWidth * 4) * h] = bitmap[2 + w * 4 + (biWidth * 4) * h];
				outputData[2 + w * 4 + (biWidth * 4) * h] = bitmap[3 + w * 4 + (biWidth * 4) * h];
				outputData[3 + w * 4 + (biWidth * 4) * h] = bitmap[0 + w * 4 + (biWidth * 4) * h];
			};
		};

		context.putImageData(output, 0, 0);
		context.drawImage(canvas, 0, 0);

		var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
		var newCanvas = jQuery("<canvas>").attr("width", imageData.width).attr(
				"height", imageData.height)[0];

		newCanvas.getContext("2d").putImageData(imageData, 0, 0);

		canvas.width = iwidth;
		canvas.height = iheight;
		var wscale = iwidth / biWidth;
		var hscale = iheight / biHeight;
		context.scale(wscale, hscale);
		context.drawImage(newCanvas, 0, 0);

	}
};

function handleImageLoaded(http, canvasid) {
	var response = "";
	if (http.readyState == 4) {
		if (typeof http.responseBody == 'undefined') {
			response = http.responseText.split('').map(function(e) {
				return String.fromCharCode(e.charCodeAt(0) & 0xff);
			}).join('');
		} else {
			response = convertResponseBodyToText(http.responseBody);
		}
		WebPDecodeAndDraw(canvasid, response);
	}
};

jQuery(document).ready(function() {
		jQuery("img").each(
				function() {
					var iurl    = jQuery(this).attr('src');
					var iid     = jQuery(this).attr('id');
					var ialt    = jQuery(this).attr('alt');
					var iclass  = jQuery(this).attr('class'); 
					var iwidth  = jQuery(this).attr('width');
					var iheight = jQuery(this).attr('height');
					var iext    = iurl.substring(iurl.lastIndexOf('.'), iurl.length);
					var iname   = 'wpwebp_' + iurl.substring(iurl.lastIndexOf('/') + 1, iurl.lastIndexOf('.'));

					if (iext == ".webp") {
					
						if (typeof iid == 'undefined' || iid == '')
							iid = iname;
						tid = 'id="' + iid + '"';

						if (typeof ialt == 'undefined' || ialt == '')
							ialt = "";
						else
							ialt = 'alt="' + ialt + '"';
											
						if (typeof iclass == 'undefined' || iclass == '')
							iclass = "";
						else
							iclass = 'class="' + iclass + '"';

						if (typeof iwidth == 'undefined' || iwidth == '')
							iwidth = '';
						else
							iwidth = 'width="' + iwidth	+ '"';

						if (typeof iheight == 'undefined' || iheight == '')
							iheight = '';
						else
							iheight = 'height="' + iheight	+ '"';

						// canvas tag einfügen
						jQuery('<canvas ' + tid + ' ' + iwidth + ' ' + iheight + ' ' + ialt + ' ' + iclass + ' ' + '>'	+ '</canvas>').insertAfter(jQuery(this));
						// img tag aus dom löschen
						jQuery(this).remove();

						// bild aus der url holen und
						// konvertieren
						var http = createRequestObject();
						http.open('get', iurl);
						if (http.overrideMimeType)
							http.overrideMimeType('text/plain; charset=x-user-defined');
						else
							http.setRequestHeader('Accept-Charset','x-user-defined');

						http.onreadystatechange = function() {	handleImageLoaded(http, iid);};
						http.send(null);
					}
			});
		});