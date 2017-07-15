<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('mypage', $current_lang); ?>
<script>
var pass_valid = true;
var j = jQuery.noConflict();
j(document).ready(function() {
    j('#form_edit_mypage').on('submit', function() {
        if (!pass_valid || ($("#pass1").val() != $("#pass2").val()) )
            pass_valid = false;    
        return pass_valid;
    });
});
</script>
<div class="content">
    <div class="catalog">
        <div class="clr"></div>            
        <div class="page_tpl_wrap">
            <h1 class="long">
                <?= $this->lang->line('mypage_edit_h1') ?> <?= $user['name'] ?>
            </h1>
            <form id="form_edit_mypage" action="/user/edit-mypage/" method="post">
                <input type="hidden" name="save" value="ok" />
                <table>
                    <tr>
                        <td valign="top">
                            <?= $this->lang->line('mypage_edit_form_full_name') ?>:
                        </td>
                        <td>                                                    
                            <input type="text" name="name" value="<?= $user['name'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <?= $this->lang->line('mypage_edit_form_phone') ?>
                        </td>
                        <td>                                                    
                            <input type="text" name="tel" value="<?= $user['tel'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <?= $this->lang->line('mypage_edit_form_email') ?> *
                        </td>
                        <td>                                                    
                            <input required type="text" name="email" value="<?= $user['email'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?= $this->lang->line('mypage_edit_form_pass') ?>:</td>
                        <td><input id="pass1" type="password" name="pass" value="" /></td>
                    </tr>
                    <tr>
                        <td><?= $this->lang->line('mypage_edit_form_rep_pass') ?>:</td>
                        <td>
                            <input id="pass2" type="password" name="pass2" value="" />
                            <script>
                                $("#pass1").keyup(function() {
                                    var valueX = $("#pass1").val();
                                    var valueY = $("#pass2").val();
                                    if (valueX != valueY) {
                                        pass_valid = false;
                                        $("#ispass").html("<span style='color: red'>Пароли не совпадают!</span>");
                                    }
                                    else
                                    {
                                        pass_valid = true;
                                        $("#ispass").html("<span style='color: green'>Ок!</span>");
                                    }
                                });
                                $("#pass2").keyup(function() {
                                    var valueX = $("#pass1").val();
                                    var valueY = $("#pass2").val();
                                    if (valueX != valueY) {
                                        pass_valid = false;
                                        $("#ispass").html("<span style='color: red'>Пароли не совпадают!</span>");
                                    }
                                    else
                                    {
                                        pass_valid = true;
                                        $("#ispass").html("<span style='color: green'>Ок!</span>");
                                    }
                                });
                            </script>
                        </td>
                        <td><div id="ispass"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" value="<?= $this->lang->line('mypage_edit_form_butt_submit') ?>" /></td>
                    </tr>
                </table>
            </form>
            <?php
            if (isset($my_cart_and_orders) && !empty($my_cart_and_orders)) {
                include("application/views/mod/mycart_table.mod.php");
            } else {?>
            <center>Ваша корзина пуста</center>
            <?php 
            }?>
        </div>
        <div class="clr"></div>
    </div>
</div>
<?php include("application/views/footer.php"); ?>