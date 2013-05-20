var secDuration = 10,
image = 1,
maxImages = 3,
slider = document.getElementById('slider'),
timeout;

$(function(){
		
		$('#username').focus();
		
		try{
				localStorage.clear();
		} catch( ex ) {}
	
		$('#subscribe').click(function () {
				$.facebox({
						ajax: url_script+'subscribe'
				});
		});

		$('#mdp').click(function () {
				$.facebox({
						ajax: url_script+'mdp'
				});
		});
		
		changeImage(1);
		
});
      
function changeImage(requiredImage) {

		if (!requiredImage && requiredImage != 0)
		{ 
				if(image < maxImages){
						image++;
				}
				else{
						image = 1;
				}
		}
		else{ 
				if(requiredImage > maxImages){
						image = 1;
				}
				else if(requiredImage < 1){
						image = maxImages;
				}
				else{
						image = requiredImage;
				}
		}

		slider.className = "image"+image;
        
		clearTimeout(timeout);
		timeout = setTimeout("changeImage()",secDuration*1000);
}