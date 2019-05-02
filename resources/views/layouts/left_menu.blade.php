 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::route('home') }}">
      	 <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-dna"></i>
        </div>
        <div class="sidebar-brand-text mx-1">Биоинформатика</div>
      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('home') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Преглед</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-users"></i>
          <span>Корисници</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ URL::route('user_student') }}">Студенти</a>
            <a class="collapse-item" href="{{ URL::route('user_admin') }}">Администратори</a>
            <a class="collapse-item" href="{{ URL::route('user_status') }}">Статус</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('admin_themes') }}">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Тематики</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('admin_exercises') }}">
          <i class="fas fa-fw fa-code"></i>
          <span>Задачи</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('admin_semesters') }}">
          <i class="fas fa-fw fa-calendar"></i>
          <span>Семестри</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('admin_grades') }}">
          <i class="fas fa-fw fa-university"></i>
          <span>Поени и оценки</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::route('admin_overview') }}">
          <i class="fas fa-fw fa-chalkboard"></i>
          <span>Преглед на задачи</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>