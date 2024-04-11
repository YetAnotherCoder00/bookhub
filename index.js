//---------hamburgerAnimation----------------------------------------------------------------\\

var McButton = $("[data=hamburger-menu]");
var McBar1 = McButton.find("b:nth-child(1)");
var McBar2 = McButton.find("b:nth-child(2)");
var McBar3 = McButton.find("b:nth-child(3)");



McButton.click( function() {
  $(this).toggleClass("active");
  
  if (McButton.hasClass("active")) {
    McBar1.velocity({ top: "50%" }, {duration: 200, easing: "swing"});
    McBar3.velocity({ top: "50%" }, {duration: 200, easing: "swing"})
    			.velocity({rotateZ:"90deg"}, {duration: 800, delay: 200, easing: [500,20] });
    McButton.velocity({rotateZ:"135deg"}, {duration: 800, delay: 200, easing: [500,20] });
  } else {
    McButton.velocity("reverse");
		McBar3.velocity({rotateZ:"0deg"}, {duration: 800, easing: [500,20] })
    			.velocity({ top: "100%" }, {duration: 200, easing: "swing"});
  	McBar1.velocity("reverse", {delay: 800});
  }
});

//-------imageSlider------------------------------------------\\

function changeImage(imageID) {
  let image = document.getElementById("slider_image")
  let link = document.getElementById("slider_imagelink")
  switch (imageID) {
    case 1:
      image.src="[neuesImage]"
      link.prop("href", "[neuerLink]")
      break;
    case 2:
      image.src="[neuesImage]"
      link.setAttribute("href", "[neuerLink]")
      break;
    case 3:
      image.src="[neuesImage]"
      link.setAttribute("href", "[neuerLink]")
      break;
  }
}







//------------------------------------------------//
//                                                //
//       Total wasted hours in JS: 2 hours        //
//                                                //
//------------------------------------------------//         
