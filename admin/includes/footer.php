  </div>
  <!-- /#wrapper -->



  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <!-- WYSIWYG Editor -->
  <script src="http://cloud.tinymce.com/stable/tinymce.min.js"></script>

  <!-- Dropzone.js -->
  <script type="text/javascript" src="js/dropzone.js"></script>
  
  <script type="text/javascript" src="js/scripts.js"></script>

  <!-- Pie Chart code -->

  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Views',       <?php echo $session->count; ?>],
        ['Comments',    <?php echo Comment::count_all(); ?>],
        ['Users',       <?php echo User::count_all(); ?>],
        ['Photos',      <?php echo Photo::count_all(); ?>]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'My Daily Activities',
        backgroundColor: 'transparent'

      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>

</body>

</html>
