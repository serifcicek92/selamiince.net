<?php
namespace App\Models;

use App\System\Model;
use PDOException;
use PDO;

class KomboDegerleri extends Model
{
    
	/**
	 *
	 * @return array
	 */
	function rules(): array {
        return [];
    }

    public function getKomboDegerleriByAdi($komboadi)
    {
        try {
            $statement = $this->db->prepare("call sel_kombodegerleriByAdi(:adi)");
            $statement->bindValue(':adi',$komboadi);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            print_r($th->errorInfo);
            echo "error";
        }
    }

    
}