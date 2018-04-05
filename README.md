# Ninjax
xmlHttpRequest() + pushState() + popstate() + **3kb** = EASY ♥
```javascript
new Ninjax({
    tag: 'a',
    to: '.content',
    /*
    e = key "tag" Ninjax (.content)
    f = key "to" Ninjax (.content)
    */
    before: (e, f) => {
        document.body.insertAdjacentHTML('beforeend','<div class="ninjax__load" />');
    },
    /*
    e = key "tag" Ninjax (.content)
    f = key "to" Ninjax (.content)
    */
    complete: (e, f) => {
        document.querySelectorAll('.menu__link').forEach(item => item.classList.remove('menu__link-active'));
        e.classList.add('menu__link-active');
        document.querySelector('.ninjax__load').remove();
    }
});
```
