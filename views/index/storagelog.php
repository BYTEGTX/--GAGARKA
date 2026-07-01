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


        <div class="white-back section">
            <div class="container d-flex col-12" style="padding: 200px 30px; max-height: 70vh">
                <div class="col-12 d-flex flex-column">
                    <div>
                        <h2 style="text-transform: uppercase; font-weight: 700">Логи склада</h2>
                        <p>История обращений к складу</p>
                    </div>
                    <div class="d-flex adaptive-margintop col-12">
                        <div style="width: 100%;">
                            <div class="d-flex flex-wrap">
                                <? foreach ($storagelog as $storelog){
                                        $storelog['user'] = Main::getUserNickname($storelog['user']);
                                        $storelog['point'] = Main::getPointTitle($storelog['point']);
                                        $storelog['item'] = Main::getItemTitle($storelog['item']);
                                    ?>
                                    <div class="col-12 d-flex flex-column" >
                                        <div class="col-12 d-flex justify-content-between" style="margin: 0;">
                                            <div class="col-4">
                                                <p style="margin: 0"><b><?=  $storelog['point']?></b></p>
                                                <p><?= $storelog['user'];?></p>
                                            </div>
                                            <div class="col-4">
                                                <p style="margin: 0"><?= $storelog['item'] ?></p>
                                                <p><?= $storelog['count']?></p>
                                            </div>
                                            <div class="col-4">
                                                <p style="margin: 0px;"><?= $storelog['createtime'];?></p>
                                            </div>
                                        </div>


                                        <hr style="color: #000; background: white; margin-bottom: 30px;">
                                    </div>
                                <?}?>

                            </div>
                            <div class="d-flex col-12 row">
                                 <a href="/storage"><button class="col-12 wt-button" style="font-size: 1.3rem">Назад</button></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


<div style="height: 300px;">

</div>


<script>


</script>
</body>
</html>