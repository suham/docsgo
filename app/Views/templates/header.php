<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="/assets/css/bootstrap4-toggle.min.css" />
    <link rel="stylesheet" href="/assets/css/simplemde_v1.11.1.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-select_v1.13.14.min.css" />

    <link rel="stylesheet" href="/assets/css/headerStyle.css">
    
    <!-- For Showing Code Diff  -->
    <link rel="stylesheet" href="/assets/css/github_diff.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/diff2html.min.css" />

    <!-- For Datatables -->
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>

    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
   
    <script type="text/javascript" src="/assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/utilites.js"></script>
    <script type="text/javascript" src="/assets/js/popper.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
 
    <script type="text/javascript" src="/assets/js/bootbox.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript" src="/assets/js/simplemde.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/js/diff2html-ui.min.js"></script>
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>
    <!-- For drawing diagrams feature -->
    <script src="/assets/js/mermaid.min.js"></script>
    <!-- For taskboard drag and drop feature -->
    <link rel="stylesheet" href="/assets/css/jquery-ui_1.12.1.css">
    <script src="/assets/js/jquery-ui.min_1.12.1.js"></script>

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


      .page-content {
        overflow-x: hidden;
      }

      .my_nav_link{
        color:#12192C;
      }

      .my_nav_link:hover{
        color:white;
        text-decoration:none;
      }

      .sidebar-footer{
        position: fixed;
        bottom: 0px;
        padding: 8px;
        width: 210px;
      }

      .sidebar-footer a:hover{
        color:black;
      }

      .collapse__menu li:hover a{
        background-color: white;
        color: black !important;
        border-radius: 10px;
        text-decoration:none;
      }

      .collapse:hover a{
        color:white;
      }

      #loading-overlay {
        position: fixed;
        width: 100%;
        height:100%;
        left: 0;
        top: 0;
        display: none;
        align-items: center;
        background-color: #000;
        z-index: 999;
        opacity: 0.5;
    }

    .loading-icon{ 
        position:absolute;
        margin:0 auto;
        position:absolute;
        left:50%;
        margin-left:-20px;
        top:50%;
        margin-top:-20px;
        z-index:4;
    }
    
    .carousel-control-prev-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23007bff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
    }

    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23007bff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
    }
    
    .carousel-indicators {
      bottom: 30px;
    }

    .carousel-indicators li {
        background-color: #91c6ff;
    }

    .carousel-indicators .active {
        background-color: #007bff;
    }

    .carousel-control-next, .carousel-control-prev {
      top: 50px;  
      bottom: 76px;
    }

    </style>

    <script>
      $(document).ready(function() {
          $.getScript("/assets/js/header.js");

      });
     
    </script>
  </head>
  <body id="body-pd">
    <?php $uri = service('uri'); $currentUrl = $_SERVER['REQUEST_URI'];?>

    <?php if (session()->get('isLoggedIn')): ?>
      <body id="body-pd">



      <div class="l-navbar" id="navbar">
            <nav class="my_nav">
                <div>
                    <div class="nav__brand">
                        <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                        <a href="/projects" class="nav__logo" title="Project Data Reporting Tool" title="DocsGo">
                          <img src="/Docsgo-Logo.png" height="80px" alt="DocsGo">
                        </a>
                    </div>
                    <div class="nav__list">
                        <a href="/projects" title="Projects" class="nav__link my_nav_link <?= ($uri->getSegment(1) == 'projects'  || $uri->getSegment(1) == 'taskboard'  ? 'active-nav-link' : '') ?>">
                          <ion-icon name="folder-outline" class="nav__icon"></ion-icon>
                          <span class="nav__name">Projects</span>
                        </a>
                        <a href="/team" title="Team" class="nav__link my_nav_link <?= ($uri->getSegment(1) == 'team'   ? 'active-nav-link' : '') ?>">
                        <ion-icon  slot="icon-only" name="people-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Team</span>
                    </a>
                    <a href="/reviews" title="Review Register" class="nav__link my_nav_link <?= ($uri->getSegment(1) == 'reviews'   ? 'active-nav-link' : '') ?>">
                        <ion-icon name="eye-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Review Register</span>
                    </a>

                    <div class="nav__link collapse <?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master' || $uri->getSegment(1) == 'documents-acronyms') ? 'active-nav-link' : '')  ?>">
                        <a href="/documents" title="Documents" class="collapse__sublink my_nav_link <?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master' || $uri->getSegment(1) == 'documents-acronyms') ? 'text-light' : '')  ?>"">
                          <ion-icon name="documents-outline" class="nav__icon"></ion-icon>
                        </a>
                        <a href="/documents" title="Documents"  class="my_nav_link <?= (($uri->getSegment(1) == 'documents' || $uri->getSegment(1) == 'documents-templates' || $uri->getSegment(1) == 'documents-master' || $uri->getSegment(1) == 'documents-acronyms') ? 'text-light' : '')  ?>"">Documents</a>

                        <ion-icon name="chevron-down-outline" class="collapse__link"></ion-icon>

                        <ul class="collapse__menu">
                          <li style="padding:6px;"><a style="padding:6px" href="/documents-templates" class="collapse__sublink ">Templates</a></li>
                          <li style="padding:6px;"><a style="padding:6px" href="/documents-master" class="collapse__sublink ">References</a></li>
                          <li style="padding:6px;"><a style="padding:6px" href="/documents-acronyms" class="collapse__sublink ">Acronyms</a></li>
                        </ul>
                    </div>

                    <a href="/diagramsList" title="Draw Diagram" class="nav__link my_nav_link <?= (strpos($currentUrl , 'diagrams')   ? 'active-nav-link' : '') ?>">
                        <ion-icon name="color-palette-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Draw Diagram</span>
                    </a>

                    <a href="/risk-assessment" title="Risk Assessment" 
                      class="nav__link my_nav_link <?= ($uri->getSegment(1) == 'risk-assessment'   ? 'active-nav-link' : '') ?>">
                        <ion-icon name="shield-checkmark-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Risk Assessment</span>
                    </a>
                    <div class="nav__link collapse <?= ((($uri->getSegment(1) == 'requirements') || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'active-nav-link' : '') ?>">
                        <a href="/traceability-matrix" title="Traceability Matrix" class="collapse__sublink my_nav_link <?= ((($uri->getSegment(1) == 'requirements') || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'text-light' : '') ?>">
                          <ion-icon name="apps-outline" class="nav__icon"></ion-icon>
                        </a>
                        <a href="/traceability-matrix" title="Traceability Matrix" class="collapse__sublink my_nav_link <?= ((($uri->getSegment(1) == 'requirements') || $uri->getSegment(1) == 'test-cases' || $uri->getSegment(1) == 'traceability-matrix')  ? 'text-light' : '') ?>">Traceability</a>

                        <ion-icon name="chevron-down-outline" class="collapse__link"></ion-icon>

                        <ul class="collapse__menu">
                            <li style="padding:6px;"><a style="padding:6px" href="/requirements" class="collapse__sublink">Requirements</a></li>
                            <li style="padding:6px;"><a style="padding:6px" href="/test-cases" class="collapse__sublink">Test</a></li>
                        </ul>
                    </div>
                    <a href="/inventory-master" title="Assets"
                      class="nav__link my_nav_link <?= ($uri->getSegment(1) == 'inventory-master'   ? 'active-nav-link' : '') ?>">
                        <ion-icon name="cart-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Assets</span>
                    </a>

                    <a target="_blank" href="/storage/repo" title="Storage"
                      class="nav__link my_nav_link">
                        <ion-icon name="cloud-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Storage</span>
                    </a>
                </div>

                
            </div>
            <a href="/logout" class="nav__link" title="LogOut" id="only-logout">
                    <ion-icon name="log-out-outline" class="nav__icon my_nav_link"></ion-icon>
                    <span class="nav__name">Log Out</span>
            </a>
            <div class="sidebar-footer  d-none" id="footer-icons" >
            <div class="row justify-content-center" >
                  <?php $col="col-6"; if (session()->get('is-admin')): $col="col-4";?>
                  <div class="<?= $col ?>">
                    <a href="/admin/settings"  title="Settings"> 
                      <ion-icon name="settings-outline" style="font-size:1.65rem" class="nav__icon "></ion-icon>
                      
                    </a>
                  </div>
                  <?php endif; ?>
                  <div class="<?= $col ?>">
                    <a href="/profile"  title="My Profile">
                      <ion-icon name="person-circle-outline" style="font-size:1.65rem" class="nav__icon "></ion-icon>
                    </a>
                  </div>
                  <div class="<?= $col ?>">
                    <a href="/logout" title="Log Out">
                      <ion-icon name="log-out-outline" style="font-size:1.65rem" class="nav__icon "></ion-icon>
                    </a>
                  </div>
                </div>
              </div>
               


            </nav>
        </div>

      
      <main class="page-content">
        <div id="loading-overlay">
          <div class="loading-icon"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i></div>
        </div>  
        <div class="floating-alert alert text-light box-shadow-left success-alert" style="display: none;z-index:9999" role="alert"></div>
    <?php endif; ?>
    
      

      