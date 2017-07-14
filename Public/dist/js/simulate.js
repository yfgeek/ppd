$(function () {

    $("body").delegate('.btn-deal','click', function () {
        $.getJSON("../Api/listd", {'lid': $(this).attr("data-lid")}, function(json){
            $(".table-lid").html(json.ListingId);
            $(".table-amount").html(json.Amount);
            $(".table-months").html(json.Months);
            $(".table-currentrate").html(json.CurrentRate);
            $(".table-auditingtime").html(json.AuditingTime);
            $(".table-creditcode").html(json.CreditCode);
            $(".table-age").html(json.Age);
        });
    });

    $(".btn-dealcfm").click(function(){
        var lid = $(".table-lid").html();
        var share = $(".input-share").val();
        if(lid!="" && share!=""){
            $.getJSON("../Api/deal", {'lid': lid, 'share': share}, function(json){
                if(json.status == 'success'){
                    alert("投资成功！");
                    $("#modal-deal").modal('hide');
                    location.reload();
                }
                else{
                    alert(json.content);
                };
            });
        }else{
            alert("请填写金额~");
        }

    });

    // 如此写法可以修复翻页bug
    $("body").delegate('.btn-analysis','click', function () {
        // 传递数据
        var lid = $(this).attr("data-lid");
        var amount =  parseInt($(".list" + lid).attr("data-amount") / 1000);
        var rate =  parseInt($(".list" + lid).attr("data-rate")); // 暂时无解，可用解决方案：隐藏域，但是不太好，我觉得
        var name = $(".list" + lid).attr("data-code");

        //数据预测
        $.getJSON("../Api/beyes", {'lid': lid}, function(json){
            if(json.status == 'true'){
                $(".bg-ay").addClass("bg-blue");
                $(".sp-hz").html("存在一定风险");
            }
            else{
                $(".bg-ay").addClass("bg-green");
                $(".sp-hz").html("推荐买入");
            };
        });

        $(".list-lid").html(lid);
        $(".list-amount").html($(".list" + lid).attr("data-amount"));
        $(".list-rate").html(rate+'%');
        $(".list-credit").html(name);


        var amountDiagram = echarts.init(document.getElementById('amount-diagram'));

        var xAxis1 = [];
        var data1 = [];
        $.getJSON('../api/amount', function (rawData) {
            var amoutpercent = 0;
            $.each(rawData, function(i, item){
                data1.push(item['y']);
                if(Number(data1[amount]) > Number(item['y'])){
                    amoutpercent = amoutpercent + Number(item['y']);
                }
                xAxis1.push(item['x']);
            });

            $(".list-jb-amount").html(amoutpercent.toFixed(2)+"%");

            $(".list-amounttotal").html(data1[amount]+"%");

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
                    text: '当前借款额度所占总数百分比',
                    subtext: '反应当前标的借款额度在历史中的数据分布',
                    left: 'center',
                    top: 0,
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
                    name: '借款金额(￥)',
                    silent: false,
                    axisLine: {onZero: true},
                    splitLine: {show: false},
                    splitArea: {show: false}
                },
                yAxis: {
                    name: '借款额度累计比率(%)',
                    inverse: false,
                    splitArea: {show: false}
                },
                grid: {
                    left: 100
                },
                series: [
                    {
                        name: '借款额度累计比率(%)',
                        type: 'bar',
                        stack: 'one',
                        itemStyle: {
                            normal: {
                                color: '#629dc4'
                            },
                            emphasis: {
                                color: '#3f51b5'
                            }
                        },
                        data: data1 ,
                        markPoint:{
                            data: [{name:'当前借款金额: '+ $(".list" + lid).attr("data-amount") ,xAxis: amount,yAxis: data1[amount]}]
                        },
                        markLine: {
                            data: [
                                {type: 'average', name: '平均值'}
                            ]
                        }
                    }
                ]
            };

            amountDiagram.setOption(option);
            amountDiagram.dispatchAction({
                type: 'highlight',
                dataIndex: amount
            });
        });


        var rateDiagram = echarts.init(document.getElementById('rate-diagram'));
        var data2 = [];
        var xzhou = [];
        $.getJSON('../api/rate', function (rawData) {
            var ratepercent = 0;
            var sum = 0;
            $.each(rawData, function(i, item){
                data2.push(item['value']);
                sum = sum +  Number(item['value']);
                xzhou.push(item['name']);
            });
            var currentdata = data2[i]/sum*100;
            var k = 0;
            for(var i=0; i< xzhou.length; i++){
                console.log(xzhou[i]);
                if(Number(rate) == Number(xzhou[i])){
                    k = i;
                }
            }
            for(var i = 0; i < data2.length; i++){
                // console.log(data2[i]);

                if(Number(data2[k]) > Number(data2[i])){
                    var currentdata = data2[i]/sum*100;
                    ratepercent = ratepercent + Number(currentdata);
                }
            }
            $(".list-jb-rate").html(ratepercent.toFixed(2)+"%");


            rateoption = {
                    backgroundColor: '#fff',

                    title: {
                        text: '当前借款利率所占总数百分比',
                        subtext: '反应当前标的借款利率在历史中的数据分布',
                        left: 'center',
                        top: 0,
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
                        data: rawData.name
                    },
                    series : [
                        {
                            name: '借款利率所占总数百分比',
                            type: 'pie',
                            radius : '50%',
                            data: rawData,
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
                rateDiagram.setOption(rateoption);
                rateDiagram.dispatchAction({
                    type: 'highlight',
                    name: rate.toString(),
                });


        //     var itemStyle = {
        //         normal: {
        //         },
        //         emphasis: {
        //             barBorderWidth: 1,
        //             shadowBlur: 10,
        //             shadowOffsetX: 0,
        //             shadowOffsetY: 0,
        //             shadowColor: 'rgba(0,0,0,0.5)'
        //         }
        //     };
        //
        //     rateoption = {
        //         title: {
        //             text: '当前借款利率所占总数百分比',
        //             left: 'center',
        //             top: 20,
        //             textStyle: {
        //                 color: '#333'
        //             }
        //         },
        //         backgroundColor: '#fff',
        //         legend: {
        //             data: ['bar'],
        //             align: 'left',
        //             left: 10
        //         },
        //         toolbox: false,
        //         tooltip: {},
        //         xAxis: {
        //             data: xAxis2,
        //             name: '借款利率(%)',
        //             silent: false,
        //             axisLine: {onZero: true},
        //             splitLine: {show: false},
        //             splitArea: {show: false}
        //         },
        //         yAxis: {
        //             name: '借款利率累计比率(%)',
        //             inverse: false,
        //             splitArea: {show: false}
        //         },
        //         grid: {
        //             left: 100
        //         },
        //         series: [
        //             {
        //                 name: '借款利率累计比率(%)',
        //                 type: 'bar',
        //                 stack: 'one',
        //                 itemStyle: {
        //                     normal: {
        //                         color: '#629dc4'
        //                     },
        //                     emphasis: {
        //                         color: '#3f51b5'
        //                     }
        //                 },
        //                 data: data2,
        //                 markPoint:{
        //                     data: [{name:'当前借款利率: ' + rate +'%' ,xAxis: xnow ,yAxis: ynow}]
        //                 },
        //                 markLine: {
        //                     data: [
        //                         {type: 'average', name: '平均值'}
        //                     ]
        //                 }
        //             }
        //         ]
        //     };
        //
        //     rateDiagram.setOption(rateoption);
        //     rateDiagram.dispatchAction({
        //         type: 'highlight',
        //         dataIndex: xnow
        //     });
        //
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
                    subtext: '反应当前标的信用评级在历史中的数据分布',
                    left: 'center',
                    top: 0,
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
                        markPoint:{
                            data: [{name:'当前信用评级: ' + name ,name: name }]
                        },
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
            creditDiagram.dispatchAction({
                type: 'highlight',
                name: name
            });
        });








    });
    $('#modal-analysis').on('hide.bs.modal', function () {
        $(".sp-hz").html("分析中...");
        $(".bg-ay").removeClass("bg-blue");
        $(".bg-ay").removeClass("bg-green");
    });


});
