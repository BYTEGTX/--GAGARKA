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

<div style="position: fixed; width: 100vw; height: 100vh; z-index: 996; background: #cccccc;" hidden id="settypewind">
    <div class="container d-flex justify-content-center row align-items-center" style=" height: 100vh;  overflow: auto; ">
        <div class="d-flex flex-column justify-content-center row align-items-center" style="padding-top: 200px; padding-bottom: 200px;">
            <h2 style="color: #000">Изменить должность</h2>
            <? foreach($types as $settype){?>
                <button style="font-size: 1.2rem; margin-top: 30px;" onclick="actionSetUser(event, <?= $settype['id'];?>);"><?= $settype['title']?></button>
            <?}?>
        </div>
    </div>
</div>




        <div class="white-back section">
            <div class="container d-flex col-12" style="padding: 200px 30px; max-height: 70vh">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700">Управление персоналом</h2>
                        <p>Статистика работников за <span><b>день</b></span></p>
                    </div>
                    <div class="d-flex adaptive-margintop col-12">
                        <div style="width: 100%;">
                            <? foreach($users as $staff){ ?>
                                <a href="/u/<?= $staff['id'];?>" style="width: 100%;">
                                    <div class="large-shadow col-12 d-flex flex-wrap justify-content-between align-items-center" style="background: #fff0f0; color: black !important; margin-bottom: 10px; width: 100%; border-radius: 20px; padding: 25px;">
                                        <div style="font-size: 18px;" class="col-12 col-md-4">
                                            <p><b><?= $staff['nickname']?></b></p>
                                        </div>
                                        <div class="col-md-4 col-12 d-flex justify-content-between align-items-center">
                                            <div class="d-flex row flex-column">
                                                <span style="color: grey;">Касса</span>
                                                <span style="font-size: 18px; font-weight: 600;"><?= $sum = array_sum(array_map('intval', (array_column($staff['orders'], 'count'))));?>₽</span>
                                            </div>
                                            <div class="d-flex row flex-column">
                                                <span style="color: grey;">Зароботок</span>
                                                <span style="font-size: 18px; font-weight: 600;"><? $procent = '0.'.$staff['procent']; $staffBalance = ($sum*$procent); echo $staffBalance;?>₽</span>
                                            </div>
                                            <div class="d-flex row flex-column">
                                                <span style="color: grey;">Клиентов</span>
                                                <span style="font-size: 18px; font-weight: 600;"><?= $sum = count($staff['orders'])?></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 d-flex row">
                                            <div class="d-block d-md-none" style="padding: 15px;">
                                                <hr>
                                            </div>
                                            <button style="padding:3px 20px; font-size: 1.2rem;" onclick="setType(event, <?= $staff['id'];?>);"><?= $staff['type'];?></button>
                                        </div>
                                    </div>
                                </a>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>


    let status = 0;
    let allstatus = 0;
    <? if ($user['admin'] != 1){?>
        document.querySelectorAll('button').forEach(button => {
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
                        count: valueToAdd
                    },
                    success: function(data) {
                        //location.reload();
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
    var setUser;
    function setType(e, userid){
        e.preventDefault();
        var div = document.getElementById('settypewind');
        setUser = userid;

        if (div.hidden) {
            div.hidden = false; // Показываем div
        } else {
            div.hidden = true; // Скрываем div
        }
    }

    function actionSetUser(e, type){
        e.preventDefault();
        $.ajax( {
            url: "/api/settype",
            type: "POST",
            data: {
                type: type,
                user: setUser
            },
            success: function(data) {
                location.reload();
                setUser = 0;
            },
            error: function(){
                console.log('Ошибка №2');
            }
        });

    }
</script>
</body>
</html>