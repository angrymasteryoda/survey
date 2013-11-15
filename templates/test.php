<?php
include '../assets/inc/meta.php';
echo '<textarea>';
echo Security::sanitize('<lksd>alsk" \'hdlskahdlsahdioejd lasjd lsaj</lksd>clean

');
echo '<lksd>alskdjaslkdhlaskhdlskahdlsahdioejd lasjd lsaj</lksd>clean';
echo '</textarea>';