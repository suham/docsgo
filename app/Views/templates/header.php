<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/header.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="/assets/css/bootstrap4-toggle.min.css" />
    <link rel="stylesheet" href="/assets/css/simplemde_v1.11.1.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-select_v1.13.14.min.css" />
    
    <!-- For Showing Code Diff  -->
    <link rel="stylesheet" href="/assets/css/github_diff.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/diff2html.min.css" />

    <!-- For Datatables -->
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>


    <script type="text/javascript" src="/assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/popper.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootbox.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript" src="/assets/js/simplemde.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/js/diff2html-ui.min.js"></script>
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>


    <title>DocsGo</title>
    <link rel="icon" href="<?=base_url()?>/Docsgo-Logo.png" type="image/gif">
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

            <li class="sidebar-dropdown <?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master' || $uri->getSegment(1) == 'documents-acronyms') ? 'active' : null) ?>">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Documents</span>
              </a>
              <div class="sidebar-submenu" style="<?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master' || $uri->getSegment(1) == 'documents-acronyms') ? 'display:block;' : '') ?>">
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
                  <li>
                    <a href="/documents-acronyms">Acronyms</a>
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
            
            <li>
              <a href="/inventory-master">
                <i class="fa fa-dolly-flatbed" style = "<?= ($uri->getSegment(1) == 'inventory-master'   ? 'color:#16c7ff;' : null) ?>"></i>
                <span>Inventory Master</span>
              </a>
            </li>

           
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
    
      

      