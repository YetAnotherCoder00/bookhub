<style>
#header_container { 
  background-color:#1C1D36;
  max-height:10vh ;
}


body {
  margin: 0;
}

/* Hamburger Menu */
.McButton {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: -22px;
  margin-top: -22px;
  width: 44px;
  height: 33px;
  cursor: pointer;
}
.McButton b {
  position: absolute;
  left: 0;
  width: 44px;
  height: 3px;
  background-color: white;
}
.McButton b:nth-child(1) {
  top: 0;
}
.McButton b:nth-child(2) {
  top: 50%;
}
.McButton b:nth-child(3) {
  top: 100%;
}
</style>
<body>
  <div id="header_container"> 
    <a href="/"><img src="../assets/logo.png"></a>
    <div>
        <a class="McButton" data="hamburger-menu">
          <b></b>
          <b></b>
          <b></b>
        </a>
    </div>

  </div>
</body>
