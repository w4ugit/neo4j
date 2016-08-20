(function($){
	var Renderer = function(canvas)
	{
		var canvas = $(canvas).get(0);
		var ctx = canvas.getContext("2d");
		var particleSystem;

		var that = {
			init:function(system){
				//начальная инициализация
				particleSystem = system;
				particleSystem.screenSize(canvas.width, canvas.height); 
				particleSystem.screenPadding(80);
			},

			redraw:function(){
				//действия при перересовке
				ctx.fillStyle = "white";	//белым цветом
				ctx.fillRect(0,0, canvas.width, canvas.height); //закрашиваем всю область

				particleSystem.eachEdge(	//отрисуем каждую грань
					function(edge, pt1, pt2){	//будем работать с гранями и точками её начала и конца
						ctx.strokeStyle = "rgba(0,0,0, 1)";	//грани будут чёрным цветом с некой прозрачностью
						ctx.lineWidth = 1;	//толщиной в один пиксель
						ctx.beginPath();		//начинаем рисовать
						ctx.moveTo(pt1.x, pt1.y); //от точки один
						ctx.lineTo(pt2.x, pt2.y); //до точки два
						ctx.stroke();
				});

				particleSystem.eachNode(	//теперь каждую вершину
					function(node, pt){		//получаем вершину и точку где она
						var w = 20;			//ширина квадрата
						ctx.fillStyle = node.data.color;
						ctx.beginPath();
						ctx.arc(pt.x-w/2, pt.y-w/2, 20, 0, 2 * Math.PI);
						ctx.fill();
						ctx.stroke();
						ctx.fillStyle = "black";	//цвет для шрифта
						ctx.font = 'italic 13px sans-serif'; //шрифт
						ctx.fillText (node.name, pt.x-20, pt.y-4); //пишем имя у каждой точки
				});
			},

      
		}
		return that;
	}    

	$("#go").click(function () {
		sys = arbor.ParticleSystem(1000); // создаём систему
		sys.parameters(); // гравитация вкл
		sys.renderer = Renderer("#viewport") //начинаем рисовать в выбраной области

		$.ajax({
			url: '/ajax.php',
			type: 'post',
			data: {flag: 'all'},
			success: function (res) {
				data=JSON.parse(res);
				$.each(data.nodes, function(i,node){
					sys.addNode(node.name, node);	//добавляем вершину
				});

				$.each(data.edges, function(i,edge){
					sys.addEdge(sys.getNode(edge.src),sys.getNode(edge.dest));	//добавляем грань
				});
			}
		});
	});

	$("#search").click(function () {
		var node=$("input[name=node]").val();
			$.ajax({
				url: '/ajax.php',
				type: 'post',
				data: {flag: 'search', node: node},
				success: function (res) {
					alert("Результат: "+res);
				}
			})
	});

})(this.jQuery)
