</main>

</div>

<script>
$( document ).ready(function(){
  function adjustHeight(textareaElement, minHeight) {
        // compute the height difference which is caused by border and outline
        var outerHeight = parseInt(window.getComputedStyle(textareaElement).height, 10);
        var diff = outerHeight - textareaElement.clientHeight;

        // set the height to 0 in case of it has to be shrinked
        textareaElement.style.height = 0;

        // set the correct height
        // textareaElement.scrollHeight is the full height of the content, not just the visible part
        textareaElement.style.height = Math.max(minHeight, textareaElement.scrollHeight + diff) + 'px';
    }

     // we use the "data-adaptheight" attribute as a marker
     var textAreas = [].slice.call(document.querySelectorAll('textarea[data-adaptheight]'));

// iterate through all the textareas on the page
  textAreas.forEach(function(el) {

      // we need box-sizing: border-box, if the textarea has padding
      el.style.boxSizing = el.style.mozBoxSizing = 'border-box';

      // we don't need any scrollbars, do we? :)
      el.style.overflowY = 'hidden';

      // the minimum height initiated through the "rows" attribute
      var minHeight = el.scrollHeight;

      el.addEventListener('input', function() {
          adjustHeight(el, minHeight);
      });

      // we have to readjust when window size changes (e.g. orientation change)
      window.addEventListener('resize', function() {
          adjustHeight(el, minHeight);
      });

      // we adjust height to the initial content
      adjustHeight(el, minHeight);

  });

});
        function goBack() {
        window.history.back();
        }

        $(".sidebar-dropdown > a").click(function() {
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

        $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
        });




</script>
</body>

</html>