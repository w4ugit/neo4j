<!DOCTYPE html>
<html>
<head>
    <title>Built-in Layouts</title>
    <meta charset="utf-8">
    <link href="/css/examples-offline.css" rel="stylesheet">
    <link href="/css/kendo.common.min.css" rel="stylesheet">
    <link href="/css/kendo.rtl.min.css" rel="stylesheet">
    <link href="/css/kendo.default.min.css" rel="stylesheet">
    <link href="/css/kendo.dataviz.min.css" rel="stylesheet">
    <link href="/css/kendo.dataviz.default.min.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jszip.min.js"></script>
    <script src="/js/kendo.all.min.js"></script>
    <script>

    </script>


</head>
<body>
<div id="example">

    <div id="diagram"></div>
    <script>
        $(function () {
            $.ajax({
                url: '/ajax.php',
                type: 'post',
                data: {'flag': 'all-2'},
                success: function (res) {
                    var data=JSON.parse(res);
                    $("#diagram").kendoDiagram({
                        layout: {
                            type: "layered",
                            wrap: false
                        },
                        shapes: data.shapes,
                        connections: data.connect
                    });
                }
            })
        })
    </script>
</div>



</body>
</html>
