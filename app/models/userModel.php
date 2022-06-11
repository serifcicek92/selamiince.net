<?php 
namespace App\Models;

use App\System\Application;
use App\System\Model;

class User extends Model{

	/**
	 *
	 * @return array
	 */
	function rules(): array {
        return [];
    }
    
    public function insert($values)
    {
        print_r($values);exit;
    }
    public function update($values)
    {
        
    }
    public function delete($id)
    {
        
    }
    public function get($values)
    {
        
    }
    public function login($params = [])
    {
        $status = $this->db->prepare("call sel_users(null,:email,null)");
        $status->bindValue(':email',$params["email"]);
        // $status->bindValue(':password',password_hash($params["password"],PASSWORD_DEFAULT));
        $status->execute();
        $result = $status->fetch(\PDO::FETCH_ASSOC);
        $status->closeCursor();
        
        if ($result && password_verify(md5($params["password"]),$result["password"])) {
            $this->userId = $result["id"];
            $this->email = $result["email"];
            $this->firstName = $result["firstname"];
            $this->lastName = $result["lastname"];
            
            if (isset($params["remember"]) && $params["remember"]=="on") 
            {
                $this->db->prepare("DELETE FROM userremembers where userid = $this->userId")->execute();
                $this->remembertoken = bin2hex(openssl_random_pseudo_bytes(32));
                $remember = $this->db->prepare("INSERT INTO userremembers set userid = :userid, remembertoken = :remembertoken,expiretime = :expiretime, userbrowser=:userbrowser");
                $remember->execute(array(
                    "userid" => $this->userId,
                    "remembertoken" => $this->remembertoken,
                    "expiretime" => time()+604800,
                    "userbrowser" => md5($_SERVER["HTTP_USER_AGENT"])
                ));

                setcookie("REMEMBERAGS",$this->remembertoken,time()+604801,'/');
            }
            return $this;
        }
        else {

            return false;
        }

    }
    public function getUserRemembers($cooktoken,$browser)
    {
        $time = time();

        return $this->db->query("SELECT * FROM userremembers where remembertoken ='{$cooktoken}' and userbrowser = '$browser' and expiretime > $time")->fetch(\PDO::FETCH_ASSOC);
    }
    public function getUserList($userid = null,$email = null)
    {
       
        $status = $this->db->prepare("call sel_users_list(:id,:mail)");
        $status->bindValue(":id",$userid,($userid==null ? \PDO::PARAM_NULL : \PDO::PARAM_INT));
        $status->bindValue(":mail",$email,($email == null ? \PDO::PARAM_NULL : \PDO::PARAM_STR));
        $status->execute();
        $result = $status->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkLogin()
    {
        $user = $this;
        
        if (!isset($_SESSION["AGSLOGIN"]) || $_SESSION["AGSLOGIN"]["SESSION"] != "ACTIVE") {
            if (isset($_COOKIE["REMEMBERAGS"]) && $_COOKIE["REMEMBERAGS"] != 'false') {
                $cooktoken = $_COOKIE["REMEMBERAGS"];
                $browser = md5($_SERVER['HTTP_USER_AGENT']);
                $result = $user->getUserRemembers($cooktoken,$browser);
                if ($result) {
                    $cookieUser = $result["userid"];
                    $checkUser = $user->getUserList($cookieUser, null);
                    
                    if ($checkUser) {
                        $user->userId = $checkUser[0]["id"];
                        $user->email = $checkUser[0]["email"];
                        $user->firstName = $checkUser[0]["firstname"];
                        $user->lastName = $checkUser[0]["lastname"];
                        $_SESSION["AGSLOGIN"]["firstname"] = $user->firstName;
                        $_SESSION["AGSLOGIN"]["SESSION"] = "ACTIVE";
                        $_SESSION["AGSLOGIN"]["USERID"] = $user->userId;
                        
                        return true;
                    }
                    else
                    {
                        setcookie("REMEMBERAGS",'false',time()-3600,'/');
                        return false;
                        //header('Location:'.SITEADRESS.'login');
                    }
                }
                else
                {
                    setcookie("REMEMBERAGS",'false',time()-3600,'/');
                    //header('Location:'.SITEADRESS.'login');
                    return false;

                }
            }
            else 
            {
                setcookie("REMEMBERAGS",'false',time()-3600,'/');
                //header('Location:'.SITEADRESS.'login');
                return false;
            }
        }
        else 
        {
            return true;
        }
    }

    public function UserVisits($visitip)
    {
        try {
            //Tarayıcı Bilgisi
            $u_agent = $_SERVER['HTTP_USER_AGENT']; 
            // ip adresini al ve değişkene ata
            // $ip_adresi = Application::$app->functions->GetIP();
            $ip_adresi = $visitip;
            // geoplugin.net adresine ip adresini ilet ve diğer bilgilere ulaşım sağla
            // $uzak_adres = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_adresi));
            
            
            $url = "http://www.geoplugin.net/php.gp?ip=".$ip_adresi;
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $url);
            $uzak_adres = unserialize(curl_exec($c));
            curl_close($c);

            
            
            // Şehir dönen değeri değişkene ata
            $sehir = $uzak_adres['geoplugin_city'];
            // Ülke dönen değeri değişkene ata
            $ulke = $uzak_adres['geoplugin_countryName'];

            $region =  $uzak_adres['geoplugin_region'];
            $area =  $uzak_adres['geoplugin_areaCode'];
            // var_dump($uzak_adres);

            $status = $this->db->prepare("call save_uservisit(:luseragent,:luserip,:lusercity,:lusercountry,:lregion,:larea)");
            $status->bindValue(":luseragent",$u_agent);
            $status->bindValue(":luserip",$ip_adresi);
            $status->bindValue(":lusercity",$sehir);
            $status->bindValue(":lusercountry",$ulke);
            $status->bindValue(":lregion",$region);
            $status->bindValue(":larea",$area);
            $status->execute();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}