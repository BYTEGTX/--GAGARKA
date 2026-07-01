
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
        <title>GAGARKA 2024</title>
    </head>
<body>
<div style="position: fixed; width: 100%; z-index: 997">
    <div class="header header-margin d-flex justify-content-between align-items-center">
        <a href="/"><div class="logo">GAG<b>ARKA</b></div></a>
        <div class="d-none d-md-flex col-md-4 justify-content-between">
            <? if (empty($_SESSION['user'])){?>
                <a href="/login">Войти</a>
            <?}else{?>
                <a href="/logout">Выйти</a>
            <?}?>
        </div>
        <div class="d-md-none d-flex">

            <div class="">
                <? if (empty($_SESSION['user'])){?>
                    <a href="/login"><i style="font-size: 36px;" class="bi bi-box-arrow-in-right"></i></a>
                <?}else{?>
                    <a href="/logout"><i style="font-size: 36px;" class="bi bi-door-closed"></i></a>
                <?}?>
            </div>
        </div>
    </div>
</div>
<div style="position: fixed; width: 100vw; height: 100vh; z-index: 996; background: #cccccc;" hidden id="addItemList">
    <div class="container d-flex justify-content-center row align-items-center" style=" height: 100vh;  overflow: auto; ">
        <div class="d-flex flex-column justify-content-center row align-items-center" style="padding-top: 200px; padding-bottom: 200px;">
            <h2 style="color: #000">Взять со склада</h2>
            <input type="text" placeholder="Введите кол-во" class="white-input" id="addInput">
            <select name="item" id="addSItem" style="margin-top: 30px; padding: 10px 30px;">
                <? foreach ($getItems as $item){?>
                    <option value="<?= $item['item'];?>"><?= $item['title'];?></option>
                <?}?>
            </select>
            <button style="font-size: 1.3rem; margin-top: 30px;" onclick="addItem(event);">Продолжить</button>
            <button style="font-size: 1.3rem;" class="black-button" onclick="openItemList(event, 'add');">Отмена</button>
        </div>
    </div>
