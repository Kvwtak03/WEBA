<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="?url=dashboard" class="nav-link <?php echo $page == 'dashboard' ? 'active' : 'link-dark'; ?>">
          <span class="icon">
            <i class="bi bi-easel"></i>
          </span>
          Dashboard
        </a>
      </li>
      <li>
        <a href="index.php?page=items" class="nav-link <?php echo $page == 'items' ? 'active' : 'link-dark'; ?>">
          <span class="icon">
            <i class="bi bi-card-list"></i>
          </span>
          Items
        </a>
      </li>
      <li>
        <a href="?url=others" class="nav-link <?php echo $page == 'others' ? 'active' : 'link-dark'; ?>">
          <span class="icon">
            <i class="bi bi-box"></i>
          </span>
          Others
        </a>
      </li>
      <li>
        <a href="?url=users" class="nav-link <?php echo $page == 'users' ? 'active' : 'link-dark'; ?>">
          <span class="icon">
            <i class="bi bi-person-circle"></i>
          </span>
          Users
        </a>
      </li>
    </ul>
  </div>
</nav>