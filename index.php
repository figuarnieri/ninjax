<?php 
if(!isset($_GET['page'])){
  $_GET['page'] = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ninjax <?=$_GET['page']?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
      body{min-height: 100vh;display: flex;}
      .menu{width: 20%;background-color: #ccc;padding: 20px;}
      .content{width: 80%;background-color: #ddd;}
      .menu__list{padding: 0;list-style-type: none;}
      .menu__item{margin-bottom: 3px;}
      .menu__link{padding: 10px;display: block;background-color: #c00;color: #fff;font-size: 20px;border-radius: 3px;}
      .menu__link:hover{text-decoration: none;background-color: #fff;color: #c00;}
      
      @keyframes ninjax{
        from{opacity: 0;}
        to{opacity: 1;}
      }
      .ninjax__position{position: relative;}
      .ninjax__load{position: absolute;left: 0;top: 0;width: 100vw;height: 100vh;z-index: 99;background-color: rgba(0,0,0,.8);animation: ninjax .3s forwards;}
    </style>
</head>
<body>
    <div class="menu">
      <h1>Página Inicial: <?=$_GET['page']?></h1>
      <ul class="menu__list">
        <li class="menu__item"><a class="menu__link" href="./">Item 1</a></li>
        <li class="menu__item"><a class="menu__link" href="./?page=2&qtd=2">Item 2</a></li>
        <li class="menu__item"><a class="menu__link" href="./?page=3&qtd=2">Item 3</a></li>
        <li class="menu__item"><a class="menu__link" href="./?page=4&qtd=2">Item 4</a></li>
        <li class="menu__item"><a class="menu__link" href="./?page=5&qtd=2">Item 5</a></li>
        <li class="menu__item"><a class="menu__link" href="./?page=6&qtd=2">Item 6</a></li>
      </ul>
    </div>
    <div class="content">
      <h2>Conteúdo da Página <?=$_GET['page']?></h2>
      <form action="index.php" class="box form" method="GET" data-ninjax-title="Wow">
      </form>
    </div>
    <!-- <script src="ninjax.js"></script> -->
    <script>
      class Ninjax{
        constructor(selector, to){
          const _tag = typeof selector === 'object' ? selector.tag : selector;
          this.to = typeof selector === 'object' ? selector.to : to;
          window.document.querySelectorAll(_tag).forEach(item => {
            let _url, _method, _params, _event;
            if(item.tagName==='A'){
              _url = item.dataset.ninjaxUrl || (item.origin + item.pathname);
              _method = item.dataset.ninjaxMethod || 'GET';
              _params = item.dataset.ninjaxParams || item.search.replace('?','').split('&');
              _event = 'click';
            }
            item.dataset.ninjaxUrl = _url;
            item.dataset.ninjaxMethod = _method;
            item.dataset.ninjaxParams = _params.toString().replace(/\,/,'&');
            this.init(item, _event);
          });
          this.popstate();
        }
        init(tag, event){
          tag.addEventListener(event, e => {
            e.preventDefault();
            const _params = (tag.dataset.ninjaxParams!=='' ? '?'+tag.dataset.ninjaxParams : tag.dataset.ninjaxParams),
            _method = tag.dataset.ninjaxMethod,
            _url = tag.dataset.ninjaxUrl+_params;
            this.ajax(_method, _url)
          });
        }
        ajax(method, url){
          const _xhr = new XMLHttpRequest(),
          _to = window.document.querySelector(this.to);
          _xhr.open(method, url, true);
          if(getComputedStyle(_to).position==='static'){
            _to.classList.add('ninjax__position');
          }
          _to.insertAdjacentHTML('beforeend', '<div class="ninjax__load"></div>');
          _xhr.addEventListener('load', response => {
            const xhrRes = response.target;
            if(xhrRes.status===200 && xhrRes.readyState===4){
              const _parser = new DOMParser(),
              _html = _parser.parseFromString(xhrRes.response, "text/html");
              _to.innerHTML = _html.querySelector(this.to).innerHTML;
              this.url({method: method, url: _xhr.responseURL}, _html.querySelector('title').textContent, _xhr.responseURL);
            }
          });
          _xhr.send();
        }
        url(obj, title, link,){
          window.document.title = title;
          window.history.pushState(obj, title, link);
        }
        popstate(){
          window.addEventListener('popstate', e => {
            const _state = window.history.state;
            this.ajax(_state.method, _state.url);
            /*console.log(window.history.state);*/
          });
        }
      }
      /*new Ninjax('a', '.content');*/
      new Ninjax({
        tag: 'a',
        to: '.content'
      });
        /*new ninjax({tag: '[data-ninjax]', to: '.table'});
        new ninjax('form', '.table');*/
    </script>
</body>
</html>