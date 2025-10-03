<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<!-- DataTables Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  $('.datatable').each(function() {
    if ( $.fn.dataTable.isDataTable(this) ) {
      $(this).DataTable().destroy();
    }
    $(this).DataTable({
      paging: true,
      searching: true,
      ordering: false,
      responsive: true,
      info: false,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        emptyTable: "No hay registros."
      },
      dom: '<"top"f>rt<"bottom"lp><"clear">',
      initComplete: function() {
        $(this).css('visibility', 'visible');
      }
    });
  });
});
</script>