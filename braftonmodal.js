var opop = (function(){
        
       var create = function(el, cl, attr){
           attr = attr || [];
           var a = document.createElement(el);
           a.className = cl;
           attr.forEach(function(attr){
               for(var prop in attr){
                   a.setAttribute(prop, attr[prop]);
               }
           });
           return a;
       }
       var attach = function(el, event, callback){
           if(document.addEventListener){
                el.addEventListener(event, callback);
           }
           if(document.attachEvent){
               el.attachEvent("on"+event, callback);   
           }


       };
       var mainContainer = create("div", "modal",[
           {
              "style": "padding:25px;position:absolute;zindex:9999;display:block;background:tansparent;"
           }
       ]);

       var contentContainer = create("div", "modal-content",[{
           "style": "width:100%;height:100%",

       }]);
       var closeContainer = create("div", "modal-close",[{
           "style": "position:absolute;top:12.5px;right:12.5px;width:25px;height:25px;color:black;background:white;border-radius:100%;line-height:1.75em;cursor:pointer;text-align:center;font-weight:900"
       }]);
       closeContainer.innerHTML = "X";
       mainContainer.appendChild(contentContainer);
       mainContainer.appendChild(closeContainer);
       attach(closeContainer, "click", function(e){
           e.preventDefault();
           opop.close();
       });

       return {
           center: function(){

               var top = Math.max(window.innerHeight - mainContainer.offsetHeight, 0) / 2;
               var left = Math.max(window.innerWidth - mainContainer.offsetWidth, 0) / 2;
               console.log(top, left, window.scrollY, window.screenX);
               mainContainer.style.top = (top + window.screenY) + "px";
               mainContainer.style.left = (left + window.screenX) + "px";
           },
           open: function(settings){
               console.log(contentContainer);
               contentContainer.innerHTML = "";

               if(settings.url){ //for iframe
                   contentContainer.appendChild(create("iframe", "modal-frame", 
                        [{
                          "src": settings.url                    
                        },
                        {
                           "width": "100%"
                        },
                        {
                            "height": "100%"
                        }]
                   ));
               }else{
                   contentContainer.innerHTML = settings.content;            

               }

               mainContainer.style.width = settings.width || "auto";
               mainContainer.style.height = settings.height || "auto";

               document.getElementsByTagName("body")[0].appendChild(mainContainer);

               opop.center();

               attach(window, "resize", opop.center);
           },
           close: function(){
               contentContainer.innerHTML = "";
               if(mainContainer.remove){
                   mainContainer.remove();
               }else{
                   mainContainer.removeNode(true);
               }


               window.removeEventListener("resize", opop.center);
           }
       };
    }());
