<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ninjax <?=$_GET['page']?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu"><?=$_GET['page']?></div>
    <div class="content">
        <form action="index.php" class="box form" method="GET" data-ninjax-title="Wow">
            <div class="box-body">
                <div class="tablejax-tools cf row">
                    <div class="col-md-1">
                        <select name="Qtd" id="Qtd" class="form-control">
                            <option value="2">2</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="Check[]" id="" value="1">
                        <input type="checkbox" name="Check[]" id="" value="2">
                        <input type="checkbox" name="Check[]" id="" value="3">
                        <input type="checkbox" name="Check[]" id="" value="4">
                        <input type="checkbox" name="Check[]" id="" value="5">
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Radio[]" id="" value="1">
                        <input type="radio" name="Radio[]" id="" value="2">
                        <input type="radio" name="Radio[]" id="" value="5">
                    </div>
                    <div class="col-md-3">
                        <textarea name="Textarea" id="Textarea" cols="30" rows="1"></textarea>
                    </div>
                    <div class="col-md-3">
                        <input value="<?=$_GET['Search']?>" type="search" name="Search" id="Search" class="form-control" placeholder="Buscar">
                    </div>
                    <div class="col-md-1">
                        <button type="submit">OK</button>
                    </div>
                </div>
                <table class="table table-bordered table-hover tablejax">
                    <thead>
                        <tr>
                            <th>Pagina</th>
                            <th>Por página</th>
                            <th>Checks</th>
                            <th>Busca</th>
                            <th>Produto</th>
                            <th>Data&nbsp;da&nbsp;compra</th>
                            <th>Data&nbsp;de&nbsp;Cadastro</th>
                            <th>Status</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        if(!isset($_GET['page'])) $_GET['page']=1;
                        $paginate = !isset($_GET['Qtd']) ? 1 : intval($_GET['Qtd']);
                        ?>
                            <? for($i=1;$i<=$paginate;$i++){ ?>
                                <tr role="row">
                                    <td class=""><?=$_GET['page'].' - '.$i?></td>
                                    <td class="sorting_1"><?=$_GET['Qtd']?></td>
                                    <td><? print_r($_GET['Check'])?></td>
                                    <td><?=$_GET['Search']?></td>
                                    <td>CEL LG C299 PRETO DESBL 4 CHIP DESB QUAD</td>
                                    <td>06/12/2014</td>
                                    <td>06/12/2014</td>
                                    <td><i class="fa fa-hourglass" title="Aguardando aprovação"></i></td>
                                    <td><?=$_GET['page']?></td>
                                </tr>
                            <? } ?>
                    </tbody>
                </table>
                <div class="tablejax-page text-right">
                    <a href="./" data-ninjax class="linker link-1 d-ib">1</a>
                    <a href="?page=2" data-ninjax class="linker link-2 d-ib">2</a>
                    <a href="?page=3&log=20&Qtd=3" data-ninjax class="linker link d-ib">3</a>
                    <a href="?page=4&log=30&Qtd=4" data-ninjax class="linker link d-ib">4</a>
                </div>
            </div>
        </form>
    </div>
    <script src="ninjax.js"></script>
    <script>
        //new ninjax({tag: '.form'});
        new ninjax({tag: '[data-ninjax]', to: '.table'});
        /*new ninjax('[data-ninjax]', '.table');*/
        new ninjax('form', '.table');
        //new ninjax({tag: 'a', to: '.tablejax tbody'});
    </script>
</body>
</html>