function setOpacity(elem, opacity) {
  /*
   * elem : The id of the element; 
   * opacity: The value of alpha, which is a decimals.
   */
  if (elem.style.filter) {   //IE
    elem.style.filter = 'alpha(opacity:' + opacity * 100 + ')';
  } else {
    elem.style.opacity = opacity;
  }
}
/*
function getOpacity(elem) {
    return (elem.style.filter ? elem.style.filter)
}*/
function fadeIn(elem, speed) {
  /* 
   * elem, the id of the element;
   * speed, the speed for the fadeIn.(The value lower, the less time needs)
   * opacity, the target opacity will be reach, 0.0 to 1.0
   */
  elem.style.display = "block";
  setOpacity(elem, 0);

  var tempOpacity = 0;
  (function () {
    setOpacity(elem, tempOpacity);
    tempOpacity += 0.05;
    if (tempOpacity <= 1) {
      setTimeout(arguments.callee, speed);
      //tempOpacity += 0.05;
    }
  })();
}

function fadeOut(elem, speed) {
  /* 
   * elem, the id of the element;
   * speed, the speed for the fadeout;
   speed, the speed for the fadein.(The value lower, the less time needs);
   */
  elem.style.display = "block";
  var tempOpacity = 1;
  (function () {
    setOpacity(elem, tempOpacity);
    tempOpacity -= 0.05;
    if (tempOpacity > 0) {
      setTimeout(arguments.callee, speed);
    } else {
      elem.style.display = "none";
    }
  })();
  //elem.style.display = "none";
}

function fadeTo(elem, speed, opacity) {
  /* elem, the id of the element;
   * speed, the speed to of the fadeTo.(The value lower, the less time needs)
   * opacity, the opacity of the final result;
   */
  var tempOpacity = 0;
  elem.style.display = "block";
  (function () {
    setOpacity(elem, tempOpacity);
    tempOpacity += 0.05;
    if (tempOpacity <= opacity) {
      setTimeout(arguments.callee, speed);
    }
  })();
}
function lazyLoad() {
  document.addEventListener("scroll", lazyLoad);
  window.addEventListener("resize", lazyLoad);
  window.addEventListener("orientationchange", lazyLoad);

  let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
  let active = false;

  if (active === false) {
    active = true;
    setTimeout(function () {
      lazyImages.forEach(function (lazyImage) {
        if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
          lazyImage.src = lazyImage.getAttribute("dataset");
          lazyImage.srcset = lazyImage.getAttribute("dataset");
          lazyImage.classList.remove("lazy");

          lazyImages = lazyImages.filter(function (image) {
            return image !== lazyImage;
          });
        }
      });
      if (lazyImages.length === 0) {
        document.removeEventListener("scroll", lazyLoad);
        window.removeEventListener("resize", lazyLoad);
        window.removeEventListener("orientationchange", lazyLoad);
      }
      active = false;
    }, 200);
  }
}