</div>
    <div class="section gradient d-flex flex-column">
        <div class="container d-flex col-12" style="padding: 300px 30px; color: black; max-height: 70vh">
            <div class="col-12 d-flex flex-column">
                <div>
                    <h2 style="text-transform: uppercase; font-weight: 700"><?=$user['nickname']?></h2>
                    <p><span class="opacity">Должность:</span> <?= $type['title']; ?></p>
                </div>
                <div class="col-12 d-flex justify-content-between adaptive-margintop" >
                    <? if ($user['admin'] == 0){ ?>
                        <div class="col-4 d-flex flex-column justify-content-center"  style="text-align: center">
                            <p class="opacity">Касса</p>
                            <p class="d-flex flex-column" style="font-weight: 600; font-size: 1.8rem; line-height: 0.7; letter-spacing: -0.035em; cursor: pointer;" id="cass" onclick="cassa()"><?= $balance.'₽'?></p>
                        </div>
                        <div class="col-4 d-flex flex-column justify-content-center"  style="text-align: center">
                            <p class="opacity">Заработано</p>
                            <p style="font-weight: 600; font-size: 1.8rem; line-height: 0.9; letter-spacing: -0.035em;"><?= $profit.'₽'?></p>
                        </div>
                        <div class="col-4 d-flex flex-column justify-content-center" style="text-align: center">
                            <p class="opacity">Клиентов</p>
                            <p style="font-weight: 600; font-size: 1.8rem; line-height: 0.9; letter-spacing: -0.035em;"><?= $clients?></p>
                        </div>

                    <?}else{?>
                        <div class="col-4 d-flex flex-column justify-content-center"  style="text-align: center">
                            <p class="opacity">Касса</p>
                            <p class="d-flex flex-column" style="font-weight: 600; font-size: 1.8rem; line-height: 0.7; letter-spacing: -0.035em; cursor: pointer;" id="allcass" onclick="allcassa();"><?= $allbalance.'₽'?></p>
                        </div>
                        <? if ($user['admin'] != 1){ ?>
                            <div class="col-4 d-flex flex-column justify-content-center"  style="text-align: center">
                                <p class="opacity">Заработано</p>
                                <p style="font-weight: 600; font-size: 1.8rem; line-height: 0.9; letter-spacing: -0.035em;"><?= $profit.'₽'?></p>
                            </div>
                        <?}?>
                        <div class="col-4 d-flex flex-column justify-content-center" style="text-align: center">
                            <p class="opacity">Клиентов</p>
                            <p style="font-weight: 600; font-size: 1.8rem; line-height: 0.9; letter-spacing: -0.035em;"><?= $allclients?></p>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
        <div style="background: #0f0f0f; color: black; width: 100vw;  height: 30vh !important; margin: 0px !important;">
            <div class="container" style="min-height: 100%; width: 100%; margin-top: -70px; padding: 30px;">
                <div class="large-shadow" style="background: #151414; height: auto; width: 100%; border-radius: 20px; color: white; padding: 30px;">
                    Ого:
                    <p style="font-weight: 600; font-size: 36px; line-height: 0.7; letter-spacing: -0.035em;"><?='ЯМЫДЗЮБА'?></p>
                    <div>
                        <div style="width: 100%; background: #1c1b1b; border-radius: 5px;">
                            <div style="width: 70%;  height: 10px; background: #ec6f11; border-radius: 5px;" class="large-shadow"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <? if ($user['admin'] == 0){?>
        <div class="black-back section" style=" height: auto;">
            <div class="container d-flex col-12 flex-column" style="padding: 200px 30px; padding-bottom: 60px;">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700">Создание тикета</h2>
                        <p><span class="opacity">Должность:</span> <?= $type['title']; ?></p>
                    </div>
                    <div class="col-12 d-flex row justify-content-between" style="margin-top: 60px;">

                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <p style="margin-top: 32px;"><b>Безналичный рассчет</b></p>
                            <div class="form-check form-switch">
                                <input type="checkbox" id="beznal" /><label for="beznal">Toggle</label>
                            </div>
                        </div>
                        <hr style="margin-bottom: 30px;">
                        <?foreach ($buttons as $button){?>
                            <div class="col-6 d-flex flex-column justify-content-center"  style="text-align: center">
                                <button class="pay d-flex justify-content-center flex-wrap" data-value="<?= $button['id'];?>"><span class="col-12"><?= $button['count'];?>₽ </span>
                                <? if ($button['item'] != 0){
                                    $butitem = Main::getItemTitle($button['item']);
                                    ?>
                                     <span style="font-size: 0.8rem"><?= $butitem;?></span>
                                    <?
                                }?></button>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div style=" margin-top: 100px;">

                </div>
                <? foreach($userorders as $order){ ?>
                    <div style="background: #fff0f0; color: black !important; margin-bottom: 10px; width: 100%; border-radius: 20px; padding: 15px;">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <span style="font-size: 36px; font-weight: 600;"><?= $order['count'];?>₽</span>
                                <? if ($order['beznal'] == 0){?>
                                    <span style="font-weight: 600;">Наличные</span>
                                <?}else{?>
                                    <span style="font-weight: 600;">Безналичные</span>
                                <?}?>
                            </div>
                            <div onclick="delOrder(event, <?= $user['id']?>, <?= $order['id']?>);">
                                <span style="color: #cccccc; padding: 15px;"><i class="bi bi-trash3-fill"></i></span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span><?= $order['type']['title'];?></span>
                            </div>
                            <div>
                                <span><?= $order['user']['name'];?> "<?= $order['user']['nickname'];?>" <?= $order['user']['lastname'];?></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span></span>
                            </div>
                            <div>
                                <span><?= $order['createtime'] ?></span>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>

        </div>

    <?}else{?>
        <div class="black-back section" style="height: auto">
            <div class="container d-flex col-12" style="padding: 200px 30px;">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700">Админ панель</h2>
                    </div>
                    <div class="d-flex row adaptive-margintop">
                        <div>
                            <?if(count($allorders) == 0){?>
                                <p style="color: #444444; font-size: 2rem; font-weight: 800">Сегодня не было клиентов</p>
                            <?}?>
                            <? foreach(array_slice($allorders, 0, 5) as $order){ ?>
                                <div style="background: #fff0f0; color: black !important; margin-bottom: 10px; width: 100%; border-radius: 20px; padding: 15px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-column">
                                            <span style="font-size: 36px; font-weight: 600;"><?= $order['count'];?>₽</span>
                                            <? if ($order['beznal'] == 1){?>
                                            <span style="font-weight: 600;">Наличные</span>
                                            <?}else{?>
                                            <span style="font-weight: 600;">Безналичные</span>
                                            <?}?>
                                        </div>
                                        <div>
                                            <span style="color: #cccccc"><i class="bi bi-trash3-fill"></i></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span><?= $order['type']['title'];?></span>
                                        </div>
                                        <div>
                                            <span><?= $order['user']['name'];?> "<?= $order['user']['nickname'];?>" <?= $order['user']['lastname'];?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span></span>
                                        </div>
                                        <div>
                                            <span><?= $order['createtime'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                            <div class="d-flex justify-content-center" style="padding: 10px; padding-bottom: 30px;">
                                <a href="/orders">Показать все ордеры</a>
                            </div>

                            <div class="d-flex col-12">
                                <a href="/staff" class="col-12 d-flex "><button style="font-size: 1.3rem; width: 100%;"><i class="bi bi-people"></i> Управление персоналом</button></a>
                            </div>
                            <div class="d-flex col-12">
                                <a href="/storage" class="col-12 d-flex "><button style="font-size: 1.3rem; width: 100%;"><i class="bi bi-people"></i> Управление складом</button></a>
                            </div>
                            <div class="d-flex col-12">
                                <button style="font-size: 1.3rem; width: 100%; background: #181a19; color: #fff0f0" onclick="downloadcsv(event)"><i class="bi bi-file-earmark-arrow-down"></i> Скачать отчет</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?}
    if ($user['id'] == $_SESSION['user']['id']){
      if (count($getItems) > 0){ ?>
          <div class="black-back section" style="height: auto">
              <div class="container d-flex col-12" style="">
                  <div class="col-12 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1>Рассходники</h1>
                        <button class="black-button" style="font-size: 1rem" onclick="openItemList(event);">Добавить</button>
                    </div>
                      <div class="d-flex flex-wrap adaptive-margintop">
                      <? foreach ($getItems as $pointItem){?>
                              <div class="col-3">
                                  <p><?= $pointItem['title'];?></p>
                                  <p><b><?=  $pointItem['count']?></b></p>
                              </div>
                          <?}?>

                      </div>
                  </div>
              </div>
          </div>
    <?}
    }?>
<div style="height: 200px;">

</div>

<script>
    function openItemList(e){
        e.preventDefault();


        var div = document.getElementById('addItemList');
        if (div.hidden) {

            div.hidden = false; // Показываем div
        } else {
            div.hidden = true; // Скрываем div
        }
    }
    function downloadcsv(e){
        e.preventDefault();
        window.location.href = '/api/csv';
    }
    let status = 0;
    let allstatus = 0;
    <? if ($user['admin'] != 1){?>
        document.querySelectorAll('button.pay').forEach(button => {
            button.addEventListener('click', function() {
                const valueToAdd = parseInt(this.getAttribute('data-value')); // Получаем значение из атрибута data-value
                let payment = 1;

                if (beznal.checked === false){
                    payment = 0;
                }else{
                    payment = 1;
                }
                $.ajax( {
                    url: "/api/addorder",
                    type: "POST",
                    data: {
                        beznal: payment,
                        type: <?= $user['type']; ?>,
                        user: <?= $_SESSION['user']['id'];?>,
                        button: valueToAdd
                    },
                    success: function(data) {
                        location.reload();
                        console.log(data);
                    },
                    error: function(){
                        console.log('Ошибка №2');
                    }
                });
            });
        });
        function cassa(){

            if (status === 0){
                status++;
                cass.innerHTML = '';
                cass.innerHTML = '<p style="font-size: 1.3rem;"><?= $nal; ?> н.</p><p style="font-size: 1.3rem;"><?= $beznal; ?> б.н.</p>'; //тут менять размер раздельных значений кассы
            }else{
                status--;

                cass.innerHTML = '';
                cass.innerHTML = '<?= $balance."₽"?>';
            }
        }
    <? }else{ ?>
        function allcassa(){

            if (allstatus === 0){
                allstatus++;
                allcass.innerHTML = '';
                allcass.innerHTML = '<p style="font-size: 1.3rem;"><?= $allnal; ?> н.</p><p style="font-size: 1.3rem;"><?= $allbeznal; ?> б.н.</p>'; //тут менять размер раздельных значений кассы
            }else{
                allstatus--;
                allcass.innerHTML = '';
                allcass.innerHTML = '<?= $allbalance."₽"?>';
            }
        }


    <? }?>
    function editItem(e, incdec, type, item, count){
        e.preventDefault();
        $.ajax( {
            url: "/api/edititem",
            type: "POST",
            data: {
                incdec: incdec,
                type: type,
                item: item,
                count: count
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
    function addItem(e){
        e.preventDefault();
        $.ajax( {
            url: "/api/addItemPoint",
            type: "POST",
            data: {
                point: <?= $user['type'];?>,
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
    function delOrder(e, user, orderid){
        e.preventDefault();
        $.ajax( {
            url: "/api/delorder",
            type: "POST",
            data: {
                user: user,
                orderid: orderid
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

    document.addEventListener("DOMContentLoaded", function() {
        const beznalCheckbox = document.getElementById('beznal');

        // Установить состояние чекбокса из localStorage
        if (localStorage.getItem('beznal') === 'true') {
            beznalCheckbox.checked = true;
        } else {
            beznalCheckbox.checked = false;
        }

        // Сохранить состояние чекбокса в localStorage при изменении
        beznalCheckbox.addEventListener('change', function() {
            localStorage.setItem('beznal', this.checked);
        });
    });


</script>
</body>
</html>