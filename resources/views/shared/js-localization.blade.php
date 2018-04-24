<script type="text/javascript">
$(document).ready(function() {
    $('#lang').on('change', function() {
        var getLang = $(this).val();
        window.location.href = getLang;
    });
});
</script>