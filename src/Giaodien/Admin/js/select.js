
<script>
$(document).ready(function() {
    // Initialize Select2 with tags enabled
    $('.select-search').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function (params) {
            return undefined;
        },
        maximumSelectionLength: 1,
    })
});
</script>