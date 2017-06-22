$.ajax({
	url: '/counter.xml',
	dataType: 'xml',
	async: false,
	success: function(data){
		$(data).find("count").each(function(index, ele) {
			var allpv = $(ele).find("allpv").text();
			var alluv = $(ele).find("alluv").text();
			var todaypv = $(ele).find("todaypv").text();
			var todayuv = $(ele).find("todayuv").text();
			document.write("<span class='ct1'>总访问量：<i>"+allpv+"</i> </span><span class='ct2'>总浏览量：<i>"+alluv+"</i> </span><span class='ct3'>今日访问: <i>"+todaypv+"</i> </span><span class='ct4'>今日浏览: <i>"+todayuv+"</i> </span>");
		});
	}
});