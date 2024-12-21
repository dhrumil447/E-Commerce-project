<script>
        // Sidebar toggle functionality
        document.querySelector('.sidebar a.active').onclick = function() {
            var sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
        };

        // Initialize Bootstrap tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>