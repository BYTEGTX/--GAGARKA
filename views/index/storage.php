<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/6afbc1327d.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
        <title>GAGARKA</title>
    </head>
<body style="background: #cccccc">
<div style="position: fixed; width: 100%; z-index: 997">
    <div class="header header-margin d-flex  justify-content-between align-items-center">
        <a href="/"><div class="logo">GAG<b>ARKA</b></div></a>
        <div class="d-none d-md-flex col-md-3 justify-content-between">

            <? if (empty($_SESSION['user'])){?>
                <a href="/login">Войти</a>
            <?}else{?>
                <a href="/logout">Выйти</a>
            <?}?>
        </div>
        <div class="col-4 d-md-none d-flex">
            <div class="col-6 d-flex justify-content-center">
                <? if (empty($_SESSION['user'])){?>
                    <a href="/login"><i style="font-size: 36px;" class="bi bi-box-arrow-in-right"></i></a>
                <?}else{?>
                    <a href="/logout"><i style="font-size: 36px;" class="bi bi-door-closed"></i></a>
                <?}?>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <a href="/"><i style="font-size: 36px;" class="bi bi-arrow-left-square"></i></a>
            </div>
        </div>
    </div>
</div>

<div style="position: fixed; width: 100vw; height: 100vh; z-index: 996; background: #cccccc;" hidden id="addItemList">
    <div class="container d-flex justify-content-center row align-items-center" style=" height: 100vh;  overflow: auto; ">
        <div class="d-flex flex-column justify-content-center row align-items-center" style="padding-top: 200px; padding-bottom: 200px;">
            <h2 style="color: #000">Добавить товар</h2>
            <input type="text" placeholder="Введите кол-во" class="white-input" id="addInput">
            <select name="item" id="addSItem" style="margin-top: 30px; padding: 10px 30px;">
                <? foreach ($items as $item){?>
                    <option value="<?= $item['id'];?>"><?= $item['title'];?></option>
                <?}?>
            </select>
            <button style="font-size: 1.3rem; margin-top: 30px;" onclick="addItem(event);">Продолжить</button>
            <button style="font-size: 1.3rem;" class="black-button" onclick="openItemList(event, 'add');">Отмена</button>
        </div>
    </div>
</div>
<div style="position: fixed; width: 100vw; height: 100vh; z-index: 996; background: #cccccc;" hidden id="delItemList">
    <div class="container d-flex justify-content-center row align-items-center" style=" height: 100vh;  overflow: auto; ">
        <div class="d-flex flex-column justify-content-center row align-items-center" style="padding-top: 200px; padding-bottom: 200px;">
            <h2 style="color: #000">Удалить товар</h2>
            <input type="text" placeholder="Введите кол-во" class="white-input" id="delInput">
            <select name="item" id="delSItem" style="margin-top: 30px; padding: 10px 30px;">
                <? foreach ($items as $item){?>
                    <option value="<?= $item['id'];?>"><?= $item['title'];?></option>
                <?}?>
            </select>
            <button style="font-size: 1.3rem; margin-top: 30px;" onclick="delItem(event);">Продолжить</button>
            <button style="font-size: 1.3rem;" class="black-button" onclick="openItemList(event, 'del');">Отмена</button>
        </div>
    </div>
</div>


        <div class="white-back section" style="height: auto">
            <div class="container d-flex col-12" style="padding: 200px 30px;">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700">Статистика склада</h2>
                        <p>Статистика склада и рассходников</p>
                    </div>
                    <div class="d-flex adaptive-margintop col-12">
                        <div style="width: 100%;">
                            <div class="d-flex flex-wrap">
                                <? foreach ($storage as $store){?>
                                <div class="col-3">
                                    <p><?= $store['title'];?></p>
                                    <p><b><?=  $store['count']?></b></p>
                                </div>
                                <?}?>

                            </div>
                            <div class="d-flex col-12 row">
                                <button class="col-12" style="font-size: 1.3rem" onclick="openItemList(event, 'add')">Добавить</button>
                                <button class="col-12 black-button" style="font-size: 1.3rem" onclick="openItemList(event, 'del')">Удалить</button>
                                <a href="/storage/log" style="padding: 0px;"><button class=" wt-button" style="font-size: 1.3rem; width: 100%;">История</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<? foreach($points as $point){?>
        <hr>
        <div class="white-back section" style="height: auto !important;">
            <div class="container d-flex col-12" style="padding: 30px 30px;">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700"><?= $point['title']?></h2>
                        <p>Статистика склада и рассходников</p>
                    </div>
                    <div class="d-flex adaptive-margintop col-12">
                        <div style="width: 100%;">
                            <div class="d-flex flex-wrap">
                                <?
                                $pointStorage = Main::getPointStorage($point['id']);
                                if (count($pointStorage) == 0){
                                    ?> <p>Склад пуст</p><?
                                }else{
                                    foreach ($pointStorage as $pointStore){?>
                                        <? $pointStore['title'] = Main::getItemTitle($pointStore['item']); ?>
                                        <div class="col-3">
                                            <p><?= $pointStore['title'];?></p>
                                            <p><b><?=  $pointStore['count']?></b></p>
                                        </div>
                                    <?}
                                }?>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?}?>
<div style="height: 300px;">

</div>


<script>



    function openItemList(e, action){
        e.preventDefault();

        if (action == 'add'){
            var div = document.getElementById('addItemList');
            if (div.hidden) {
                div.hidden = false; // Показываем div
            } else {
                div.hidden = true; // Скрываем div
            }
        }else{
            var div = document.getElementById('delItemList');
            if (div.hidden) {
                div.hidden = false; // Показываем div
            } else {
                div.hidden = true; // Скрываем div
            }
        }


    }
    function addItem(e){
        e.preventDefault();
        $.ajax( {
            url: "/api/addItemStorage",
            type: "POST",
            data: {
                count: addInput.value,
                item: addSItem.value
            },
            success: function(data) {
                location.reload();
                console.log(data);
            },
            error: function(){
                console.log('Ошибка №2');
            }
        });
    }
    function delItem(e){
        e.preventDefault();
        $.ajax( {
            url: "/api/delItemStorage",
            type: "POST",
            data: {
                count: delInput.value,
                item: delSItem.value
            },
            success: function(data) {
                location.reload();
                console.log(data);
            },
            error: function(){
                console.log('Ошибка №2');
            }
        });
    }

</script>
</body>
</html>