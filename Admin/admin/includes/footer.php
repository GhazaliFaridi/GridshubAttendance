<footer class="bottom-footer">
    <div class="footer-copyright text-center">© 2020 Copyright:
        <a href="#"> MDBootstrap.com</a>
    </div>
    <!-- Copyright -->
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<script>
    function formToggle(ID) {
        var element = document.getElementById(ID);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable({
            "pageLength": 20
        });
    });
</script>

</body>

</html>