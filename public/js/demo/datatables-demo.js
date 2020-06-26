// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "stateSave": true,
    "pageLength": 10,
    "order": [[ 0, "desc" ]]
  });
});
