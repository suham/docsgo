<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link href="https://use.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/fstdropdown.css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css"></link>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
   
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootbox.min.js"></script>
    <script src="/assets/js/fstdropdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <title>DocsGo</title>
    <link rel="icon" href="<?=base_url()?>/Docsgo-Logo.png" type="image/gif">
    <!-- <link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/gif"> -->
    <style>
      .CodeMirror, .CodeMirror-scroll {
          height: auto;
          min-height: 70px;
      }
      body{
        font-family: "Open Sans";
      }
    </style>
  </head>
  <body>
    <?php
      $uri = service('uri');
     ?>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="/">PRT</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php if (session()->get('isLoggedIn')): ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
            <a class="nav-link"  href="/dashboard">Dashboard</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
            <a class="nav-link" href="/profile">Profile</a>
          </li>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>
          </li>
        </ul>
      <?php else: ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
            <a class="nav-link" href="/">Login</a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
        <?php endif; ?>
      </div>
      </div>
    </nav> -->
    <div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <?php if (session()->get('isLoggedIn')): ?>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand text-center">
          <a href="/projects" title="Project Data Reporting Tool" title="DocsGo">
            <img src="/Docsgo-Logo.png" height="80px" alt="DocsGo">
          </a>
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <!-- <div class="sidebar-header">
          <div class="user-pic">
          <a href="/profile" title="My Profile">
          <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
              alt="User picture">
        </a>
            
          </div>
          <div class="user-info">
            <span class="user-name">
              <strong><?= session()->get('name') ?></strong>
            </span>
           
          </div>
        </div> -->
        <div class="sidebar-header">
        <div class="user-info">
        <span class="user-name">
              <strong><?= session()->get('name') ?></strong>
            </span>
       </div>
       </div>
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
          <ul>
            <li class="header-menu">
              <span>Manage</span>
            </li>
            <li class="sidebar-dropdown <?= ((($uri->getSegment(1) == 'projects')
            || $uri->getSegment(1) == 'reviews')  ? 'active' : null) ?>">
              <a href="/projects">
                <i class="fa fa-briefcase"></i>
                <span>Project</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
              <!-- <div class="sidebar-submenu">
                <ul>
                <li>
                    <a href="/reviews">Review Comments</a>
                  </li>
                  <li>
                    <a href="/projects">View/Add/Update</a>
                  </li>
                  <li>
                    <a href="/projects/add">Add New</a>
                  </li>
                  <li>
                    <a href="/documents">Documents</a>
                  </li>                  
                </ul>
              </div> -->
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'documents-templatesents' ? 'active' : null) ?>">
              <a href="/documents-templates">
                <i class="fa fa-folder-open"></i>
                <span>Templates</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'documents' ? 'active' : null) ?>">
              <a href="/documents">
                <i class="fa fa-folder-open"></i>
                <span>Documents</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'reviews' ? 'active' : null) ?>">
              <a href="/reviews">
                <i class="fa fa-folder-open"></i>
                <span>Review Comments</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'documents-master' ? 'active' : null) ?>">
              <a href="#">
                <i class="fa fa-folder-open"></i>
                <span>References</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="/documents-master">View/Add/Update</a>
                  </li>
                  <!-- <li>
                    <a href="/documents-master/add">Add New</a>
                  </li> -->
                </ul>
              </div>
            </li>
            
            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'team' ? 'active' : null) ?>">
              <a href="#">
                <i class="far fa-user"></i>
                <span>Team</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="/team">View/Add/Update</a>
                  </li>
                  <!-- <li>
                    <a href="/team/add">Add New</a>
                  </li> -->
                </ul>
              </div>
             </li>

             <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'issues' ? 'active' : null) ?>">
              <a href="/issues">
                <i class="fa fa-folder-open"></i>
                <span>Issues/Observations</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'cybersecurity' ? 'active' : null) ?>">
              <a href="/cybersecurity">
                <i class="fa fa-folder-open"></i>
                <span>Cybersecurity</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'soup' ? 'active' : null) ?>">
              <a href="/soup">
                <i class="fa fa-folder-open"></i>
                <span>SOUP</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ($uri->getSegment(1) == 'risk-assessment' ? 'active' : null) ?>">
              <a href="/risk-assessment">
                <i class="fa fa-folder-open"></i>
                <span>Risk Assessment</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
            </li>

            <li class="sidebar-dropdown <?= ((($uri->getSegment(1) == 'requirements') 
            || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'active' : null) ?>">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Traceability</span>
                <!-- <span class="badge badge-pill badge-warning">New</span> -->
              </a>
              <div class="sidebar-submenu">
                <ul>
                <li>
                    <a href="/requirements">Requirements</a>
                </li>
                <li>
                    <a href="/test-cases">Test cases</a>
                  </li>
                  <li>
                    <a href="/traceability-matrix">Traceability Matrix</a>
                  </li>
                </ul>
              </div>
            </li>
            
            <!--<li class="sidebar-dropdown">
              <a href="#">
                <i class="far fa-edit"></i>
                <span>Update from Testlink</span>
                
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Requirements</a>
                  </li>
                  <li>
                    <a href="#">Test Cases</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="header-menu">
              <span>Reports </span>
              
            </li>
            <li>
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Traceability Matrix</span>
                <span class="badge badge-pill badge-primary">Beta</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-list"></i>
                <span>IEC 62304 Compliance</span>
                
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-folder"></i>
                <span>Cybersecurity Compliance</span>
              </a>
            </li> -->
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
      <div class="sidebar-footer">
      <?php if (session()->get('is-admin')): ?>
        <a href="/admin/users">
          <i class="fa fa-users" style="font-size: 20px;" title="Registered Users"></i>
          <span class="badge badge-pill badge-warning notification" style="font-size: 7px;">!</span>
        </a>
      <?php endif; ?>
        <!-- 
        <a href="#">
          <i class="fa fa-envelope"></i>
          <span class="badge badge-pill badge-success notification">7</span>
        </a>
         -->
        <a href="/profile">
          <i class="fa fa-id-badge" style="font-size: 20px;" title="My Profile"></i>
          <span class="badge badge-pill  badge-success notification" style="font-size: 7px;">&nbsp;</span>
        </a>
        <a href="/logout" title="Log Out">
          <i class="fa fa-power-off" style="font-size: 20px;"></i>
        </a>
      </div>
    </nav>
    <main class="page-content">
    <?php endif; ?>
    
      

      