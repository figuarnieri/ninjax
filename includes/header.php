<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ninjax</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
      *{margin: 0;padding: 0;box-sizing: border-box;}
      body{min-height: 100vh;display: flex;}
      .menu{width: 20%;background-color: #ccc;padding: 20px;}
      .content{width: 80%;background-color: #ddd;padding: 10px 30px;}
      .menu__list{padding: 0;list-style-type: none;}
      .menu__item{margin-bottom: 3px;}
      .menu__link{padding: 10px;display: block;background-color: #c00;color: #fff;font-size: 20px;border-radius: 3px;}
      .menu__link-active{background-color: #eee;color: #000;}
      .menu__link:hover{text-decoration: none;background-color: #fff;color: #c00;}
      @keyframes ninjax{
        from{opacity: 0;}
        to{opacity: 1;}
      }
      .ninjax__load{position: absolute;left: 0;top: 0;width: 100vw;height: 100vh;z-index: 99;background-color: rgba(0,0,0,.8);animation: ninjax 0.3s forwards;}
    </style>
</head>
<body>
  <div class="menu">
    <h1>Menu:</h1>
    <ul class="menu__list">
      <li class="menu__item"><a class="menu__link" href="./">Index</a></li>
      <li class="menu__item"><a class="menu__link" href="./contato">Contato</a></li>
      <li class="menu__item"><a class="menu__link" href="./sobre">Sobre</a></li>
    </ul>
  </div>
  <div class="content">