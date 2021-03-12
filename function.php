<?php
    function make_avatar($character)
        {
            $path='avatar/'.time().'.png';
            $image=imagecreate(200,200);
            $red=rand(0,255);
            $green=rand(0,255);
            $blue=rand(0,255);
            imagecolorallocate($image, $red, $green, $blue);
            $textcolor=imagecolorallocate($image,255,255,255);
            imagettftext($image,100,0,55,150,$textcolor,realpath("ARIALBD.TTF"),$character);
            header('Content-type:image/png');
            imagepng($image,$path);
            imagedestroy($image);
            return $path;
        }
    function Get_user_avatar($user_id, $connect){
        $query="SELECT user_avatar FROM register_user WHERE register_user_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($user_id));
        $result=$statement->fetchAll();
        foreach($result as $row){
            echo '<img style="border-radius:50px;" src="'.$row["user_avatar"].'" width="45" height="20" class="img-thumbnail img-circle"/>';
        }
    }
    function load_country_list(){
        $output='';
        $countries=array(                    
"Afghanistan","Afrique du Sud",	"Albanie","Algérie","Allemagne","Andorre","Angola","Anguilla","Antigua-et-Barbuda","Antilles Néerlandaises","Arabie Saoudite","Argentine",
"Arménie","Aruba","Australie","Autriche","Azerbaïdjan","Bahamas","Bahreïn","Bangladesh","Barbade","Belgique","Belize","Bénin","Bermudes","Bhoutan","Biélorussie","Birmanie","Bolivie","Bosnie-Herzégovine",
"Botswana",	"Brésil","Brunei","Bulgarie","Burkina Faso","Burundi","Cambodge","Cameroun","Canada",
"Cap-vert","Chili","Chine","Chypre","Colombie","Comores","Corée du Nord","Corée du Sud","Costa Rica","Côte d'Ivoire","Croatie","Cuba","Danemark","Djibouti","Dominique",
"Égypte","Émirats Arabes Unis","Équateur","Érythrée","Espagne","Estonie","États Fédérés de Micronésie","États-Unis","Éthiopie","Fidji","Finlande","France",
"Gabon","Gambie","Géorgie","Géorgie du Sud et les Îles Sandwich du Sud","Ghana","Gibraltar","Grèce","Grenade","Groenland","Guadeloupe","Guam","Guatemala","Guinée","Guinée-Bissau","Guinée Équatoriale",
"Guyana","Guyane Française","Haïti","Honduras","Hong-Kong","Hongrie","Île Christmas","Île de Man","Île Norfolk","Îles Åland","Îles Caïmanes","Îles Cocos","Îles Cook",
"Îles Féroé","Îles Malouines","Îles Mariannes du Nord","Îles Marshall","Îles Pitcairn","Îles Salomon","Îles Turks et Caïques","Îles Vierges Britanniques","Îles Vierges des États-Unis","Inde","Indonésie",
"Iran","Iraq","Irlande","Islande","Israël","Italie","Jamaïque","Japon","Jordanie","Kazakhstan","Kenya","Kirghizistan",",Kiribati","Koweït","Laos","Le Vatican","Lesotho","Lettonie",
"Liban","Libéria","Libye","Liechtenstein","Lituanie","Luxembourg","Macao","Madagascar","Malaisie","Malawi","Maldives","Mali","Malte","Maroc","Martinique","Maurice","Mauritanie","Mayotte",
"Mexique","Moldavie","Monaco","Mongolie","Monténégro","Montserrat","Mozambique","Namibie","Nauru","Népal","Nicaragua","Niger","Nigéria","Niué","Norvège","Nouvelle-Calédonie","Nouvelle-Zélande","Oman",
"Ouganda","Ouzbékistan","Pakistan","Palaos","Panama","Papouasie-Nouvelle-Guinée","Paraguay","Pays-Bas","Pérou","Philippines","Pologne","Polynésie Française","Porto Rico","Portugal","Qatar",
"République Centrafricaine","République de Macédoine","République Démocratique du Congo","République Dominicaine","République du Congo","République Tchèque","Réunion","Roumanie","Royaume-Uni",
"Russie","Rwanda","Sahara Occidental","Saint-Kitts-et-Nevis","Saint-Marin","Saint-Pierre-et-Miquelon","Saint-Vincent-et-les Grenadines","Sainte-Hélène","Sainte-Lucie","Salvador","Samoa","Samoa Américaines",
"Sao Tomé-et-Principe","Sénégal","Serbie","Seychelles","Sierra Leone","Singapour","Slovaquie","Slovénie","Somalie","Soudan","Sri Lanka","Suède","Suisse	Suriname","Svalbard et Jan Mayen",
"Swaziland","Syrie","Tadjikistan","Taïwan","Tanzanie","Tchad","Terres Australes Françaises","Thaïlande","Timor Oriental","Togo","Tonga","Trinité-et-Tobago","Tunisie","Turkménistan","Turquie",
"Tuvalu","Ukraine","Uruguay","Vanuatu","Venezuela","Viet Nam","Wallis et Futuna","Yémen","Zambie","Zimbabwe");

        foreach($countries  as $country)
        {
            $output .='<option value="'.$country.'">'.$country.'</option>s';
        }
        return $output;

    }

