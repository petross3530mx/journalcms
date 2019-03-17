<? class Chart extends Core{
    
    public function getTitle()
    {
            tr::initlang();
            $lang = $_SESSION['lang'];
            return tr::gettranslation(73, $lang);
    }
    
    public function getContent()
    {


$result_content='';




$result_content .='<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>';




$result_content .='<canvas id="myChart" width="800" height="400"></canvas>';


$result_content .='<script>

      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [88, 8888, 777, 7, 8, 888, 7777],
            lineTension: 0,
            backgroundColor: "transparent",
            borderColor: "#007bff",
            borderWidth: 4,
            pointBackgroundColor: "#007bff"
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    
</script>';


      return $result_content;
    }
}
?>


