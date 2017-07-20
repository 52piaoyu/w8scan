<?php
/*
 * 任务管理
 * 添加 删除
 */
 class Task_Model{
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    /**
	 * 添加文章、页面
	 *
	 * @param array $logData
	 * @return int
	 */
	function addlog($logData) {
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$this->db->query("INSERT INTO " . DB_PREFIX . "tasklist ($field) VALUES ($values)");
		$logid = $this->db->insert_id();
		return $logid;
	}


    function add($url,$descript,$plugins,$spider_plugins,$uid){
        $logData = array();
        $logData["url"] = $url;
        $logData["descript"] = $descript;
        $logData["status"] = 0;
        $logData["addtime"] = time();
        $logData["spider_plugins"] = serialize($spider_plugins);
        $logData["plugins"] = serialize($plugins);
        $logData["token"] = $this->build_token();
        $logData["uid"] = $uid;
        $logData["result"] = '';
        $this->addlog($logData);
        return $logData["token"];
    }

    /**
	 * 显示界面
	 *
	 * @param 
	 * @return array $logData
	 */
    function GetPageData($uid){
        $sql = "SELECT * FROM " . DB_PREFIX . "tasklist where uid='$uid'";
        $res = $this->db->query($sql);
        $logData = [];
        while ($row = $this->db->fetch_array($res)) {
			$logData[] = $row;
		}
        return $logData;
    }

    function build_token(){
        $str = time()."-".rand(100,999);
        return md5($str);
    }

    function getToken($token){
        $sql = "SELECT * FROM " . DB_PREFIX . "tasklist WHERE token='$token' and status=0";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    function update_Result($token,$data){
        $sql = "update " . DB_PREFIX . "tasklist set result = '$data' where token='$token'";
        $res = $this->db->query($sql);
    }

    function update_Status($token,$status){
        $sql = "update " . DB_PREFIX . "tasklist set status = '$data' where token='$token'";
        $res = $this->db->query($sql);
    }
    /**
	 * 删除文章
	 *
	 * @param int $blogId
	 */
	function deleteLog($blogId) {
		$uid = (int)$_SESSION["uid"];
		$author = 'and uid=' . $uid;
		$this->db->query("DELETE FROM " . DB_PREFIX . "tasklist where id=$blogId $author");
		if ($this->db->affected_rows() < 1) {
			emMsg('权限不足！', './');
		}
	}

 }