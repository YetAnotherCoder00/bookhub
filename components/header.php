<style>
#header_container { 
  background-color:#1C1D36;
  height: 8.5vh;
}

.logo {
  max-height: 100%;
  padding-top: 1.5vh;
  flex-grow: 2;
  display: flex;
  justify-content: center;
  flex-shrink: 1;
  padding-bottom: 1vh;
}

.logo img {
  height: 100%;
}

#header_container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.placeholder {
  width: 30%;

}

.menu {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-end;
  width: 30%;
}

.menu a {
  background: none;
  border: none;
  padding: 15px 15px;
  border-radius: 10px;
  cursor: pointer;
}

.menu a:hover {
  background: rgba(170, 170, 170, 0.062);
  transition: 0.5s;
}

.menu a img {
  width: 4vh;
  height: 4vh;
}

</style>


<body>
 
  <div id="header_container">

    <div class="placeholder">
      <p></p>
    </div>


    <div class="logo">
      <a href="/"><img src="../assets/logo.png" alt="logo"></a>
    </div>

    <div class="menu">
      <?php
      if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] && isset($_SESSION["admin"]) && $_SESSION["admin"]) {
        echo '<a href="../admin"> <img src="../assets/admin.svg" alt="admin panel" width="32" height="32"> </a>';
      }
      ?>
      <a href="/"> <img src="../assets/home.svg" alt="home icon" width="32" height="32"> </a>
      <a href="/search"> <img src="../assets/search.svg" alt="search icon" width="32" height="32"> </a>
      <?php
      if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
        echo '<a href="../logout"> <img src="../assets/logout.svg" alt="logout icon" width="32" height="32"> </a>';
      }
      else {
        echo '<a href="../login"> <img src="../assets/login.svg" alt="login icon" width="32" height="32"> </a>';
      }
      ?>
    </div>


 
  </div>


</body>
