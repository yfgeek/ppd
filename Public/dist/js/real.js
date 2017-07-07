$(function(){
    $(".loadingsb").show();

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
            title: {
                text: '借款额度累计图',
                left: 'center',
                top: 20,
                textStyle: {
                    color: '#333'
                }
            },
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
                            color: '#03a9f4'
                        }
                    },
                    data: data1,
                    markLine: {
                        data: [
                            {type: 'average', name: '平均值'}
                        ]
                    }
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
            title: {
                text: '借款利率累计图',
                left: 'center',
                top: 20,
                textStyle: {
                    color: '#333'
                }
            },
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
                            color: '#03a9f4'
                        }
                    },
                    data: data2,
                    markLine: {
                        data: [
                            {type: 'average', name: '平均值'}
                        ]
                    }
                }
            ]
        };

        rateDiagram.setOption(rateoption);
    });

    var creditDiagram = echarts.init(document.getElementById('credit-diagram'));

    var xAxis3 = [];

    var data3json = $.ajax({url : '../api/credit'});
    var data4json = $.ajax({url : '../api/creditratio'});

    $.when(data3json, data4json).done(function(){
        creditoption = {
            backgroundColor: '#fff',

            title: {
                text: '信用评级与历史正常还款比例图',
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
                    radius : '50%',
                    center: ['30%', '50%'],
                    data:data3json.responseJSON,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                },{
                    name: '历史正常还款比例',
                    type: 'pie',
                    radius : '50%',
                    center: ['80%', '50%'],
                    data:data4json.responseJSON,
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
    $.getJSON("../api/bid",function(result){
        $(".zhcon").html("");
        $.each(result.LoanInfos, function(i, item){
            var str = "<tr class='list"  + item.ListingId + "' data-amount='" + item.Amount + "' data-months='"+ item.Months +"' data-code='" + item.CreditCode + "'><td>"+ item.ListingId +"</td><td>" + item.Amount + "</td><td>" +item.Months+ "</td><td>"+item.Rate + "%</td><td>" +item.CreditCode+ "</td><td><button type='button' class='btn btn-block btn-success btn-sm btn-real-analysis' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-real-analysis' >分析</button></td><td><button type='button' class='btn btn-block btn-info btn-sm btn-realdeal' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-realdeal' >投资</button></td></tr>";
            $(".zhcon").append(str);
        });
        $(".loadingsb").hide();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false
        });
        $('.btn-real-analysis').on('click', function() {
            var lid = $(this).attr("data-lid");
            var amount =  parseInt($(".list" + lid).attr("data-amount") / 1000);
            var rate =  parseInt($(".list" + lid).attr("data-rate")); // 暂时无解，可用解决方案：隐藏域，但是不太好，我觉得

            var name = $(".list" + lid).attr("data-code");
            //数据预测
            //$Amount,$Age,$PhoneValidate,$NciicIdentityCheck,$VideoValidate,$EducateValidate,$CreditValidate,$Gender,$CreditCode
            $.getJSON("../Api/bidd", {'lid': $(this).attr("data-lid")}, function(json){
                $.getJSON("../Api/mbeyes", {'Amount': json.LoanInfos[0].Amount,'Age':json.LoanInfos[0].Age,'PhoneValidate': json.LoanInfos[0].PhoneValidate,'NciicIdentityCheck': json.LoanInfos[0].NciicIdentityCheck, 'VideoValidate': json.LoanInfos[0].VideoValidate,'EducateValidate': json.LoanInfos[0].EducateValidate, 'CreditValidate': json.LoanInfos[0].CreditValidate, 'Gender': json.LoanInfos[0].Gender,'CreditCode': json.LoanInfos[0].CreditCode}, function(item){
                    if(item.status == 'true'){
                        $(".bg-ay").addClass("bg-blue");
                        $(".sp-hz").html("存在一定风险");
                    }
                    else{
                        $(".bg-ay").addClass("bg-green");
                        $(".sp-hz").html("推荐买入");
                    };
                });

            });



            creditDiagram.dispatchAction({
                type: 'highlight',
                name: name
            });

            amountDiagram.dispatchAction({
                type: 'highlight',
                dataIndex: amount
            });

            rateDiagram.dispatchAction({
                type: 'highlight',
                name: rate
            });

        });

        $('#modal-real-analysis').on('hide.bs.modal', function () {
            $(".sp-hz").html("分析中...");
            $(".bg-ay").removeClass("bg-blue");
            $(".bg-ay").removeClass("bg-green");
            creditDiagram.setOption(creditoption,true);
            amountDiagram.setOption(option,true);
            rateDiagram.setOption(rateoption,true);
        });

        $(".btn-realdeal").click(function(){
            $.getJSON("../Api/bidd", {'lid': $(this).attr("data-lid")}, function(json){
                 $(".table-lid").html(json.LoanInfos[0].ListingId);
                 $(".table-amount").html(json.LoanInfos[0].Amount);
                 $(".table-months").html(json.LoanInfos[0].Months);
                 $(".table-currentrate").html(json.LoanInfos[0].CurrentRate);
                 $(".table-auditingtime").html(json.LoanInfos[0].AuditingTime);
                 $(".table-creditcode").html(json.LoanInfos[0].CreditCode);
                 $(".table-age").html(json.LoanInfos[0].Age);
                 $(".table-educatiodegree").html(json.LoanInfos[0].EducationDegree);
                 $(".table-graduateschool").html(json.LoanInfos[0].GraduateSchool);
                 $(".table-borrowname").html(json.LoanInfos[0].BorrowName);
                 if(json.LoanInfos[0].Gender == 1){$(".table-gender").html("男")}
                 else{$(".table-gender").html("女")}

            });
        });
    });



});
