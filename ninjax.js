var njaxChange = new MutationObserver(function(e){
    /*if(njaxSelectors.hasOwnProperty(0)){
        console.log(njaxSelectors);
    }*/
});
njaxChange.observe(document.body, {attributes: true,subtree: true,childList: true,characterData: true});
(function(){
    window.addEventListener('popstate', function(e){
        /*new ninjax.ajax(e.state.to)*/
        console.log(e.state.url);
        var selector = e.state.tag;
        document.querySelectorAll(selector).forEach(function(item){
            if(item.textContent===e.state.text){
                selector = item
            };
        });
        ninjax.ajax(e.state.url, selector, e.state.to, true);
    });
    document.head.insertAdjacentHTML('beforeend','<style id="njaxCSS">.njax-wrap{background-color: rgba(255,255,255,.6);position: absolute;}.njax-load{position:absolute;left:50%;top:50%;margin-left:-20px;margin-top:-20px;border-radius:100%;position:absolute;width:40px;height:40px;border: 6px solid #999;border-left-color: transparent;animation:loader 1s linear infinite;}@keyframes loader{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}</style>');
})();

class ninjax {
    constructor(items, to){
        var _this = this;
        if(typeof items==='string' && !to){
            return console.warn('Set .targetChange to changes.\n Ex.:\n new ninjax(".selector", ".targetChange");');
        }
        if(typeof items==='string'){
            _this._$(items).forEach(function(tag){
                var event = tag.tagName==='FORM' ? 'submit' : 'click';
                _this.listener(tag, event);
                /*DOM Observer*/
                /*njaxSelectors[njaxIndex++] = {tag: tag,event: event, seletor: items};*/
            });
        } else {
            if(!items.tag || !items.to){
                return console.warn('Set one Object with keys "tag" and "to".\n Ex.:\n new ninjax({\n\ttag: ".selector",\n\tto: ".targetChange"\n});');
            }
            _this._$(items.tag).forEach(function(tag){
                var event = tag.tagName==='FORM' ? 'submit' : 'click';
                _this.listener(tag, event);
            });
        }
        return _this.to = to || items.to;
    }
    _$(tag) {
        return document.querySelectorAll(tag);
    }
    listener(tag, event){
        var _this = this;
        tag.addEventListener(event, function(e){
            e.preventDefault();
            if(event==='click'){
                var link = tag.search.replace('?','');
                ninjax.ajax(location.pathname+'?'+link, tag, _this.to);
            } else {
                var url = [];
                tag.querySelectorAll('input, select, textarea').forEach(function(input, i){
                    if (input.value.trim() === '' || (input.type==='checkbox' && !input.checked) || (input.type==='radio' && !input.checked)) {
                        return;
                    }
                    url.push(input.name+'='+input.value);
                });
                ninjax.ajax(location.pathname+'?'+url.join('&'), tag, _this.to);
            }
        });
    }
    static ajax(url, tag, to, popstate){
        var xhr = new XMLHttpRequest()
        , method = tag.getAttribute('method') || 'GET'
        , path = tag.action || tag.pathname
        , main = tag.dataset.ninjaxgGet || to ||  ('main')
        , titleBefore = document.title
        , tagModel = document.querySelector(main)
        , left = tagModel.offsetLeft
        , top = tagModel.offsetTop
        , width = tagModel.offsetWidth
        , height = tagModel.offsetHeight
        ;
        document.title = 'Carregando...';
        xhr.open(method, url);
        xhr.send();
        document.body.insertAdjacentHTML('beforeend', '<div class="njax-wrap" style="left:'+left+'px; top:'+top+'px; width:'+width+'px; height:'+height+'px;"><div class="njax-load"></div></div>');
        xhr.addEventListener('readystatechange', function(e){
            var _target = e.target;
            switch(_target.readyState) {
                case 3:
                    break;
                case 4:
                    var dom = new DOMParser().parseFromString(_target.responseText, "text/html")
                    , title = tag.dataset.ninjaxTitle || dom.title || titleBefore
                    ;
                    document.querySelector('.njax-wrap').remove();
                    document.querySelector(main).innerHTML = dom.querySelector(main).innerHTML;
                    document.title = title;
                    var selector = '';
                    tag.classList.forEach(function(item){
                        selector+='.'+item;
                    });
                    selector = tag.tagName.toLowerCase()+selector;
                    if(!popstate){
                        history.pushState({url: url, tag: selector, to: to, text: tag.textContent}, title, url);
                    }
                    break;
            }
        });
    }
}