function Get_user_profile_data_html($user_id,$connect){
    $query=$connect->prepare("SELECT * FROM register_user WHERE register_user_id='".$user_id."'"); 
    $query->execute();
    $output ='
    <div class="table-responsive">
        <table class="table">
';
while($row=$query->fetch()){
    
        $output .='
            <tr>
                <td colspan="2" align="center" style="padding:16px 0">
                <img style="border-radius:200px;" src="'.$row["user_avatar"].'" width="175" class="img-thumbnail img-circle"/>
            </tr>
        <tr>
            <th>Name</th>  
            <td>'.$row["user_name"].'</td>
        </tr>
        <tr>
            <th>Email</th>  
            <td>'.$row["user_email"].'</td>
        </tr>
        <tr>
        <th>Gender</th>  
        <td>'.$row["user_gender"].'</td>
    </tr>
    <tr>
    <th>Address</th>  
    <td>'.$row["user_address"].'</td>
</tr>
<tr>
<th>City</th>  
<td>'.$row["user_city"].'</td>
</tr>
<tr>
<th>Zip </th>  
<td>'.$row["user_zipcode"].'</td>
</tr>
<tr>
<th>State</th>  
<td>'.$row["user_state"].'</td>
</tr>
<tr>
<th>Country</th>  
<td>'.$row["user_country"].'</td>
</tr>';
}
$output .='</table>
</div>';
return $output;
}
function wrap_tag($argument){
    return '<b>'.$argument.'</b>';
}
function Get_request_status($connect,$from_user_id,$to_user_id){
    $output='';
    $query="SELECT request_status FROM friend_request WHERE (request_from_id='".$from_user_id."' AND request_to_id ='".$to_user_id."') OR (request_from_id='".$to_user_id."' AND request_to_id ='".$from_user_id."') AND request_status != 'Confirm'"; 
    $result=$connect->prepare($query);
    $result->execute();
    //$result=$result->fetchAll();//
    foreach($result as $row){
        $output=$row["request_status"];
    }
    return $output;
}
function Get_user_profile_data($user_id,$connect)
{
    $query="SELECT * FROM register_user WHERE register_user_id='".$user_id."'";
    return $connect->query($query);

    
}
function Get_user_avatar_big($user_id, $connect)
{
    $query = "
    SELECT user_avatar FROM register_user 
    WHERE register_user_id = '".$user_id."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return '<img width="45" style="border-radius:100px" src="'.$row['user_avatar'].'" class="img-responsive img-circle" />';
    }
}
function Get_user_name($connect,$user_id){
    $query="SELECT user_name FROM register_user WHERE register_user_id='".$user_id."'";
    $result=$connect->query($query);
    foreach($result as $row){
        return $row["user_name"];
    }
}
function clean_text($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
function get_date(){
    return date("Y-m-d").' '.date("H:i:s",STRTOTIME(date('h:i:sa')));
}
function file_get_contents_url($url){
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data= curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
