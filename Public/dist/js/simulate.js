$(function () {
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

    $(".btn-deal").click(function(){
        $.getJSON("../Api/listd", {'lid': $(this).attr("data-lid")}, function(json){
            $(".table-lid").html(json.ListingId);
            $(".table-amount").html(json.Amount);
            $(".table-months").html(json.Months);
            $(".table-currentrate").html(json.CurrentRate);
            $(".table-auditingtime").html(json.AuditingTime);
            $(".table-creditcode").html(json.CreditCode);
            $(".table-age").html(json.AuditingTime);
        });
    });

    $(".btn-dealcfm").click(function(){
        $.getJSON("../Api/deal", {'lid': $(".table-lid").html()}, function(json){
            if(json.status == 'success'){
                alert("投资成功！");
                $("#modal-deal").modal('hide');
            }
            else{
                alert(json.content);
            };
        });
    });

    var amountDiagram = echarts.init(document.getElementById('amount-diagram'));

    var xAxis1 = [];
    var data1 = [];
    $.getJSON('../api/amount', function (rawData) {
        $.each(rawData, function(i, item){
            data1.push(item['y']);
            xAxis1.push(item['x']);
        });

        var itemStyle = {
            normal: {
            },
            emphasis: {
                barBorderWidth: 1,
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowOffsetY: 0,
                shadowColor: 'rgba(0,0,0,0.5)'
            }
        };

        option = {
            backgroundColor: '#fff',
            legend: {
                data: ['bar'],
                align: 'left',
                left: 10
            },
            brush: {
                toolbox: false,
                xAxisIndex: 0
            },
            toolbox: false,
            tooltip: {},
            xAxis: {
                data: xAxis1,
                name: '借款金额',
                silent: false,
                axisLine: {onZero: true},
                splitLine: {show: false},
                splitArea: {show: false}
            },
            yAxis: {
                name: '借款额度累计',
                inverse: false,
                splitArea: {show: false}
            },
            grid: {
                left: 100
            },
            series: [
                {
                    name: '借款额度累计',
                    type: 'bar',
                    stack: 'one',
                    itemStyle: {
                        normal: {
                            color: '#629dc4'
                        },
                        emphasis: {
                            color: '#48a3e0'
                        }
                    },
                    data: data1
                }
            ]
        };

        amountDiagram.setOption(option);
    });


    var rateDiagram = echarts.init(document.getElementById('rate-diagram'));

    var xAxis2 = [];
    var data2 = [];
    $.getJSON('../api/rate', function (rawData) {
        $.each(rawData, function(i, item){
            data2.push(item['y']);
            xAxis2.push(item['x']);
        });

        var itemStyle = {
            normal: {
            },
            emphasis: {
                barBorderWidth: 1,
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowOffsetY: 0,
                shadowColor: 'rgba(0,0,0,0.5)'
            }
        };

        rateoption = {
            backgroundColor: '#fff',
            legend: {
                data: ['bar'],
                align: 'left',
                left: 10
            },
            toolbox: false,
            tooltip: {},
            xAxis: {
                data: xAxis2,
                name: '借款利率',
                silent: false,
                axisLine: {onZero: true},
                splitLine: {show: false},
                splitArea: {show: false}
            },
            yAxis: {
                name: '借款利率累计',
                inverse: false,
                splitArea: {show: false}
            },
            grid: {
                left: 100
            },
            series: [
                {
                    name: '借款利率累计',
                    type: 'bar',
                    stack: 'one',
                    itemStyle: {
                        normal: {
                            color: '#629dc4'
                        },
                        emphasis: {
                            color: '#48a3e0'
                        }
                    },
                    data: data2
                }
            ]
        };

        rateDiagram.setOption(rateoption);
    });

    var creditDiagram = echarts.init(document.getElementById('credit-diagram'));

    var xAxis3 = [];
    var data3 = [];

    $.getJSON('../api/credit', function (data3) {

        creditoption = {
            backgroundColor: '#fff',

            title: {
                text: '信用评级比例图',
                left: 'center',
                top: 20,
                textStyle: {
                    color: '#333'
                }
            },
            tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['A','B','C','D','E','F']
        },
        series : [
            {
                name: '信用评级',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:data3,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]


        };
        creditDiagram.setOption(creditoption);
    });



});
