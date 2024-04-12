<style>
#header_container { 
  background-color:#1C1D36;
  max-height: 8.5vh;
}

.logo {
  padding-top: 1.5vh;
}


body {
  margin: 0;
}

#header_container {
  display: flex;
  justify-content: space-between;
}

.inline {
  display: inline-block;
}



.btn {
  padding-top: 6vh;
  transform: translate(-50%, -50%);
  width: 80px;
  cursor: pointer;
}

span {
  display: block;
  width: 100%;
  box-shadow: 0 2px 10px 0 rgba(0,0,0,0.3);
  border-radius: 3px;
  height: 8px;
  background: #878787;
  transition: all .3s;
  position: relative;
}

span + span {
  margin-top: 14px;
}

.active span:nth-child(1) {
  animation: ease .7s top forwards;
}

.not-active span:nth-child(1) {
  animation: ease .7s top-2 forwards;
}

.active span:nth-child(2) {
  animation: ease .7s scaled forwards;
}

.not-active span:nth-child(2) {
  animation: ease .7s scaled-2 forwards;
}

.active span:nth-child(3) {
  animation: ease .7s bottom forwards;
}

.not-active span:nth-child(3) {
  animation: ease .7s bottom-2 forwards;
}

@keyframes top {
  0% {
    top: 0;
    transform: rotate(0);
  }
  50% {
    top: 22px;
    transform: rotate(0);
  }
  100% {
    top: 22px;
    transform: rotate(45deg);
  }
}

@keyframes top-2 {
  0% {
    top: 22px;
    transform: rotate(45deg);
  }
  50% {
    top: 22px;
    transform: rotate(0deg);
  }
  100% {
    top: 0;
    transform: rotate(0deg);
  }
}

@keyframes bottom {
  0% {
    bottom: 0;
    transform: rotate(0);
  }
  50% {
    bottom: 22px;
    transform: rotate(0);
  }
  100% {
    bottom: 22px;
    transform: rotate(135deg);
  }
}

@keyframes bottom-2 {
  0% {
    bottom: 22px;
    transform: rotate(135deg);
  }
  50% {
    bottom: 22px;
    transform: rotate(0);
  }
  100% {
    bottom: 0;
    transform: rotate(0);
  }
}

@keyframes scaled {
  50% {
    transform: scale(0);
  }
  100% {
    transform: scale(0);
  }
}

@keyframes scaled-2 {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}

.placeholder {
    width: 80px;
}


</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


var btn = $('.btn');

(function($) {
$(document).ready(function() {
    $(".btn").click(function(){
        $(this).toggleClass('active not-active');
    });
});
})(jQuery);

</script>

<body>
 
  <div id="header_container">

    <div class="placeholder">
      <p></p>
    </div> 

    <div class="logo inline">
      <a href="/"><img src="../assets/logo.png"></a>
    </div>

    <div class="btn not-active inline">
      <span></span>
      <span></span>
      <span></span>
    </div>

  </div>

</body>
