
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
        <div class="logo">GAG<b>ARKA</b></div>
        <div class="d-none d-md-flex col-md-3 justify-content-between">
            <a href="#">Войти</a>
        </div>
        <div class=" d-md-none d-flex">
            <a href="/login"><i style="font-size: 36px;" class="bi bi-box-arrow-in-right"></i></a>
        </div>
    </div>
</div>
<div class="section gradient d-flex flex-column">
    <div class="container d-flex col-12 align-items-center" style="padding: 200px 30px; color: black; height: 90vh">
        <div class="col-12 d-flex flex-column">
            <h1>Авторизация</h1>
            <p id="error"></p>
            <form action="" class="d-flex justify-content-center flex-column">
                <input type="text" placeholder="Никнейм" id="nickname">
                <input type="text" placeholder="Пароль" id="pass">
                <div class="d-flex justify-content-between">
                    <p></p>
                    <button onclick="login()" style="font-size: 20px; background: black; color: white">Продолжить</button>
                </div>
            </form>
        </div>
    </div>
    <div style="background: #0f0f0f; color: black; width: 100vw;  height: 30vh !important;">
        <div class="container" style="height: 100%; width: 100%; margin-top: -70px; padding: 30px;">


        </div>
    </div>

</div>



<script>
    function login(){
        $.ajax( {
            url: "/api/login",
            type: "POST",
            data: {
                nickname: nickname.value,
                pass: pass.value
            },
            success: function(data) {
                if (data == 'Success'){
                    self.location='/';
                    location.reload();
                }else{
                    self.location='/';
                    location.reload();
                }
                
            },
            error: function(){
                console.log('Ошибка авторизации');
            }
        });
    }
</script>
</body>
</html>