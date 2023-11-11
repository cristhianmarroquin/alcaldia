
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
    <?php
      require "./php/main.php"; 
      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 3");
      if ($per_usu->rowCount()>0) {
        $per_usu=$per_usu->fetchAll();
        echo '<div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>
                  <div class="navbar-dropdown">';
        foreach ($per_usu as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=usuario/user_new">Nuevo</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=usuario/user_list">Lista</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=usuario/user_search">Buscar</a>';
          }
          if ($usu["psm_per"] == "1") {
            echo '<hr class="navbar-divider">';
            echo '<a class="navbar-item" href="index.php?vista=usuario/per_new">Perfil</a>';
          }
        }	
        echo '  </div>
              </div>';
      }
      $per_usu = null;

      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 1");
      if ($per_usu->rowCount()>0) {
        $per_usu=$per_usu->fetchAll();
        echo '<div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Dependencia</a>
                  <div class="navbar-dropdown">';
        foreach ($per_usu as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=dependencia/dep_new">Nuevo</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=dependencia/dep_list">Lista</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=dependencia/dep_search">Buscar</a>';
          }
        }	
        echo '  </div>
              </div>';
      }
      $per_usu = null;

      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 2");
      if ($per_usu->rowCount()>0) {
        $per_usu=$per_usu->fetchAll();
        echo '<div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">seriales</a>
                  <div class="navbar-dropdown">';
        foreach ($per_usu as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=serial/ser_new">Nuevo</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=serial/ser_list">Lista</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=serial/ser_search">Buscar</a>';
          }
        }	
        echo '  </div>
              </div>';
      }
      $per_usu = null;

      $cierre=0;
      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT GROUP_CONCAT(psm_mod)as modulo FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod in (4,5)");
      if ($per_usu->rowCount()>0) {
        $modulo=$per_usu->fetch();
        if ($modulo["modulo"]!=null) {
          echo '<div class="navbar-item has-dropdown is-hoverable">
                  <a class="navbar-link">';
          if ($modulo["modulo"]=='5' || $modulo["modulo"]=='5,5' || $modulo["modulo"]=='5,5,5') {
            echo 'tipo de subserial</a>';
          }else{
            echo 'sub seriales</a>';
          }
          echo '<div class="navbar-dropdown">';
        }
      }
      $per_usu = null;
      $per_subser = conexion();
      $per_subser = $per_subser->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 4");
      if ($per_subser->rowCount()>0) {
        $cierre=1;
        $per_subser=$per_subser->fetchAll();
        foreach ($per_subser as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=subserial/sub_new">Nuevo</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=subserial/sub_list">Lista</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=subserial/sub_search">Buscar</a>';
          }
        }

      }
      $per_subser = null;
      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 5");
      if ($per_usu->rowCount()>0) {
        
        $per_usu=$per_usu->fetchAll();
        if ($cierre==1) {
          echo '<hr class="navbar-divider">';
        }
        $cierre=1;
        foreach ($per_usu as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=subserial/tipo/tip_new">Tipo Nuevo</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=subserial/tipo/tip_list">Tipo Lista</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=subserial/tipo/tip_search">Tipo Buscar</a>';
          }
        }	

      }
      if ($cierre==1) {
        echo '  </div>
        </div>';
      }

      $per_usu = null;

      $per_usu = conexion();
      $per_usu = $per_usu->query("SELECT psm_per FROM persumo where psm_usu = '".$_SESSION['id']."' and psm_mod = 6");
      if ($per_usu->rowCount()>0) {
        $per_usu=$per_usu->fetchAll();
        echo '<div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">documentos</a>
                  <div class="navbar-dropdown">';
        foreach ($per_usu as $usu) {
          if ($usu["psm_per"] == "1") {
            echo '<a class="navbar-item"  href="index.php?vista=documento/doc_new">Documentos</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=documento/doc_search">Documentos Antiguos</a>';
          }
          if ($usu["psm_per"] == "3") {
            echo '<a class="navbar-item" href="index.php?vista=documento/doc_search">Buscar</a>';
          }
          if ($usu["psm_per"] == "2") {
            echo '<a class="navbar-item" href="index.php?vista=documento/doc_list">Adjuntar</a>';
          }
        }	
        echo '  </div>
              </div>';
      }
      $per_usu = null;
    ?>

    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=usuario/user_update&user_codigo_up= <?php echo $_SESSION['id'];?>" class="button is-primary is-outlined is-rounded">
            Mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-link is-outlined is-rounded">
            salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>