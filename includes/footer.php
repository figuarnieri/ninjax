  </div>
  <script src="src/js/ninjax.js"></script>
  <script>
    new Ninjax({
      tag: 'a',
      to: '.content',
      before: (e, f) => {
        document.body.insertAdjacentHTML('beforeend','<div class="ninjax__load" />');
      },
      complete: (e, f) => {
        document.querySelectorAll('.menu__link').forEach(item => item.classList.remove('menu__link-active'));
        e.classList.add('menu__link-active');
        document.querySelector('.ninjax__load').remove();
      }
    });
  </script>
</body>
</html>