  <!-- BEGIN: Main Menu-->
  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @if(Auth::user()->peran_pengguna == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('EmployeeMember') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Employee Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Master</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('CG') }}">Circle Group</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('grade.index') }}">Grade</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('SkillCategory') }}">Skill Category</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('competencie-groups.index') }}">Compentency Group</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('department.index') }}">Department</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('sub-department.index') }}">Sub Department</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('divisi.index') }}">Divisi</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('jabatan.index') }}">Job Title</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('level.index') }}">Level</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('scale.index') }}">Skala Corporate</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('target.index') }}">Target</a></li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#rotation" aria-expanded="false" aria-controls="rotation">
                    <i class="icon-repeat menu-icon"></i>
                    <span class="menu-title">Rotation History</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="rotation">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('rotation.index') }}">History Transaction</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('comp.history.index') }}">Competency History</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#cgOption" aria-expanded="false" aria-controls="cg">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">CG</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="cgOption">
                    <ul class="nav flex-column sub-menu">
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('EmployeeMember') }}">Member CG</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('Curriculum') }}">Competency Matrix</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('LogHistory') }}">Log History Curriculum</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('CompetenciesDirectory') }}">Competency Dictionary</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('WhiteTag') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('TagList') }}">White Tag</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('ceme') }}">CEME</a></li>
                    </ul>
                </div>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Curriculum') }}">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">Competency Matrix</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('LogHistory') }}">
                    <i class="icon-watch menu-icon"></i>
                    <span class="menu-title">Log History Curriculum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('CompetenciesDirectory') }}">
                    <i class="icon-book menu-icon"></i>
                    <span class="menu-title">Competency Dictionary</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('WhiteTag') }}">
                    <i class="icon-flag menu-icon"></i>
                    <span class="menu-title">Mapping Competency</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('TagList') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">White Tag</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ceme') }}">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">CEME</span>
                </a>
            </li>
            --}}
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#superman" aria-expanded="false" aria-controls="superman">
                    <i class="icon-command menu-icon"></i>
                    <span class="menu-title">Superman</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="superman">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('member.superman.index') }}">Member Superman</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.index') }}">Competency Matrix</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('DictionarySuperman') }}">Competency Dictionary</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('kelola.superman.index') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.tagging') }}">White Tag Superman</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.ceme') }}">CEME Superman</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#champion" aria-expanded="false" aria-controls="champion">
                    <i class="icon-cloud menu-icon"></i>
                    <span class="menu-title">Champions 4.0</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="champion">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('member.champion.index') }}">Member Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.index') }}">Curriculum 4.0</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('kelola.champion.index') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.taging') }}">White Tag Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('championCeme') }}">CEME Champion</a></li>
                    </ul>
                </div>
            </li>
            
        @elseif(Auth::user()->peran_pengguna == 2)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('EmployeeMember') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Member CG</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#rotation" aria-expanded="false" aria-controls="rotation">
                    <i class="icon-repeat menu-icon"></i>
                    <span class="menu-title">Rotation History</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="rotation">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('rotation.index') }}">History Transaction</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('comp.history.index') }}">Competency History</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Curriculum') }}">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">Competency Matrix</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('CompetenciesDirectory') }}">
                    <i class="icon-book menu-icon"></i>
                    <span class="menu-title">Competency Dictionary</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('WhiteTag') }}">
                    <i class="icon-flag menu-icon"></i>
                    <span class="menu-title">Mapping Competency</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('TagList') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">White Tag</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ceme') }}">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">CEME</span>
                </a>
            </li>
        @elseif(Auth::user()->peran_pengguna == 3)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('WhiteTag') }}">
                    <i class="icon-flag menu-icon"></i>
                    <span class="menu-title">Mapping Competency</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('TagList') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">White Tag</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('EmployeeMember') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Employee Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#cgDropdown" aria-expanded="false" aria-controls="cg">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">CG</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="cgDropdown">
                    <ul class="nav flex-column sub-menu">
                        <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('EmployeeMember') }}">Member CG</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('rotation.index') }}">History Transaction</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('comp.history.index') }}">Competency History</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('Curriculum') }}">Competency Matrix</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('CompetenciesDirectory') }}">Competency Dictionary</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('WhiteTag') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('TagList') }}">White Tag</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('ceme') }}">CEME</a></li>
                    </ul>
                </div>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link" href="{{ route('EmployeeMember') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Member CG</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Curriculum') }}">
                    <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">Competency Matrix</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('CompetenciesDirectory') }}">
                    <i class="icon-book menu-icon"></i>
                    <span class="menu-title">Competency Dictionary</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('WhiteTag') }}">
                    <i class="icon-flag menu-icon"></i>
                    <span class="menu-title">Mapping Competency</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('TagList') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">White Tag</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ceme') }}">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">CEME</span>
                </a>
            </li>
            --}}
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#superman" aria-expanded="false" aria-controls="superman">
                    <i class="icon-command menu-icon"></i>
                    <span class="menu-title">Superman</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="superman">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('member.superman.index') }}">Member Superman</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.index') }}">Competency Matrix</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('DictionarySuperman') }}">Competency Dictionary</a></li> -->
                    <li class="nav-item"> <a class="nav-link" href="{{ route('kelola.superman.index') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.tagging') }}">White Tag Superman</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('superman.ceme') }}">CEME Superman</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#champion" aria-expanded="false" aria-controls="champion">
                    <i class="icon-cloud menu-icon"></i>
                    <span class="menu-title">Champions 4.0</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="champion">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('member.champion.index') }}">Member Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.index') }}">Curriculum 4.0</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('kelola.champion.index') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.taging') }}">White Tag Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('championCeme') }}">CEME Champion</a></li>
                    </ul>
                </div>
            </li>
        @endif
        @if(Auth::user()->peran_pengguna == 1 || Auth::user()->id_job_title == "JT-0102" || Auth::user()->id_job_title == "JT-0049" || Auth::user()->nik == "180600122")
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="collapse" href="#management-system" aria-expanded="false" aria-controls="management-system">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Certification</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="management-system">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('master.system.index') }}">Data Certification</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('system.index') }}">Kelola Certification</a></li>
                    </ul>
                </div>
            </li> 
        @endif
        @if(Auth::user()->nik == "100192702")
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#champion" aria-expanded="false" aria-controls="champion">
                    <i class="icon-cloud menu-icon"></i>
                    <span class="menu-title">Champions 4.0</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="champion">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('member.champion.index') }}">Member Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.index') }}">Curriculum 4.0</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('kelola.champion.index') }}">Mapping Competency</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('champion.taging') }}">White Tag Champion</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('championCeme') }}">CEME Champion</a></li>
                    </ul>
                </div>
            </li>
        @endif
      </ul>
  </nav>
  <!-- END: Main Menu-->