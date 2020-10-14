</main>

</div>

<script>
   
   $(document).ready(function () {

      $("#close-sidebar").click(function () {
         console.log('clicked');
         localStorage.setItem("showSidebar", "false");
        
        
      });

      $("#show-sidebar").click(function () {
         console.log('clicked');
         localStorage.setItem("showSidebar", "true");
        
        
      });

     
      var toggleState = localStorage.getItem("showSidebar");
      if(toggleState != null){
         if(toggleState == "false"){
            $(".page-wrapper").removeClass('toggled', 1000);
         }
      }

     

      $('textarea').each(function () {
         var simplemde = new SimpleMDE({
            element: this,
            status: false,
            showIcons: ["code", "table"],
         });
         simplemde.codemirror.refresh();
      });

   });

   function goBack() {
      window.history.back();
   }

   $(".sidebar-dropdown > a").click(function () {
      $(".sidebar-submenu").slideUp(200);
      if (
         $(this)
         .parent()
         .hasClass("active")
      ) {
         $(".sidebar-dropdown").removeClass("active");
         $(this)
            .parent()
            .removeClass("active");
      } else {
         $(".sidebar-dropdown").removeClass("active");
         $(this)
            .next(".sidebar-submenu")
            .slideDown(200);
         $(this)
            .parent()
            .addClass("active");
      }
   });

   $("#close-sidebar").click(function () {
      $(".page-wrapper").removeClass("toggled");
   });
   $("#show-sidebar").click(function () {
      $(".page-wrapper").addClass("toggled");
   });
</script>
</body>

</html>