/*
  1.ajax驗證是post到registerAjax.php。
  2.顯示訊息一開始為hide()，當回傳的data.status有結果時，會顯示動態訊息，
    並更改css樣式來表現成功或失敗。
  3.使用keyup事件能即時監控鍵盤狀況


*/

$(function() {
      $('#username').keyup(checkUserName);
      $('#useremail').keyup(checkUserEmail);
      $('#userpassword').keyup(checkUserPass);

      $('#retype_password').keyup(check_retype_password);
    })

    $('#namemsg').hide();
    $('#emailmsg').hide();
    $('#passwordmsg').hide();
    $('#retype_password_msg').hide();

    $is_false = []; //用來追蹤是否四個輸入項目都通過審核
    function checkUserName() {
      var $username = $('#username').val();
      if (!$username) { //如果輸入欄位為空，把動態訊息隱藏
        $('#namemsg').hide();
      } else { //如果有值，則透過ajax進行驗證
        $.post('registerAjax.php', {username: $username}, function (data) {
        if (data.status == "false") {
          $('#namemsg').removeClass('text-success glyphicon-ok').addClass('text-danger glyphicon-remove').text(data.text).show();
          $is_false['username'] = true;
        } else if (data.status == "special"){
          $('#namemsg').removeClass('text-success glyphicon-remove').addClass('text-danger glyphicon-ok').text(data.text).show();
          $is_false['username'] = false;
        } 
        }, "json");
      }
    }

    function checkUserEmail() {
      var $useremail = $('#useremail').val();
      if (!$useremail) {
        $('#emailmsg').hide();
      } else {
       $.post('registerAjax.php', {useremail: $useremail}, function (data) {
        if (data.status == "false") {
          $('#emailmsg').removeClass('text-success glyphicon-ok').addClass('text-danger glyphicon-remove').text(data.text).show();
          $is_false['useremail'] = true;
        } else { 
          $('#emailmsg').removeClass('text-danger glyphicon-remove').addClass('text-success glyphicon-ok').text(data.text).show();
          $is_false['useremail'] = false;
        }
        }, "json");
      }
    }

    function checkUserPass() {
      var $userpassword = $('#userpassword').val();
      if (!$userpassword) {
        $('#passwordmsg, #retype_password_msg').hide();
        $('#retype_password').val('');
      } else {
      $.post('registerAjax.php', {userpassword: $userpassword}, function (data) {
        if (data.status == "false") {
          $('#passwordmsg').removeClass('text-success glyphicon-ok').addClass('text-danger glyphicon-remove').text(data.text).show();
          $is_false['userpassword'] = true;
        } else { 
          $('#passwordmsg').removeClass('text-danger glyphicon-remove').addClass('text-success glyphicon-ok').text(data.text).show();
          $is_false['userpassword'] = false;
        }
        }, "json");
      }
    }

    function check_retype_password() {
      var $userpassword = $('#userpassword').val();
      var $retype_password = $('#retype_password').val();
      if (!$retype_password) {
        $('#retype_password_msg').hide();
      } else {
      $.post('registerAjax.php', {userpassword: $userpassword, retype_password: $retype_password}, function (data) {
        if (data.status == "false") {
          $('#retype_password_msg').removeClass('text-success glyphicon-ok').addClass('text-danger glyphicon-remove').text(data.text).show();
          $is_false['retype_password'] = true;
        } else { 
          $('#retype_password_msg').removeClass('text-danger glyphicon-remove').addClass('text-success glyphicon-ok').text(data.text).show();
          $is_false['retype_password'] = false;
        }
        }, "json");
      }
    }
    $('#register_form').submit(function (event) {
      //submit前再確認一次
      checkUserName();
      checkUserEmail();
      checkUserPass();
      check_retype_password();
      //如果四個輸入項目沒有同時通過審核，就不開放submit
      if (!($is_false['username'] == false && $is_false['useremail'] == false && $is_false['userpassword'] == false && $is_false['retype_password'] == false)) 
      {
         event.preventDefault();
      } 
    });
    