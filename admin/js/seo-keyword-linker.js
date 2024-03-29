(function(w, d){
	'use_strict';
    w.onload = function(){
        var holder = d.querySelector("#keyword-filter div.tablenav.top > div.actions");
        var add = d.createElement("a");
            add.href='?page=seo-keyword-linker&action=add';
            add.classList.add("button");
            add.classList.add("button-primary");
            add.style.margin="1px 8px 3px -5px";
            add.innerHTML="Add New";
        if(holder){
            holder.appendChild(add);
        }
		var notice = d.getElementById("seokl-notice");
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
				submit_form(data);
			});
		}

		function submit_form(data=null){
			if(!data){return false;}
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
							notice.querySelector("div").classList.add((this.response["error"] ? "error" : "success")+" notice is-dismissible");
							notice.querySelector("div").innerHTML = "<p>"+this.response["message"]+"</p>";
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
							notice.querySelector("div").classList.add((this.response["error"] ? "error" : "success")+" notice is-dismissible");
							notice.querySelector("div").innerHTML = "<p>"+this.response["message"]+"</p>";
                        }
                   };

                   xhttp.open('POST', ajaxurl, true);// 'http://'  +  window.location.hostname  + window.location.pathname.replace(/upload.php/,'') + 'admin-ajax.php'
                   xhttp.responseType = 'json';
				   xhttp.contentType= "application/x-www-form-urlencoded; charset=UTF-8";
                   xhttp.setRequestHeader("Accept",'json');
				   let formdata = new FormData();
					   formdata.append("data", data);
					   formdata.append("nonce", d.getElementById("seokl-addform-action").value);
					   formdata.append("action", "seokl_crud");
				   xhttp.send(formdata);
                   // xhttp.send(JSON.stringify({data:data, nonce:d.getElementById("seokl-addform-action").value,  action:"seokl_crud"}));
		}
    }
})(window, document);
