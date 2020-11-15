function hide_lists() {

}

//Cross fade
images = [
    "images/pasta.jpg" ,
    "images/tacosalad.jpg" ,
    "images/phadthai.jpg" ,
    "images/chickenmac.jpg"
]
var image_box = $("#main_image" );
image_box.css({'position' : 'relative' , 'height' : '144px' } );
var image_html = "" ;
for(var i = 0; i < images.length; i++) {
    image_html += '<img style="position:absolute;top:0; z-index:' + (images.length - i) + '" src="' + images[i] + '" id="image_' + i + '"/>' ;
};
image_box.html(image_html);