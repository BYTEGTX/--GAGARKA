<?php


/**
 * 
 */
class Main
{
    public static function getPointStorage($point){
        $db = Db::Connection();

        $getPointStorage = $db->prepare("SELECT * FROM typeitems WHERE typeitems.type = :point");
        $getPointStorage->bindParam(':point', $point);
        $getPointStorage->execute();
        $pointstorage = $getPointStorage->fetchAll(PDO::FETCH_BOTH);

        return $pointstorage;
    }
    public static function createCSV(){
        $users = Main::getAllUsers();

        $data = [];
        $itog = 0;
        $itognal = 0;
        $itogbeznal = 0;
        $itogclients = 0;
        foreach($users as $user){
            $beznal = Main::getBalance($user['id']);
            $nal = Main::getBalanceNal($user['id']);
            $clients = Main::getClients($user['id']);

            $data[$user['id']]['user'] = $user['nickname'];
            $data[$user['id']]['nal'] = $nal.' руб.';
            $data[$user['id']]['beznal'] = $beznal.' руб.';
            $data[$user['id']]['clients'] = $clients;
            $sum = $beznal+$nal;
            $procent = '0.'.$user['procent'];
            $data[$user['id']]['zp'] = $sum * $procent;
            $itog = $itog+$sum;
            $itognal = $itognal+$nal;
            $itogbeznal = $itogbeznal+$beznal;
            $itogclients = $itogclients+$clients;

        }
        $titles = ['Работник', 'Наличные', 'Безналичные', 'Клиентов', 'Зарплата'];
        unlink(date("d_m_Y").'.csv');
        $filename =  date("d_m_Y").'.csv';
        $file = fopen($filename, 'a');
        fputcsv($file, $titles);
        foreach ($data as $stroke){
            fputcsv($file, $stroke);
        }
        $itogstroke = ['ИТОГ: ', $itognal.' руб.', $itogbeznal.' руб.', $itogclients, 'Сумма: '.$itog.' руб.'];
        fputcsv($file, $itogstroke);
        sleep(5);
        fclose($file); // Закрываем файл
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));

        // Читаем файл и выводим его содержимое
        readfile($filename);
        return true;
    }
    public static function getWeather() {
        return 'Несколько ';

    }
    public static function getPoints()
    {
        $db = Db::Connection();

        $getPoints = $db->prepare("SELECT * FROM types WHERE types.storage = 1");
        $getPoints->execute();
        $points = $getPoints->fetchAll(PDO::FETCH_BOTH);

        return $points;
    }
    public static function getAllTypes()
    {
        $db = Db::Connection();

        $getAllTypes = $db->prepare("SELECT * FROM types");
        $getAllTypes->execute();
        $types = $getAllTypes->fetchAll(PDO::FETCH_BOTH);

        return $types;
    }
    public static function getStorageLog(){
        $db = Db::Connection();

        $getLogs = $db->prepare("SELECT * FROM storelog ORDER BY storelog.createtime DESC");
        $getLogs->execute();
        $logs = $getLogs->fetchAll(PDO::FETCH_BOTH);

        return $logs;
    }
    public static function getAllItems()
    {
        $db = Db::Connection();

        $getAllItems = $db->prepare("SELECT * FROM items");
        $getAllItems->execute();
        $items = $getAllItems->fetchAll(PDO::FETCH_BOTH);

        return $items;
    }
    public static function createStoreLog($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("INSERT INTO storelog (`user`,`point`,`item`,`count`) VALUES (:user,:point, :item, :count)");
        $getBalance->bindParam(':user', $_SESSION['user']['id']);
        $getBalance->bindParam(':point', $data['point']);
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->bindParam(':count', $data['count']);
        $getBalance->execute();


        return true;
    }
    public static function delButtonItem($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM typeitems WHERE typeitems.item = :item AND typeitems.type = :point");
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->bindParam(':point', $data['type']);
        $getBalance->execute();
        $item = $getBalance->fetch(PDO::FETCH_BOTH);

        $newvalue = $item['count'] - 1;
        $getItems = $db->prepare("UPDATE typeitems SET typeitems.count = :count WHERE typeitems.item = :item AND typeitems.type = :point");
        $getItems->bindParam(':count', $newvalue);
        $getItems->bindParam(':item', $data['item']);
        $getItems->bindParam(':point', $data['point']);
        $getItems->execute();

        return $_POST;
    }
    public static function addButtonItem($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM typeitems WHERE typeitems.item = :item AND typeitems.type = :point");
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->bindParam(':point', $data['point']);
        $getBalance->execute();
        $item = $getBalance->fetch(PDO::FETCH_BOTH);

        $newvalue = $item['count'] + 1;
        $getItems = $db->prepare("UPDATE typeitems SET typeitems.count = :count WHERE typeitems.item = :item AND typeitems.type = :point");
        $getItems->bindParam(':count', $newvalue);
        $getItems->bindParam(':item', $data['item']);
        $getItems->bindParam(':point', $data['point']);
        $getItems->execute();

        return $_POST;
    }
    public static function addItemToPoint($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM typeitems WHERE typeitems.item = :item AND typeitems.type = :point");
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->bindParam(':point', $data['point']);
        $getBalance->execute();
        $item = $getBalance->fetch(PDO::FETCH_BOTH);

        $newvalue = $item['count'] + $data['count'];
        $getItems = $db->prepare("UPDATE typeitems SET typeitems.count = :count WHERE typeitems.item = :item AND typeitems.type = :point");
        $getItems->bindParam(':count', $newvalue);
        $getItems->bindParam(':item', $data['item']);
        $getItems->bindParam(':point', $data['point']);
        $getItems->execute();

        return $_POST;
    }
    public static function addItemToStorage($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM storage WHERE storage.item = :item");
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->execute();
        $item = $getBalance->fetch(PDO::FETCH_BOTH);

        $newvalue = $item['count'] + $data['count'];
        $getItems = $db->prepare("UPDATE storage SET storage.count = :count WHERE storage.item = :item");
        $getItems->bindParam(':count', $newvalue);
        $getItems->bindParam(':item', $data['item']);
        $getItems->execute();

        return $_POST;
    }
    public static function delItemToStorage($data){
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM storage WHERE storage.item = :item");
        $getBalance->bindParam(':item', $data['item']);
        $getBalance->execute();
        $item = $getBalance->fetch(PDO::FETCH_BOTH);

        $newvalue = ($item['count']-$data['count']);
        $getItems = $db->prepare("UPDATE storage SET storage.count = :count WHERE storage.item = :item");
        $getItems->bindParam(':count', $newvalue);
        $getItems->bindParam(':item', $data['item']);
        $getItems->execute();

        return $_POST;
    }
    public static function getAllUsers()
    {
        $db = Db::Connection();

        $getAllUsers = $db->prepare("SELECT * FROM users");
        $getAllUsers->execute();
        $users = $getAllUsers->fetchAll(PDO::FETCH_BOTH);

        return $users;
    }
    public static function getAllStaffs()
    {
        $db = Db::Connection();
        $orders = Main::getStaffOrders();

        $getAllUsers = $db->prepare("SELECT * FROM users");
        $getAllUsers->execute();
        $users = $getAllUsers->fetchAll(PDO::FETCH_BOTH);

        $data = [];
        foreach ($users as $user){
            $type = Main::getType($user['type']);
            $data[$user['id']] = $user;
            $data[$user['id']]['orders'] = [];

            $data[$user['id']]['type'] = $type['title'];
            foreach ($orders as $order){
                if ($order['user'] == $user['id']){
                    $data[$user['id']]['orders'][] = $order;
                }
            }
        }


        return $data;
    }

    public static function getBalanceWeek($userid)
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.user = :user AND orders.createtime >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY AND orders.createtime < CURDATE() + INTERVAL (7 - WEEKDAY(CURDATE())) DAY LIMIT 25;");
        $getBalance->bindParam(':user', $userid);
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);
        $balance = 0;
        foreach ($orders as $order){
            $balance = $balance + $order['count'];
        }
        return $balance;
    }
    public static function getItem($itemid){

        $db = Db::Connection();
        $getItem = $db->prepare("SELECT * FROM items WHERE items.id = :item");
        $getItem->bindParam(':item', $item);
        $getItem->execute();
        $item = $getItem->fetch(PDO::FETCH_BOTH);

        return $item;

    }
    public static function getUserNickname($userid){

        $db = Db::Connection();
        $getUser = $db->prepare("SELECT * FROM users WHERE users.id = :userid");
        $getUser->bindParam(':userid', $userid);
        $getUser->execute();
        $user = $getUser->fetch(PDO::FETCH_BOTH);

        return $user['nickname'];

    }
    public static function getPointTitle($pointid){

        $db = Db::Connection();
        $getPoint = $db->prepare("SELECT * FROM types WHERE types.id = :point");
        $getPoint->bindParam(':point', $pointid);
        $getPoint->execute();
        $point = $getPoint->fetch(PDO::FETCH_BOTH);

        return $point['title'];

    }
    public static function getItemTitle($itemid){

        $db = Db::Connection();
        $getItem = $db->prepare("SELECT * FROM items WHERE items.id = :item");
        $getItem->bindParam(':item', $itemid);
        $getItem->execute();
        $item = $getItem->fetch(PDO::FETCH_BOTH);

        return $item['title'];

    }
    public static function getItems($type)
    {
        $db = Db::Connection();

        $getItems = $db->prepare("SELECT * FROM typeitems as ti WHERE ti.type = :type");
        $getItems->bindParam(':type', $type);
        $getItems->execute();
        $items = $getItems->fetchAll(PDO::FETCH_BOTH);
        $data = [];
        foreach($items as $item){
            $data[$item['id']] = $item;
            $data[$item['id']]['title'] = Main::getItemTitle($item['item']);
        }

        return $data;
    }
    public static function getItemCount($type, $item){

        $db = Db::Connection();
        $getItems = $db->prepare("SELECT * FROM typeitems as ti WHERE ti.type = :type AND ti.item = :item");
        $getItems->bindParam(':type', $type);
        $getItems->bindParam(':item', $item);
        $getItems->execute();
        $item = $getItems->fetch(PDO::FETCH_BOTH);

        return $item['count'];

    }
    public static function getButton($button){

        $db = Db::Connection();
        $getButton = $db->prepare("SELECT * FROM buttons WHERE buttons.id = :button");
        $getButton->bindParam(':button', $button);
        $getButton->execute();
        $result = $getButton->fetch(PDO::FETCH_BOTH);

        return $result;

    }
    public static function getOrder($orderid){

        $db = Db::Connection();
        $getOrder = $db->prepare("SELECT * FROM orders WHERE orders.id = :orderid");
        $getOrder->bindParam(':orderid', $orderid);
        $getOrder->execute();
        $result = $getOrder->fetch(PDO::FETCH_BOTH);

        return $result;

    }
