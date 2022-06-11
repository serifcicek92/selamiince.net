<?php 
namespace App\Models;
use App\System\Model;
use App\System\Application;
use Exception;
use PDO;

class Propertie extends Model{
    public $baslik = "";
    public $metrekare = "";
    public $mulktipi = "";
    public $teklifturu = "";
    public $adres = "";
    public $il = "";
    public $ilce = "";
    
    
    
    
    /**
	 *
	 * @return array
	 */
	function rules() : array {
        return [
            'baslik'=>[self::RULE_REQUIRED],
            'metrekare'=>[self::RULE_REQUIRED],
            'mulktipi'=>[self::RULE_REQUIRED],
            'teklifturu'=>[self::RULE_REQUIRED],
            'adres'=>[self::RULE_REQUIRED],
            'il'=>[self::RULE_REQUIRED],
            'ilce'=>self::RULE_REQUIRED
        ];
	}

    public function insert($values)
    {
        try {
            $status = $this->db->prepare("call in_propertie(@lid,:lbaslik,:laciklama,:lfiyat,:lodasayisi,:lbanyosayisi,:lkatbilgisi,:lbinayasi,:lmetrekare,
            :lmulktipi,:lteklifturu,:ladres,:lil,:lilce,:lsemt,:lanasayfadagoster)");
            
            $status->bindValue(':lbaslik',$values["baslik"]);
            $status->bindValue(':laciklama',$values["aciklama"]);
            $status->bindValue(':lfiyat',$values["fiyat"]);
            $status->bindValue(':lodasayisi',$values["odasayisi"]);
            $status->bindValue(':lbanyosayisi',$values["banyosayisi"]);
            $status->bindValue(':lkatbilgisi',$values["katbilgisi"]);
            $status->bindValue(':lbinayasi',$values["binayasi"]);
            $status->bindValue(':lmetrekare',$values["metrekare"]);
            $status->bindValue(':lmulktipi',$values["mulktipi"]);
            $status->bindValue(':lteklifturu',$values["teklifturu"]);
            $status->bindValue(':ladres',$values["adres"]);
            $status->bindValue(':lil',$values["il"]);
            $status->bindValue(':lilce',$values["ilce"]);
            $status->bindValue(':lsemt',$values["semt"]);
            $status->bindValue(':lanasayfadagoster',$values["anasayfadagoster"]);
            $status->execute();
            
            $result = $this->db->query("select @lid as propertieId")->fetchObject();
            $_SESSION["PROPERTIE"]["id"] = $result->propertieId;
            $_SESSION["PROPERTIE"]["baslik"] = $values["baslik"];
            $_SESSION["PROPERTIE"]["adres"] = $values["adres"];
            header(Application::$app->functions->HTTPStatus(201));
            return $result->propertieId;
        } catch (Exception $e) {
            header(Application::$app->functions->HTTPStatus(400));
            return null;
        }
    }
    public function update($values)
    {
  
        try {
            $status = $this->db->prepare("call up_propertie(:lid,:lbaslik,:laciklama,:lfiyat,:lodasayisi,:lbanyosayisi,:lkatbilgisi,:lbinayasi,:lmetrekare,:lmulktipi,:lteklifturu,:ladres,:lil,:lilce,:lsemt,:lanasayfadagoster)");
            $status->bindValue(":lid",$_SESSION["PROPERTIE"]["id"]);
            $status->bindValue(":lbaslik",$values["baslik"]);
            $status->bindValue(":laciklama",$values["aciklama"]);
            $status->bindValue(":lfiyat",$values["fiyat"]);
            $status->bindValue(":lodasayisi",$values["odasayisi"]);
            $status->bindValue(":lbanyosayisi",$values["banyosayisi"]);
            $status->bindValue(":lkatbilgisi",$values["katbilgisi"]);
            $status->bindValue(":lbinayasi",$values["binayasi"]);
            $status->bindValue(":lmetrekare",$values["metrekare"]);
            $status->bindValue(":lmulktipi",$values["mulktipi"]);
            $status->bindValue(":lteklifturu",$values["teklifturu"]);
            $status->bindValue(":ladres",$values["adres"]);
            $status->bindValue(":lil",$values["il"]);
            $status->bindValue(":lilce",$values["ilce"]);
            $status->bindValue(":lsemt",$values["semt"]);
            $status->bindValue(":lanasayfadagoster",isset($values["anasayfadagoster"]) ? $values["anasayfadagoster"] : PDO::NULL_EMPTY_STRING);
            $status->execute();
            return true;

        } catch (\Exception $e) {
            header(Application::$app->functions->HTTPStatus(400));
            // var_dump($this->db->errorInfo());
            // var_dump($e);
            // echo "hataa catch";
            
            return false;
        }
    }
    public function delete($id)
    {
        $status = $this->db->prepare("update properties set aktif = 0 where id = :lid");
        $status->bindValue(':lid',$id);
        $status->execute();
        return true;
    }
    public function get($values)
    {
        if (isset($values["id"])) {
            $status = $this->db->prepare("call sel_properties(:lid)");
            $status->bindParam(":lid",$values["id"]);
        }else{
            $status = $this->db->prepare("call sel_properties(null)");
        }
        $status->execute();
        return $status->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function deaktif($id)
    {
        $status = $this->db->prepare("update properties set ilanaktif = 0 where id = :lid");
        $status->bindValue(':lid',$id);
        $status->execute();
        return true;
    }
    public function aktif($id)
    {
        $status = $this->db->prepare("update properties set ilanaktif = 1 where id = :lid");
        $status->bindValue(':lid',$id);
        $status->execute();
        return true;
    }
}