<!-- Scripts -->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/jquery.scrolly.min.js"></script>
<script src="../../assets/js/browser.min.js"></script>
<script src="../../assets/js/breakpoints.min.js"></script>
<script src="../../assets/js/util.js"></script>
<script src="../../assets/js/main.js"></script>
<script>
    $(document).ready(function () {

        /* Every time the window is scrolled ... */
        $(window).scroll(function () {

            /* Check the location of each desired element */
            $('.hideme').each(function (i) {

                var bottom_of_object = $(this).offset().top + ($(this).outerHeight()) / 5;
                var bottom_of_window = $(window).scrollTop() + $(window).height();

                /* If the object is completely visible in the window, fade it it */
                if (bottom_of_window > bottom_of_object) {

                    $(this).animate({'opacity': '1'}, 500);

                }

            });

        });

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/ContentTools@1.6.1/build/content-tools.min.js"></script>
<script
	src="https://code.jquery.com/jquery-3.4.1.min.js"
	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	crossorigin="anonymous">
</script>

<script src="../../assets/js/ct-index.js"></script>

</body>
</html>
