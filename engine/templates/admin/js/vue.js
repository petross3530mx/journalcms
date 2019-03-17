window.onload = function () {
new Vue ({
	el: '#example',
	data:{

	},
	computed:{
		summ:function () {
		      // `this` points to the vm instance
		      return 10;
		    }
	}
})
}