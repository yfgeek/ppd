$(function(){
    $(".loadingsb").show();
    $.getJSON("../api/ppdbalance",function(result){
        if(result.Balance){
            html = '';
            color = ['green','blue','orange','red','purple','grey','black','blue','green','yellow','red','orange'];
            $.each(result.Balance, function(i, item){
                category = item.AccountCategory.replace('.', "<br/>");
                html = html + '<div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box"><span class="info-box-icon bg-' + color[i] +'"><i class="fa fa-cny"></i></span><div class="info-box-content"><span class="info-box-text">' + category + '</span><span class="info-box-number ppd-balance">' + item.Balance + '</span></div></div></div>';
            });
            $(".info-balance").html(html);
        }
    });




    $.getJSON("../api/bid",function(result){
        $(".zhcon").html("");
        $.each(result.LoanInfos, function(i, item){
            var str = "<tr class='list"  + item.ListingId + "' data-amount='" + item.Amount + "' data-months='"+ item.Months +"' data-code='" + item.CreditCode + "' data-rate='" + item.Rate + "'><td>"+ item.ListingId +"</td><td>" + item.Amount + "</td><td>" +item.Months+ "</td><td>"+item.Rate + "%</td><td>" +item.CreditCode+ "</td><td><button type='button' class='btn btn-block btn-success btn-sm btn-real-analysis' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-real-analysis' >分析</button></td><td><button type='button' class='btn btn-block btn-info btn-sm btn-realdeal' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-realdeal' >投资</button></td></tr>";
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

        $("body").delegate('.btn-real-analysis','click', function () {
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
                $.each(rawData, function(i, item){
                    data1.push(item['y']);
                    xAxis1.push(item['x']);
                });

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
                            data: data1,
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


            $.getJSON('../api/rate', function (rawData) {
                // $.each(rawData, function(i, item){
                //     data2.push(item['y']);
                //     xAxis2.push(item['x']);
                //     if(item['x']==rate){
                //         ynow = item['y'];
                //         xnow = i;
                //     }
                // });
                // $(".list-ratetotal").html(rate+"%");

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

        $('#modal-real-analysis').on('hide.bs.modal', function () {
            $(".sp-hz").html("分析中...");
            $(".bg-ay").removeClass("bg-blue");
            $(".bg-ay").removeClass("bg-green");
        });

        $("body").delegate('.btn-realdeal','click', function () {
            $.getJSON("../Api/bidd", {'lid': $(this).attr("data-lid")}, function(json){
                $(".table-lid").html(json.LoanInfos[0].ListingId);
                $(".table-amount").html(json.LoanInfos[0].Amount);
                $(".table-months").html(json.LoanInfos[0].Months);
                $(".table-currentrate").html(json.LoanInfos[0].CurrentRate);
                $(".table-deadlinetime").html(json.LoanInfos[0].DeadLineTimeOrRemindTimeStr);
                $(".table-creditcode").html(json.LoanInfos[0].CreditCode);
                $(".table-age").html(json.LoanInfos[0].Age);
                $(".table-educatiodegree").html(json.LoanInfos[0].EducationDegree);
                $(".table-graduateschool").html(json.LoanInfos[0].GraduateSchool);
                $(".table-borrowname").html(json.LoanInfos[0].BorrowName);
                if(json.LoanInfos[0].Gender == 1){$(".table-gender").html("男")}
                else{$(".table-gender").html("女")}

            });
        });

        $("body").delegate('.btn-cfm-realdeal','click', function () {
                var coupon = false;
            if($(".input-coupon").val()=="yes"){
                    coupon = true;
            }
            $.getJSON("../Api/realdeal", {'lid': $(".table-lid").html(),'amount': $(".input-share").val(),'coupon': coupon}, function(json){
                if(json.Result==0){
                    alert("投资成功！");
                    $("#modal-realdeal").modal('hide');
                    location.reload();
                }else{
                    if(json.ResultMessage){
                        alert(json.ResultMessage);
                    }else{
                        alert("投资遇到错误：请到设置中心重新授权拍拍贷用户");
                    }

                }
            });
        });

    });



});
