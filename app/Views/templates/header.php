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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/github.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/diff2html/bundles/css/diff2html.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/fc-3.3.1/fh-3.1.7/r-2.2.6/datatables.min.css"/>


    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootbox.min.js"></script>
    <script src="/assets/js/fstdropdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/diff2html/bundles/js/diff2html-ui.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->

 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/fc-3.3.1/fh-3.1.7/r-2.2.6/datatables.min.js"></script>


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

    <div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <?php if (session()->get('isLoggedIn')): ?>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand text-center  bg-white">
          <a href="/projects" title="Project Data Reporting Tool" title="DocsGo">
            <img src="/Docsgo-Logo.png" height="80px" alt="DocsGo">
          </a>
          <div id="close-sidebar" class=" text-dark">
            <i class="fas fa-times" ></i>
          </div>
        </div>

        <div class="sidebar-header text-center">
        <span class="user-name text-white">
              <strong><?= session()->get('name') ?></strong>
            </span>
       </div>
        
        <div class="sidebar-menu">
          <ul>
            
            <li>
              <a href="/projects">
                <i class="fa fa-briefcase" style = "<?= ($uri->getSegment(1) == 'projects'   ? 'color:#16c7ff;' : null) ?>"></i>
                <span>Projects</span>
              </a>
            </li>

            <li>
              <a href="/team">
                <i class="fa fa-users" style = "<?= ($uri->getSegment(1) == 'team'   ? 'color:#16c7ff;' : null) ?>"></i>
                <span>Team</span>
              </a>
            </li>
            
            <li>
              <a href="/reviews">
                <i class="fa fa-list" style = "<?= ($uri->getSegment(1) == 'reviews'   ? 'color:#16c7ff;' : null) ?>"></i>
                <span>Review Register</span>
              </a>
            </li>

            <li class="sidebar-dropdown <?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master') ? 'active' : null) ?>">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Documents</span>
              </a>
              <div class="sidebar-submenu" style="<?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master') ? 'display:block;' : '') ?>">
                <ul>
                  <li>
                    <a href="/documents">Documents</a>
                  </li>        
                  <li>
                    <a href="/documents-templates">Templates</a>
                  </li>  
                  <li>
                    <a href="/documents-master">References</a>
                  </li>            
                </ul>
              </div>
            </li>

     



            <li>
              <a href="/risk-assessment">
                <i class="fa fa-lock" style = "<?= ($uri->getSegment(1) == 'risk-assessment'   ? 'color:#16c7ff;' : null) ?>"></i>
                <span>Risk Assessment</span>
              </a>
            </li>



            <li class="sidebar-dropdown <?= ((($uri->getSegment(1) == 'requirements') || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'active' : null) ?>">
              <a href="#">
                <i class="fa fa-search "></i>
                <span>Traceability</span>
              </a>
              <div class="sidebar-submenu" style="<?= ((($uri->getSegment(1) == 'requirements') || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'display:block;' : null) ?>">
                <ul>
                  <li>
                    <a href="/traceability-matrix">Traceability Matrix</a>
                  </li>
                  <li>
                    <a href="/requirements">Requirements</a>
                  </li>
                  <li>
                    <a href="/test-cases">Test</a>
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
            </li>
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
    
      

      