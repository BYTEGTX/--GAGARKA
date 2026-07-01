<?php

include_once ROOT.'/models/main.php';


class UserController
{
    public function actionCSV(){
        Main::createCSV();
        return true;
    }
    public function actionEdititem(){
        Main::editItem($_POST['incdec'], $_POST['type'], $_POST['count'], $_POST['item']);

        var_dump($_POST);
        return true;
    }
    public function actionUser($userid) {
        $user = Main::getUserByID($userid);

        $items = Main::getAllItems();
        $temp = Main::getWeather();
        if ($user['admin'] == 1){
            echo "<script>self.location='/';</script>";
        }else{
            $buttons = Main::getButtons($user['type']);
            $type = Main::getType($user['type']);
            $beznal = Main::getBalance($user['id']);
            $nal = Main::getBalanceNal($user['id']);
            $balance = $nal + $beznal;
            $weekBalance = Main::getBalanceWeek($user['id']);
            $procent = '0.'.$user['procent'];
            $weekProfit = $balance*$procent;
            $profit = $balance*$procent;
            $clients = Main::getClients($user['id']);
            require_once(ROOT.'/views/index/index.php');
        }

        return true;
    }
    public function actionOrders(){
        if (!empty($_SESSION['user'])){
            $user = Main::getUser($_SESSION['user']['id']);

            $type = Main::getType($user['type']);

            if ($user['admin'] == 1){
                $allorders = Main::getAllOrders();
                $allclients = Main::getAllClients();
                $allnal = Main::getAllBalanceNal();
                $allbeznal = Main::getAllBalance();
                $allbalance = $allnal + $allbeznal;
            }else{
                echo "<script>self.location='/';</script>";
            }
            //var_dump($user);
            require_once(ROOT.'/views/index/orders.php');
            return true;
        }else{
            echo "<script>self.location='/login';</script>";
        }
        return true;
    }
    public function actionAddItemPoint(){
        Main::createStoreLog($_POST);
        Main::addItemToPoint($_POST);
        Main::delItemToStorage($_POST);
    }
    public function actionAddItemStorage(){
        var_dump($_POST);
        Main::addItemToStorage($_POST);
    }
    public function actionDelItemStorage(){
        var_dump($_POST);
        Main::delItemToStorage($_POST);
    }
    public function actionStorage(){
        if (!empty($_SESSION['user'])){
            $user = Main::getUser($_SESSION['user']['id']);
            $items = Main::getAllItems();
            $type = Main::getType($user['type']);
            $users = Main::getAllStaffs();
            $types = Main::getAllTypes();
            $points = Main::getPoints();
            $storage = Main::getStorage();
            if ($user['admin'] == 1){
                $allorders = Main::getAllOrders();
                $allclients = Main::getAllClients();
                $allnal = Main::getAllBalanceNal();
                $allbeznal = Main::getAllBalance();
                $allbalance = $allnal + $allbeznal;
                require_once(ROOT.'/views/index/storage.php');
            }else{
                echo "<script>self.location='/';</script>";
            }
            //var_dump($user);
            return true;
        }else{
            echo "<script>self.location='/login';</script>";
        }
        return true;
    }
    public function actionStaff(){
        if (!empty($_SESSION['user'])){
            $user = Main::getUser($_SESSION['user']['id']);

            $type = Main::getType($user['type']);
            $users = Main::getAllStaffs();
            $types = Main::getAllTypes();

            if ($user['admin'] == 1){
                $allorders = Main::getAllOrders();
                $allclients = Main::getAllClients();
                $allnal = Main::getAllBalanceNal();
                $allbeznal = Main::getAllBalance();
                $allbalance = $allnal + $allbeznal;
                require_once(ROOT.'/views/index/staff.php');
            }else{
                echo "<script>self.location='/';</script>";
            }
            //var_dump($user);
            return true;
        }else{
            echo "<script>self.location='/login';</script>";
        }
        return true;
    }
    public function actionStorageLog(){
        $storagelog = Main::getStorageLog();
        $user = Main::getUser($_SESSION['user']['id']);
        if ($user['admin'] == 1){
            require_once(ROOT.'/views/index/storagelog.php');
            return true;
        }else{
            echo "<script>self.location='/';</script>";
        }
    }
	public function actionIndex() {
        if (!empty($_SESSION['user'])){
            $temp = Main::getWeather();

            $items = Main::getAllItems();
            $user = Main::getUser($_SESSION['user']['id']);
            $buttons = Main::getButtons($user['type']);
            $type = Main::getType($user['type']);
            $beznal = Main::getBalance($user['id']);
            $nal = Main::getBalanceNal($user['id']);
            $balance = $nal + $beznal;
            $weekBalance = Main::getBalanceWeek($_SESSION['user']['id']);
            $procent = '0.'.$user['procent'];
            $weekProfit = $balance*$procent;
            $profit = $balance*$procent;
            $clients = Main::getClients($user['id']);
            $getItems = Main::getItems($user['type']);
            $userorders = Main::getUserOrders($user['id']);
            if ($user['admin'] == 1){
                $allorders = Main::getAllOrders();
                $allclients = Main::getAllClients();
                $allnal = Main::getAllBalanceNal();
                $allbeznal = Main::getAllBalance();
                $allbalance = $allnal + $allbeznal;
            }
            //var_dump($user);
            require_once(ROOT.'/views/index/index.php');
            return true;
        }else{
            echo "<script>self.location='/login';</script>";
        }

	}
    public function actionApiLogin(){
        $user = Main::checkUser($_POST['nickname'], $_POST['pass']);
        if ($user == 'Success'){
            print_r('Success');

            echo "<script>self.location='/';</script>";
        }else{
            print_r('Error');
        }
        return true;
    }
    public function actionSetType(){
        Main::setType($_POST);
        return true;
    }
    public function actionApiOrder(){

        $button = Main::getButton($_POST['button']);
        if ($button['item'] != 0){
            Main::editItem('minus', $_POST['type'], 1, $button['item']);

        }

        Main::createOrder($_POST);


        return true;
    }
    public function actionDelOrder(){
        $order = Main::getOrder($_POST['orderid']);
        if ($order['item'] != 0){
            try {
                Main::editItem('plus', $order['type'], 1, $order['item']);
            }catch (Exception $e){

            }


        }
        Main::delOrder($_POST);

        return true;
    }
	public function actionLogin(){
        if (!empty($_SESSION['user'])){
            echo "<script>self.location='/';</script>";
        }else{
            require_once(ROOT.'/views/user/login.php');
        }
		return true;
	}

    public function actionLogout(){
        session_destroy();

        echo "<script>self.location='/';</script>";
        return true;
    }
}