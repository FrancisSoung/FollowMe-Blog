		function show(){
		
			$(".main").fadeTo("2000",0);
			$(".main1").fadeTo("2000",1);
		}

		function show2(){
			$(".main1").fadeTo("2000",0);
			$(".main").fadeTo("2000",1);
			$(".main1").css("display","none");
			

		}
                setInterval(function(){
			im++;
			if(im>20){
				im=1;
			}
          		$(".img").fadeTo("2000", 0);
			$(".img").attr("src","../images/loginimg/"+im+".jpg");
			$(".img").fadeTo("2000", 1);
		},5000);
