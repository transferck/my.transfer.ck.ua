<script>

    $(function() {
        $.getJSON("/charts", function (result) {
            var labels_week = [], data_week = [], data_week_success = [],
                labels_month = [], data_month = [],
                labels_month_s = [], data_month_s = [],
                labels_year = [], data_year = [];

            for (var i = 0; i < result['orders_week'].length; i++) {
                labels_week.push(result['orders_week'][i].day);
                data_week.push(result['orders_week'][i].count);
            }


            var ctx = document.getElementById('chart1');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels_week,
                    datasets: [
                        {
                            data: data_week,
                            label: "Отправлено",
                            borderColor: "#3e95cd",
                            fill: false
                        }, {
                            label: "Завершены",
                            data: data_week_success,
                            backgroundColor: "green",
                            fill: false,
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'За неделю'
                    }
                }
            });


            //Two charts
            for (var i = 0; i < result['orders_month'].length; i++) {
                labels_month.push(result['orders_month'][i].day);
                data_month.push(result['orders_month'][i].count);
            }

            var ctx2 = document.getElementById('chart2');
            var myChart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels_month,
                    datasets: [
                      {
                        data: data_month,
                        label: "Отправлено",
                        borderColor: "#3e95cd",
                        fill: false
                      }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'За месяц'
                    }
                }
            });

            for (var i = 0; i < result['orders_year'].length; i++) {
                labels_year.push(result['orders_year'][i].month);
                data_year.push(result['orders_year'][i].count);
            }
            var ctx3 = document.getElementById('chart3');
            var myChart3 = new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: labels_year,
                    datasets: [{
                        data: data_year,
                        label: "Отправлено",
                        borderColor: "#3e95cd",
                        fill: false
                    }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'За год'
                    }
                }
            });

        });
    });

</script>