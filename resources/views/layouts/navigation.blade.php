<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
              <div class="container-xxl d-flex h-100">
              
                <ul class="menu-inner pb-2 pb-xl-0">
                @auth
                  <li class="menu-item">
                    <a href="/dashboard" class="menu-link">
                      <i class="menu-icon ti ti-home"></i>
                      <div data-i18n="Inicio">Inicio</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                      <i class="menu-icon tf-icons ti ti-settings"></i>
                      <div data-i18n="Adimistración">Admistración</div>
                    </a>

                    <ul class="menu-sub">
                      @can('Ver Usuarios')
                      <li class="menu-item">
                        <a href="/user" class="menu-link">
                          <i class="menu-icon tf-icons ti ti-users"></i>
                          <div data-i18n="Usuarios">Usuarios</div>
                        </a>
                      </li>
                      @endcan
                      @can('Editar Permisos')
                      <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                          <i class="menu-icon tf-icons ti ti-lock"></i>
                          <div data-i18n="Permisos">Permisos</div>
                        </a>
                        <ul class="menu-sub">
                          <input type="hidden" value="{{$roles = Spatie\Permission\Models\Role::get()}}">
                          @foreach ($roles as $role)
                          @if($role->name!='Scaneer')
                          <li class="menu-item">
                            <a href="/roles/{{ $role->id }}/permissions/edit" class="menu-link">
                              <div data-i18n="{{ $role->name }}">{{ $role->name }}</div>
                            </a>
                          </li>
                          @endif
                          @endforeach
                        
                        </ul>
                      </li>
                      @endcan


                    </ul>
                  </li>

                  <!-- Apps -->
                  @can('Personal')
                  <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">                      
                      <i class="menu-icon fa-solid fa-users-gear"></i>
                      <div data-i18n="Personal">Personal</div>
                    </a>
                  
                    <ul class="menu-sub">
                     
                      @can('Ver Areas')
                      <li class="menu-item">
                        <a href="/areas" class="menu-link">
                          <i class="menu-icon fa-solid fa-users-rays"></i>
                          <div data-i18n="Areas">Areas</div>
                        </a>
                      </li>
                      @endcan
                      @can('Ver Personal')
                      <li class="menu-item">
                        <a href="/empleados" class="menu-link">
                          <i class="menu-icon fa-solid fa-users"></i>
                          <div data-i18n="Empleados">Empleados</div>
                        </a>
                      </li>
                      @endcan
                   
                    </ul>
                  </li>
                  @endcan
                  @can('Carnets')
                  <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                      <i class="menu-icon  fa-solid fa-id-card"></i>
                      <div data-i18n="Carnets">Carnets</div>
                    </a>
                  
                    <ul class="menu-sub">
                     
                      @can('Ver Carnets')
                      <li class="menu-item">
                        <a href="/carnets-empleados" class="menu-link">
                          <i class="menu-icon  fa-solid fa-id-card-clip"></i>
                          <div data-i18n="Ver y Crear Carnets">Ver y Crear Carnets</div>
                        </a>
                      </li>
                      @endcan
                    
                   
                    </ul>
                  </li>
                  @endcan
                  @can('Scaner QR')
                  @if(auth()->user()->id==1 || auth()->user()->id==2 || auth()->user()->id==3 || auth()->user()->id==4 || auth()->user()->id==5 || auth()->user()->id==6 || auth()->user()->id==7 || auth()->user()->id==8 || auth()->user()->id==9)
                  <li class="menu-item">
                    <a href="/scanner-entradas-salidas" class="menu-link">
                      <i class="menu-icon fa-solid fa-qrcode"></i>
                      <div data-i18n="Scanear Entradas y salidas">Scanear Entradas y salidas</div>
                    </a>
                  </li>
                  @endif
                  @endcan
                  @can('Reportes')
                  <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                      <i class="menu-icon fa-solid fa-chart-simple"></i>
                      <div data-i18n="Reportes">Reportes</div>
                    </a>
                  
                    <ul class="menu-sub">
                     
                      @can('Reporte entradas y salidas')
                      <li class="menu-item">
                        <a href="/reportes" class="menu-link">
                          <i class="menu-icon fa-solid fa-magnifying-glass-chart"></i>
                          <div data-i18n="Entradas y salidas">Entradas y salidas</div>
                        </a>
                      </li>
                      @endcan
                      @can('Reporte entradas y salidas')
                      <li class="menu-item">
                        <a href="/reportes-asistencia" class="menu-link">
                          <i class="menu-icon fa-solid fa-chart-simple"></i>
                          <div data-i18n="Asistencia e Inasistencia">Asistencia e Inasistencia</div>
                        </a>
                      </li>
                      @endcan
                      @can('Reporte entradas y salidas')
                      <li class="menu-item">
                        <a href="/ausentismo" class="menu-link">
                          <i class="menu-icon fa-solid fa-chart-simple"></i>
                          <div data-i18n="Ausentismo">Ausentismo</div>
                        </a>
                      </li>
                      @endcan
                    
                   
                    </ul>
                  </li>
                  @endcan

                  @endauth

                  
                </ul>
               
              </div>
            </aside>




<!-- Authentication -->

