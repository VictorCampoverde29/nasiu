<aside class="main-sidebar elevation-4 sidebar-no-expand sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link text-center d-block">
      <img src="<?= base_url('public/dist/img/logo/logogasiu.png') ?>" alt="AdminLTE Logo" width="120" >

    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-overflow os-host-overflow-y os-host-scrollbar-horizontal-hidden">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          
            <div class="info">
            <b>USUARIO:</b><a href="#" class="d-block"><?= esc(session()->get('nombreusuariocorto')); ?></a>
            <b>PERFIL:</b><span class="left badge badge-warning"><?= esc(session()->get('perfil')); ?></span>
           
            </div>
          
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php 
                    $urls=session()->get('urls');
                    foreach ($urls as $url) {
                        if ($url['padre'] == 0 & $url['tipo']!=='GT') {
                            echo '<li class="nav-item">'.
                                    '<a href="#" class="nav-link">'.
                                        '<i class="'.$url['logo'].'"></i>'.
                                        ' <p>'.$url['descripcion'].'<i class="right fas fa-angle-left"></i></p>'.
                                    '</a>'.
                                    '<ul class="nav nav-treeview">';
                                    foreach ($urls as $childUrl) {                                        
                                        if ($childUrl['padre'] == $url['idbarras_perfil']) { // Asegúrate de que 'id' es el identificador correcto
                                            echo '<li class="nav-item"> 
                                                    <a href="'.base_url($childUrl['ruta']).'" class="nav-link">
                                                        <i class="nav-icon fas fa-circle-dot"></i>
                                                        <p>'.$childUrl['descripcion'].'</p>'.
                                                    '</a> </li>';
                                        }
                                    }
                            echo '</ul></li>';        
                        }
                    }
                ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>