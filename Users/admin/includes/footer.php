<footer class="bottom-footer">
    <div class="footer-copyright text-center">© 2020 Copyright:
        <a href="#"> MDBootstrap.com</a>
    </div>
    <!-- Copyright -->
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $.datepicker.setDefaults({
            dateFormat: 'yy-mm-dd'
        });
        $(function() {
            $("#from_date").datepicker({
                changeMonth: true,
                changeYear: true,
                minDate: '-3M 0D',
                maxDate: '0D'

            });
            $("#to_date").datepicker({
                changeYear: true,
                changeMonth: true,
                minDate: '-3M 0D',
                maxDate: '0D',
                yearRange: "-100:+20",
            });
        });
        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $.ajax({
                    url: "./filter.php",
                    method: "POST",
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(data) {
                        $('#order_table').html(data);
                    }
                });
            } else {
                alert("Please Select Date");
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.tables').DataTable({
            "pageLength": 30
        });
    });
</script>

</body>

</html>