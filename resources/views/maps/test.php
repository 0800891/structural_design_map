<?php
session_start();
require_once('funcs.php');
loginCheck();

$table = [];

$pdo = db_conn();
//２．データ取得SQL作成
if(isset($_SESSION['kanri'])){
  if($_SESSION['kanri']=== 1 ){
$stmt = $pdo->prepare("SELECT 
                            gs_bm_table_r1.id as id,
                            gs_bm_table_r1.user_id as u_id,
                            gs_user_table.name as user_name,
                            gs_user_table.img as logo_img_path,
                            gs_bm_table_r1.building_id as b_id,
                            gs_bm_table_r1.design_code_id as d_id,
                            gs_design_code_table.name as design_code,
                            gs_design_code_table.img as map_img_path,
                            gs_building_table.name as name,
                            gs_building_table.address as address,
                            gs_building_table.image_path as image_path,
                            gs_building_table.date as date
                        FROM gs_bm_table_r1
                        JOIN gs_building_table
                          ON gs_bm_table_r1.building_id = gs_building_table.id
                        JOIN gs_user_table
                          ON gs_bm_table_r1.user_id = gs_user_table.id
                        JOIN gs_design_code_table
                          ON gs_bm_table_r1.design_code_id = gs_design_code_table.dc_id;"
                          );
  }else{
    // $stmt = $pdo->prepare("SELECT * FROM gs_bm_table_r1 WHERE user_id=:user_id");
    $stmt = $pdo->prepare("SELECT 
                            gs_bm_table_r1.id as id,
                            gs_bm_table_r1.user_id as u_id,
                            gs_user_table.name as user_name,
                            gs_user_table.img as logo_img_path,
                            gs_bm_table_r1.building_id as b_id,
                            gs_bm_table_r1.design_code_id as d_id,
                            gs_design_code_table.name as design_code,
                            gs_design_code_table.img as map_img_path,
                            gs_building_table.name as name,
                            gs_building_table.address as address,
                            gs_building_table.image_path as image_path,
                            gs_building_table.date as date
                        FROM gs_bm_table_r1
                        JOIN gs_building_table
                            ON gs_bm_table_r1.building_id = gs_building_table.id
                        JOIN gs_user_table
                          ON gs_bm_table_r1.user_id = gs_user_table.id
                        JOIN gs_design_code_table
                          ON gs_bm_table_r1.design_code_id = gs_design_code_table.dc_id
                          WHERE gs_bm_table_r1.user_id = :user_id;");
    $user_id = $_SESSION['user_id'];
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  }
}

$status = $stmt->execute();

//３．データ表示
$view="";
$view2="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  // $error = $stmt->errorInfo();
  // exit("ErrorQuery:".$error[2]);
    sql_error($stmt);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // view
    array_push($table,[$result['id'],$result['u_id'],$result['user_name'],$result['logo_img_path'],$result['b_id'],$result['d_id'],$result['map_img_path'],$result['design_code'],$result['name'],$result['address'],$result['image_path'],$result['date']]);
    if(isset($_SESSION['kanri'])){
    if($_SESSION['kanri']=== 1){  
      $view .= "<tr  style = 'border:1px solid #333;'>";
      $view .= '<td  style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">';
      $view .= h($result['id']) . '</a></td>' ;
      $view .= '<td style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">' . h($result['u_id']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">' . h($result['user_name']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['logo_img_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['b_id']) .  '</td>' ;
      $view .= '<td id="d_id" style = "border:1px solid #333;">' . h($result['d_id']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['design_code']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['map_img_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td id="text_building_name" style = "border:1px solid #333;">' . h($result['name']) .  '</td>' ;
      $view .= '<td id="Address" style = "border:1px solid #333;">' . h($result['address']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['image_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td type="hidden" id="" style = "border:1px solid #333;">' . $result['image_path'] . '</td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['date']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><a href = delete.php?id=imgUpload' . h($result['id']) .  '>delete</a></td>' ;
      $view .= "</tr>";
  }else{
      $view .= '<tr style = "border:1px solid #333;">';
      $view .= '<td style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">';
      $view .= h($result['id']) . '</a></td>' ;
      $view .= '<td style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">' . h($result['u_id']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><a href = "detail.php?id=' . h($result['id']) .'">' . h($result['user_name']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['logo_img_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['b_id']) .  '</td>' ;
      $view .= '<td id="d_id" style = "border:1px solid #333;">' . h($result['d_id']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['design_code']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['map_img_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td id="text_building_name" style = "border:1px solid #333;">' . h($result['name']) .  '</td>' ;
      $view .= '<td id="Address" style = "border:1px solid #333;">' . h($result['address']) .  '</td>' ;
      $view .= '<td style = "border:1px solid #333;"><img src ="' . $result['image_path'] . '"alt = "" width="40%" height="40%"></td>' ;
      $view .= '<td type="hidden" id="" style = "border:1px solid #333;">' . $result['image_path'] . '</td>' ;
      $view .= '<td style = "border:1px solid #333;">' . h($result['date']) .  '</td>' ;
      // $view .= '<td><a href = delete.php?id=imgUpload' . h($result['id']) .  '>delete</a></td>' ;
      $view .= "</tr>";

  }}
  }
  
// view2    
    if(isset($_SESSION['kanri'])){
    if($_SESSION['kanri']=== 1){ 
      $view2 .= "<tr style = 'border:1px solid #333;'>";
      $view2 .= "<td style = 'border:1px solid #333;'>id</td>";
      $view2 .= "<td style = 'border:1px solid #333;'>user_id</td>";
      $view2 .= "<td style = 'border:1px solid #333;'>user_name</td>";
      $view2 .= "<td style = 'border:1px solid #333;'>logo_img_path</td>";
      $view2 .= "<td style = 'border:1px solid #333;'>building_id</td>";
      $view2 .= '<td style = "border:1px solid #333;">design_code_id</td>' ;
      $view2 .= '<td style = "border:1px solid #333;">design_code</td>' ;
      $view2 .= '<td style = "border:1px solid #333;">design_code_img</td>' ;
      $view2 .= '<td style = "border:1px solid #333;">name</td>'; 
      $view2 .= '<td style = "border:1px solid #333;">address</td>' ;
      $view2 .= '<td style = "border:1px solid #333;">image</td>' ;
      $view2 .= '<td style = "border:1px solid #333;">img_path</td>';
      $view2 .= '<td style = "border:1px solid #333;">Date</td>';
      // $view2 .= '<td><a href = resetid.php? id=' . $result['id'] .  '>id_Reset</a></td>' ;
      $view2 .= '<td style = "border:1px solid #333;"><a href = resetid.php? >id_Reset</a></td>' ;
      $view2 .= "</tr>";
  }else{
    $view2 .= "<tr style = 'border:1px solid #333;'>";
    $view2 .= "<td style = 'border:1px solid #333;'>id</td>";
    $view2 .= "<td style = 'border:1px solid #333;'>user_id</td>";
    $view2 .= "<td style = 'border:1px solid #333;'>user_name</td>";
    $view2 .= "<td style = 'border:1px solid #333;'>building_id</td>";
    $view2 .= '<td style = "border:1px solid #333;">design_code_id</td>' ;
    $view2 .= '<td style = "border:1px solid #333;">design_code</td>' ;
    $view2 .= '<td style = "border:1px solid #333;">design_code_img</td>' ;
    $view2 .= '<td style = "border:1px solid #333;">name</td>'; 
    $view2 .= '<td style = "border:1px solid #333;">address</td>' ;
    $view2 .= '<td style = "border:1px solid #333;">image</td>' ;
    $view2 .= '<td style = "border:1px solid #333;">img_path</td>';
    $view2 .= '<td style = "border:1px solid #333;">Date</td>';
    $view2 .= "</tr>";
  }

}
// var_dump($table);
$json_list = json_encode( $table );
// var_dump($json_list);
  }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/common.css">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
<?php include('header.php');?>
  <!-- <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav> -->
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<label>ユーザー名：<p border = "1" class = "text-[20px] text-blue-600" id="uname" ><?= $_SESSION['user_name']; ?></p></label>
<div ><button id="back" class="border-solid border-2 border-indigo-600">登録画面に戻る</button></div>
<div>
  <table width="80%" border = "1" style = "border:1px solid #333;" class="border-solid border-1 border-black-600">

    <?= $view2 ?>
    <div class="container jumbotron">
      <a href="detail.php"></a>
      <?= $view ?>
    </div>
</div>
<div>
            <select name="Sort_by" id="sort_by" class="border-solid border-2 border-indigo-600">
              <option value="">Display by</option>
              <option value="Name">Building</option>
              <option value="Design_Code">Design_Code</option>
            </select>  
 </div>
<div class="small_buttons">
<button id="send" class="border-solid border-2 border-indigo-600">地図表示</button>
      <button id="refresh_map" class="border-solid border-2 border-indigo-600">地図更新</button>
      <!-- <button id="delete">削除</button> -->
</div>

<div id="map" style="height: 600px; width: 100%;"></div>
<!-- Main[End] -->

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$("#back").on("click", function(){
    window.location.href = 'index.php';

    })
</script>
<script>
         // Dispatch  Jason data defined in above php to js.
          let phpArray = <?php echo $json_list; ?>;
        
 

    let marker = [];
    let infoWindow = [];
    let markerData = [];// マーカーを立てる場所名・緯度・経度
    markerData[0] =  {
           name: 'test',
           Building_name:'test',
           address:'東京都江東区東陽1-1-1',
           design_code:'EURO_Code',
           dc_image:'img/map/code/EU.jpeg',
           lat: 35.6954806,
          //  lat: 35.60,
           lng: 139.76325010000005,
           icon: 'img/SENS_LOGO_00.png' // TAM 東京のマーカーだけイメージを変更する
     }
    
    let img_src = [];
    img_src[0] = 'img/SENS_LOGO_00.png' ;
    
    function initMap() {
      console.log("initMap")
     // 地図の作成
     if(markerData.length===1){

      console.log("initMap_type1")
        var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); // 緯度経度のデータ作成
       map = new google.maps.Map(document.getElementById('map'), { // #mapに地図を埋め込む
         center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
       })} else {
        console.log("initMap_type2")
        var mapLatLng = new google.maps.LatLng({lat: markerData.slice(-1)[0]['lat'], lng: markerData.slice(-1)[0]['lng']}); // 緯度経度のデータ作成
       map = new google.maps.Map(document.getElementById('map'), { // #mapに地図を埋め込む
         center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
          });
       }
     
     // マーカー毎の処理
     for (var i = 1; i < markerData.length; i++) {
      console.log("markerData.length:",markerData.length)
            markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
            marker[i] = new google.maps.Marker({ // マーカーの追加
             position: markerLatLng, // マーカーを立てる位置を指定
            //  content: pinViewBackground,
                map: map // マーカーを立てる地図を指定
                
           });
           temp =  markerData[i]['name']+'<img src='+markerData[i]['icon']+' style="width:20%">';
           for (var j=0;j < i; j++){
              
                if(markerData[j]['Building_name']==markerData[i]['Building_name']){
                    temp = temp + '<br>' + markerData[j]['name']+'<div><img src='+markerData[j]['icon']+' style="width:20%"></div>'
                  }
                // }}}
                
              
            }
            console.log(temp,"temp")
         infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加

            //  content: '<div class="map"> 構造設計者名:' + markerData[i]['name'] + '</div>'+'<div>建物名称:'+markerData[i]['text']+'</div>'+'<div>Structural Design Code:'+markerData[i]['design_code']+'</div>'+'<div><img src='+img_src[i]+' style="width:50%"></div>' // 吹き出しに表示する内容

            content: '<div>建物名称:'+markerData[i]['Building_name']+'</div>'+'<div>Structural Design Code:'+markerData[i]['design_code']+ '<img src=' + markerData[i]['dc_image'] +' style="width:50%"></div>'+' <div class="map"> 構造設計者名:<br>' + temp + '</div>' // 吹き出しに表示する内容
               
              });
            marker[i].setOptions({// TAM 東京のマーカーのオプション設定
            icon: {
            //  url: markerData[i]['icon'],
             url:img_src[i],
             scaledSize: new google.maps.Size(30, 30)
            },
              optimized: false 
          });
         markerEvent(i); // マーカーにクリックイベントを追加
     }
     
    //    marker[0].setOptions({// TAM 東京のマーカーのオプション設定
    //         icon: {
    //          url: markerData[0]['icon'],// マーカーの画像を変更
    //          scaledSize: new google.maps.Size(30, 30)
    // 	},
        // optimized: false 
      //  });
      function markerEvent(i) {
        marker[i].addListener('click', function() { // マーカーをクリックしたとき
          infoWindow[i].open(map, marker[i]); // 吹き出しの表示
      });
    }
    }
</script>
<script type="module" src="js/index.js"></script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAigcmJ1gURHEpSehyx5H7ORK5llDODYRo&callback=initMap" >
</script>
</html>