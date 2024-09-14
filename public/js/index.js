let num = 0;
import { normalize } from 'https://cdn.skypack.dev/@geolonia/normalize-japanese-addresses';

        // var phpArray = <?php echo $json_list; ?>;
        
        // Use the JavaScript array
        // let uname = phpArray.map(subArray => subArray[2]); //username
        let logo_img_path = phpArray.map(subArray => subArray[3]); //user_logo_img_path
        let b_name = phpArray.map(subArray => subArray[8]); // buildingname
        let Address = phpArray.map(subArray => subArray[9]); // building address
        let design_code = phpArray.map(subArray => subArray[5]); //design_code
        let dc_img_path = phpArray.map(subArray => subArray[6]); //design_code_img_path
        let img = phpArray.map(subArray => subArray[10])

        console.log(uname[0], 'uname');
        console.log(b_name[0], 'building_name');
        console.log(Address[0], 'Address');
        console.log(design_code[0], 'Design_code');
        console.log(img[0], 'img');

//データ登録(Click)

// let infoWindow = [];
// let markerData = [];// マーカーを立てる場所名・緯度・経度
for(let i=0; i<uname.length;i++){

normalize(Address[i]).then(result=>{
    console.log(result, "result")
markerData.push({
       name: uname[i],
       Building_name: b_name[i],
       address: Address[i],
       design_code: design_code[i],
       dc_image: dc_img_path[i],
       lat: result.lat,
       lng: result.lng,
       icon: logo_img_path[i]
    //    icon: img[i]
 })
 console.log(dc_img_path,"dc_img_path")
//  console.log(markerData,"AFTER PUSH")
 img_src.push(img[i]);
//  img_src.push(logo_img_path[i]);
// console.log(result.lat,'result.lat')
// console.log(markerData.length, i ,"markerData and i")


if(i==uname.length-1){
    initMap();
    console.log(markerData.length,"OK")
    console.log(img_src.length,"img_src.length")
    }
})
}


//地図更新イベント
$("#refresh_map").on("click",function(){
    console.log(markerData.length);
    for(let i=1;i<markerData.length;i++){
        if($("#sort_by").val()=="Name"){

            img_src[i] = img[i-1];
            // console.log(markerData[i]['icon'],'markerData[icon]')
            
             }else if($("#sort_by").val()=="Design_Code"){
                
               img_src[i] = dc_img_path[i-1];
                console.log(markerData[i]['icon'],'markerData[icon]')
             }

    if(i==markerData.length-1){
    initMap();
    console.log(markerData.length,"OKOK")
    console.log(img_src,"img_src")
    console.log(dc_img_path,"img_src")
    }
    
}
})