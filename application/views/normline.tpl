<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>lineChart</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--
    <link href="/static/bootstrap/datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="/static/bootstrap/datepicker/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet">
    -->
    <link href="/static/bootstrap/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <!--banner -->
    <{include file="common/banner.tpl" }>
    <!--/banner-->
    <div class="row">
        <!--slidebar-->
        <{include file="common/slidebar.tpl"}>
        <!--/slidebar-->
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="/norm/normDetail?normId=<{$info.id}>">List</a></li>
                            </ul>
                        </div>
                        <h4><{$info.name}><small> 折线图</small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <form action="/norm/lineChart?normId=<{$info.id}>" name="lineChart" method="post" id="lineFm">
                        <div class="input-group input-daterange">
                            <input type="text" name="beginDay" value="<{$beginDay}>" class="form-control" id="beginDay" data-date-format="yyyy-mm-dd"/>
                            <div class="input-group-addon">to</div>
                            <input type="text" name="endDay"  value="<{$endDay}>" class="form-control" id="endDay" data-date-format="yyyy-mm-dd" />
                        </div>
                    </form>
                </div>
                <div class="col-xs-5">
                    <button class="btn btn-primary" id="submitLine">筛选</button>
                    &nbsp&nbsp&nbsp&nbsp
                    <span class="text-justify"> *最大时间区间不得超过5天</span>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12" >
                    <div id="lineChart" style="height:450px;">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/echarts.min.js"></script>
<script src="/static/js/common.js"></script>
<!--
<script src="/static/bootstrap/datepicker/js/bootstrap-datepicker.min.js"></script>
-->
<script src="/static/bootstrap/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
    //控制日期选择区间
  $(function(){
        //最大时间区间
        var maxDiff = 4;
        var current = new Date();
        var currentStamp = Date.parse(current)/1000;
        var endTime;
        var newDate = new Date();
        $("#beginDay").datetimepicker(
            {
                minView:'month',
                endDate:current,
                autoclose:true,
            }
        ).on("changeDate",function(e){});

        $("#endDay").datetimepicker(
            {
                minView:'month',
                endDate:current,
                autoclose:true,
            }
        ).on("changeDate",function(e){})
  })

//控制筛选表单提交
$(function(){
    $("#submitLine").click(function(){
        var maxDiff = 5;
        var beginDay = $('#beginDay').val();
        var endDay = $('#endDay').val();

        if(!beginDay) {
            myAlert('请选择起始日期');
            return false;
        }

        if(!endDay) {
            myAlert('请选择截止日期');
            return false;
        }
        if(Date.parse(endDay) < Date.parse(beginDay)){
            myAlert('截止日期必须大于等于起始日期')
            return false;
        }

        if(Date.parse(endDay) - Date.parse(beginDay) > (maxDiff-1) * 24 * 3600 * 1000){
            myAlert('最大时间区间为'+maxDiff+'天');
            return false;
        }

        $("#lineFm").submit();
    })
})

    <{if $haveData}>
    //控制图表展示
    $(function(){
        var formatTime = function (value, index) {
            var date = new Date(value);
            var texts = [date.getHours(), date.getMinutes(),date.getSeconds()];
            return texts.join(':');
        };

// 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('lineChart'));

// 指定图表的配置项和数据
        var option = {
            title : {
                text : '',
                subtext : '单位：<{$info.unitShow}>'
            },
            tooltip : {
                trigger: 'item',
                formatter : function (params) {
                    var date = new Date(params.value[0]);
                    data = date.getHours() + ':'
                        + date.getMinutes() + ':'
                        + date.getSeconds();
                    return data + '<br/>'
                        + params.value[1] ;
                },
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            dataZoom: [
                {
                    type:'inside',
                    show: true,
                    start : <{$zoomStart}>,
                },
                {
                    type:'slider',
                    show: true,
                    start : 90,
                    labelFormatter:formatTime
                }

            ],
            legend : {
                data : <{$legend}>
            },
            grid : {
                left:'6%',
                right:'10%',
            },
            xAxis : [
                {
                    type : 'time',
                    axisLabel: {
                        formatter:formatTime
                    },
                    splitNumber : 15,
                    //minInterval : 5 * 60 * 1000,
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series :<{if $lineStr}><{$lineStr}><{/if}>
        };

// 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    })
    <{/if}>

</script>
</html>