(function(w, d){
	'use_strict';
    w.onload = function(){
        var holder = d.querySelector("#keyword-filter div.tablenav.top > div.actions");
        var add = d.createElement("a");
            add.href='?page='+seokl.plugin_name+'&action=add';
            add.classList.add("button");
            add.classList.add("button-primary");
            add.style.margin="1px 8px 3px -5px";
            add.innerHTML="Add New";
        if(holder){
            holder.appendChild(add);
        }

		var save_keyword = d.getElementById("add-keyword");
		var update_keyword = d.getElementById("update-keyword");
		var delete_keyword = d.getElementById("delete-keyword");
		var data = {};
		var settings ={}
		if(save_keyword){
			save_keyword.addEventListener("click", function(e){
				e.preventDefault();
				data.keyword = d.getElementById("keyword").value;
				data.target_url = d.getElementById("target_url").value;
				data.post_type = d.getElementById("post_type").value;
				data.specific_pages = d.getElementById("specific_pages").value;
				data.window_tab = d.getElementById("window_tab").value;
				data.rel = d.getElementById("rel").value;
				data.regex = false;
				data.download = false;

				settings.nonce = d.getElementById("seokl-addform-action").value;
				settings.action = "insert_data";
				submit_form(data,settings);
			});
		}

		function submit_form(data=null, settings=null){
			console.log(seokl.ajax_url);
			if(!data || !settings){return false;}
			const xhttp = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                    xhttp.onreadystatechange = function() {
                         if (this.readyState == 4 && this.status == 200) {
                            console.group('Server Request - Success');
                            console.info(this.response);
                            //console.info(this.responseText);
                            console.info(this.status);
                            console.info(this.statusText);
                            console.table(xhttp.getAllResponseHeaders());
                            console.groupEnd();
                        }
                        else if(this.readyState == 4 && this.status != 200)
                        {
                            console.group('Server Request - Error');
                            console.info(this.response);
                            //console.info(this.responseText);
                            console.info(this.status);
                            console.info(this.statusText);
                            console.table(xhttp.getAllResponseHeaders());
                            console.groupEnd();
                        }
                   };

                   xhttp.open('POST', seokl.ajax_url, true);// 'http://'  +  window.location.hostname  + window.location.pathname.replace(/upload.php/,'') + 'admin-ajax.php'
                   xhttp.responseType = 'json';
                   xhttp.setRequestHeader("Accept",'json');
                   xhttp.send(JSON.stringify({data:data, settings:settings}));
		}
    }
})(window, document);