//    public static function getItem($type, $item){
//
//        $db = Db::Connection();
//        $getItems = $db->prepare("SELECT * FROM typeitems as ti WHERE ti.type = :type AND ti.item = :item");
//        $getItems->bindParam(':type', $type);
//        $getItems->bindParam(':item', $item);
//        $getItems->execute();
//        return $item;
//
//    }
        public static function editItem($incdec ,$type , $count, $item)
    {

        $db = Db::Connection();
        $itemCount = Main::getItemCount($type, $item);
        if ($incdec == 'minus'){
            $count = $itemCount-$count;
            $getItems = $db->prepare("UPDATE typeitems as ti SET ti.count = :count WHERE ti.type = :type AND ti.item = :item");
            $getItems->bindParam(':count', $count);
            $getItems->bindParam(':type', $type);
            $getItems->bindParam(':item', $item);
            $getItems->execute();
        }else{
            $count = $itemCount+$count;
            $getItems = $db->prepare("UPDATE typeitems as ti SET ti.count = :count WHERE ti.type = :type AND ti.item = :item");
            $getItems->bindParam(':count', $count);
            $getItems->bindParam(':type', $type);
            $getItems->bindParam(':item', $item);
            $getItems->execute();
        }
        $data['incdec'] = $incdec;
        $data['type'] = $type;
        $data['count'] = $count;
        $data['item'] = $item;

        return $data;
    }
    public static function getClients($userid)
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.user = :user AND DATE(orders.createtime) = CURDATE()");
        $getBalance->bindParam(':user', $userid);
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);


        return count($orders);
    }
    public static function getStorage()
    {
        $db = Db::Connection();

        $getStorage = $db->prepare("SELECT * FROM storage");
        $getStorage->execute();
        $storage = $getStorage->fetchAll(PDO::FETCH_BOTH);
        $data = [];
        foreach ($storage as $store){
            $data[$store['id']] = $store;
            $data[$store['id']]['title'] = Main::getItemTitle($store['item']);
        }

        return $data;
    }
    public static function getStaffOrders()
    {
        $db = Db::Connection();
        $getStaffOrders = $db->prepare("SELECT * FROM orders WHERE DATE(orders.createtime) = CURDATE()");
        $getStaffOrders->execute();
        $orders = $getStaffOrders->fetchAll(PDO::FETCH_BOTH);
        return $orders;
    }
    public static function getUserOrders($userid)
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.user = :user AND DATE(orders.createtime) = CURDATE() ORDER BY orders.createtime DESC");
        $getBalance->bindParam(':user', $userid);
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);
        $user = Main::getUser($userid);
        $types = Main::getAllTypes();
        $data = array();
        foreach ($orders as $order){
            $typesIds = array_column($types, 'id');
            $typeIndex = array_search($order['type'], $typesIds);
            $type = $types[$typeIndex];
            $order['user'] = $user;
            $order['type'] = $type;
            $data[] = $order;
        }

        return $data;
    }
    public static function getAllOrders()
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE DATE(orders.createtime) = CURDATE()");
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);
        $users = Main::getAllUsers();
        $types = Main::getAllTypes();
        $data = array();
        foreach ($orders as $order){
            $userIds = array_column($users, 'id');
            $typesIds = array_column($types, 'id');
            $index = array_search($order['user'], $userIds);
            $typeIndex = array_search($order['type'], $typesIds);
            $user = $users[$index];
            $type = $types[$typeIndex];
            $order['user'] = $user;
            $order['type'] = $type;

            $data[] = $order;
        }

        return $data;
    }
    public static function getAllClients()
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE DATE(orders.createtime) = CURDATE()");
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);


        return count($orders);
    }
    public static function getAllBalance()
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.beznal = 1 AND DATE(orders.createtime) = CURDATE()");
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);

        $balance = 0;
        foreach ($orders as $order){
            $balance = $balance + $order['count'];
        }
        return $balance;
    }
    public static function getAllBalanceNal()
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.beznal = 0 AND DATE(orders.createtime) = CURDATE()");
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);

        $balance = 0;
        foreach ($orders as $order){
            $balance = $balance + $order['count'];
        }
        return $balance;
    }
    public static function getBalance($userid)
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.user = :user AND orders.beznal = 1 AND DATE(orders.createtime) = CURDATE()");
        $getBalance->bindParam(':user', $userid);
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);

        $balance = 0;
        foreach ($orders as $order){
            $balance = $balance + $order['count'];
        }
        return $balance;
    }
    public static function getBalanceNal($userid)
    {
        $db = Db::Connection();

        $getBalance = $db->prepare("SELECT * FROM orders WHERE orders.user = :user AND orders.beznal = 0 AND DATE(orders.createtime) = CURDATE()");
        $getBalance->bindParam(':user', $userid);
        $getBalance->execute();
        $orders = $getBalance->fetchAll(PDO::FETCH_BOTH);

        $balance = 0;
        foreach ($orders as $order){
            $balance = $balance + $order['count'];
        }
        return $balance;
    }

    public static function getType($usertype)
    {
        $db = Db::Connection();

        $getType = $db->prepare("SELECT * FROM types WHERE types.id = :btype ");
        $getType->bindParam(':btype', $usertype);
        $getType->execute();
        $type = $getType->fetch(PDO::FETCH_BOTH);
        return $type;
    }
    public static function getButtons($type)
    {
        $db = Db::Connection();

        $getButtons = $db->prepare("SELECT * FROM buttons WHERE buttons.type = :btype ORDER BY buttons.count ASC");
        $getButtons->bindParam(':btype', $type);
        $getButtons->execute();
        $button = $getButtons->fetchAll(PDO::FETCH_BOTH);
        return $button;
    }
    public static function getUserByNN($nickname)
    {
        $db = Db::Connection();

        $getUser = $db->prepare("SELECT * FROM users WHERE users.nickname = :nick");
        $getUser->bindParam(':nick', $nickname);
        $getUser->execute();
        $user = $getUser->fetch(PDO::FETCH_BOTH);
        return $user;
    }
    public static function getUserByID($userid)
    {
        $db = Db::Connection();

        $getUser = $db->prepare("SELECT * FROM users WHERE users.id = :userid");
        $getUser->bindParam(':userid', $userid);
        $getUser->execute();
        $user = $getUser->fetch(PDO::FETCH_BOTH);
        return $user;
    }
    public static function getUser($userid)
    {
        $db = Db::Connection();

        $getUser = $db->prepare("SELECT * FROM users WHERE users.id = :userid");
        $getUser->bindParam(':userid', $userid);
        $getUser->execute();
        $user = $getUser->fetch(PDO::FETCH_BOTH);
        return $user;
    }


    public static function createOrder($data)
    {
        $db = Db::Connection();

        $getButton = $db->prepare("SELECT * FROM buttons WHERE buttons.id = :butid");
        $getButton->bindParam(':butid', $data['button']);
        $getButton->execute();
        $button = $getButton->fetch(PDO::FETCH_BOTH);

        var_dump($button);
        $addOrder = $db->prepare("INSERT INTO orders (`type`, `user`, `count`, `beznal`, `item`) VALUES (:type, :user, :count, :beznal, :item)");
        $addOrder->bindParam(':type', $data['type']);
        $addOrder->bindParam(':user', $data['user']);
        $addOrder->bindParam(':count', $button['count']);
        $addOrder->bindParam(':beznal', $data['beznal']);
        $addOrder->bindParam(':item', $button['item']);
        $addOrder->execute();

        return true;
    }
    public static function delOrder($data){
        $db = Db::Connection();

        $addOrder = $db->prepare("DELETE FROM orders WHERE orders.id = :orderid AND orders.user = :userid");
        $addOrder->bindParam(':orderid', $data['orderid']);
        $addOrder->bindParam(':userid', $data['user']);
        $addOrder->execute();
    }
    public static function setType($data)
    {
        $db = Db::Connection();

        $addOrder = $db->prepare("UPDATE users SET users.type = :type WHERE users.id = :user");
        $addOrder->bindParam(':type', $data['type']);
        $addOrder->bindParam(':user', $data['user']);
        $addOrder->execute();

        return true;
    }
	public static function checkUser($nickname,$password){

		if (!empty($nickname)) {
			
			$db = Db::Connection();

			$getUser = $db->prepare("SELECT * FROM users WHERE users.nickname = :nickname");
			$getUser->bindParam(':nickname',$nickname);
			$getUser->execute();
			$user = $getUser->fetch(PDO::FETCH_BOTH);

			if (!empty($user['id'])) {
				if ($user['password'] == $password) {
                    $_SESSION['user']['id'] = $user['id'];
                    $_SESSION['user']['nickname'] = $user['nickname'];
					$resp = 'Success';

				}else{
					$resp = 'Логин или пароль указанны неверно.';
				}

			}else{
				$resp = 'Данный пользователь не найден';
			}
				
			

			return $resp;
		}
	}

	public static function Auth($data){

		if (!empty($data)) {
			
			$db = Db::Connection();

			$getUser = $db->prepare("SELECT * FROM users WHERE users.userid = :userid");
			$getUser->bindParam(':userid',$data['userid']);
			$getUser->execute();
			$user = $getUser->fetch(PDO::FETCH_BOTH);


			if ($user['password'] == $data['password']) {
				$_SESSION['userid'] = $data['userid'];
				print_r('success');
			}else{
				print_r('Логин или пароль указанны неверно.');
			}
			return $user;
		}
	}

	public static function Logout(){

		
		session_destroy();

		header('Location: /');
		exit;
	}

}