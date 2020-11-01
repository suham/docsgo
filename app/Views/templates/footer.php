

</main>

<script>
   $(document).ready(function () {

      $('textarea').each(function () {
         var simplemde = new SimpleMDE({
            element: this,
            status: [{
                     className: "characters",
                     defaultValue: function(el) {
                        el.innerHTML = "0";
                     },
                     onUpdate: function(el) {
                        el.innerHTML = simplemde.value().length;
                     }
                  }],
            showIcons: ["code", "table"],
         });
         simplemde.codemirror.refresh();
      });

   });

   function goBack() {
      window.history.back();
   }

</script>
<script type="text/javascript" src="/assets/js/header.js"></script>
</body>

</html>