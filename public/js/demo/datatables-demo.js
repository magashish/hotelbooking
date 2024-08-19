$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)' // Reorder based on the second column
        }
    });
});
