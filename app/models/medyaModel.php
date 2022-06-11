<?php 
namespace App\Models;
use App\System\Model;
use App\System\Application;
use Exception;
use App\System\Functions;

class Medya extends Model{
    
	/**
	 *
	 * @return array
	 */
	function rules(): array {
        return [];
	}

    public function insert($values)  
    {
        try {
            $status = $this->db->prepare('CALL in_media(@lid,:lmedialink,:lmedyatipi,:lparentet,:lparentid)');
            $status->bindValue(':lmedialink',$values["medialink"]);
            $status->bindValue(':lmedyatipi',$values["medyatipi"]);
            $status->bindValue(':lparentet',$values["parentet"]);
            $status->bindValue(':lparentid',$values["parentid"]);
            $status->execute();
            $result = $this->db->query("SELECT @lid as mediaId")->fetchObject();
            header(Application::$app->functions->HTTPStatus(201));
            return $result->mediaId;
        } catch (Exception $th) {
            echo $th->getMessage();
            header(Application::$app->functions->HTTPStatus(400));
            return false;
        }
    }

    public function update($values)
    {
        
    }

    public function delete($id)
    {
        try {
            $status = $this->db->prepare("call del_media(:lid)");
            $status->bindValue(":lid",$id);
            $status->execute();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function getListByParentID($parentet,$parentid)
    {
        try {
            $status = $this->db->prepare("CALL sel_media(null,null,:lparenet,:lparentid)");
            $status->bindValue(":lparenet",$parentet);
            $status->bindValue(":lparentid", $parentid);
            $status->execute();
            return $status->fetchAll(\PDO::FETCH_ASSOC);


        } catch (\Throwable $th) {
            //throw $th;
            return [];
        }
    }
}