<?php
$db = new mysqli('listelion.cesvnuqqybir1.ap-northeast-2.rds.amazonaws.com', 'listelion', '8878wntjd*', 'listelion');
if($db->connect_error) {
    die('데이터베이스 연결에 문제가 있습니다. 관리자에게 문의 바랍니다.');
}

?>