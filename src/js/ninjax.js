class Ninjax{
  constructor(props){
    this.tag = props.tag;
    this.to = props.to||'main';
    this.method = props.method||'GET';
    this.event = props.event||'click';
    this.complete = props.complete||null;
    this.before = props.before||null;

    this.build();
    this.mutation();
    this.history();
  }
  build(){
    document.querySelectorAll(this.tag).forEach((item, i) => {
      if(!item.hasAttribute('data-ninjax')){
        item.dataset.ninjax = item.href||item.action;
      }
      if(!item.hasAttribute('data-ninjax-to')){
        item.dataset.ninjaxTo = this.to;
      }
      if(!item.hasAttribute('data-ninjax-method')){
        item.dataset.ninjaxMethod = this.method;
      }
      if(!item.hasAttribute('data-ninjax-event')){
        item.dataset.ninjaxEvent = item.tagName==='FORM' ? 'submit' : this.event;
        item.addEventListener(item.dataset.ninjaxEvent, (e) => {
          e.preventDefault();
          if(this.before){
            this.before(item, item.dataset.ninjaxTo);
          }
          this.ajax(item.dataset.ninjaxMethod, item.dataset.ninjax, item.dataset.ninjaxTo, item);
        });
      }
    });
  }
  mutation(){
    new MutationObserver((mutations) => {
      this.build();
    }).observe(document.body, {
        attributes: true
      , childList: true
      , characterData: true
      , subtree: true
    });
  }
  history(){
    addEventListener('popstate', (e) => {
      e.preventDefault();
      this.popstate = true;
      const _state = e.state;
      /*console.log(_state);*/
      if(_state){
        this.ajax(_state.method, _state.url, _state.to);
      } else {
        this.ajax('GET', location.href, this.to);
      }
    });
  }
  ajax(method, url, to, tag){
    const _xhr = new XMLHttpRequest();
    _xhr.open(method, url);
    _xhr.responseType = 'document';
    _xhr.addEventListener('load', (e) => {
      const _dom = e.target.response
      , _to = _dom.querySelector(to)
      ;
      if(_to){
        document.querySelector(to).innerHTML = _to.innerHTML;
        document.title = _dom.title;
        const _toAfter = document.querySelector(to);
        if(!this.popstate){
          this.url(url, {method: method,url: url,to: to});
        }
        _toAfter.querySelectorAll('script').forEach(item => {
          const script = document.createElement('script');
          if(item.src){
            script.src=item.src;
            item.parentNode.insertBefore(script, item);
          } else {
            const _fn = new Function(item.textContent);
            _fn();
          }
        });
        if(this.complete){
          this.complete(tag, _toAfter);
        }
      } else {
        document.querySelector(this.to).innerHTML = '<h1>&#x26a0; Ninjax "To", not found!</h1>';
      }
    });
    _xhr.send();
  }
  url(uri, obj){
    history.pushState(obj, '', uri);
  }
}