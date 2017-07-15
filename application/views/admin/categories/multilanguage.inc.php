            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Название<?php if($language == $defaultLanguage) echo ' *';?>:
                </label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" id="inp_name<?=$langAdding?>" name="name<?=$langAdding?>" <?php if($language == $defaultLanguage) echo ' required ';?>
                           value=" <?php if (isset($cat['name'.$langAdding])) echo $cat['name'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['name']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Краткое описание:
                </label>
                <div class="col-sm-8">
                    <textarea class="form-control ckeditor" type="text" id="inp_short_content<?=$langAdding?>" name="short_content<?=$langAdding?>"><?php if (isset($cat['short_content'.$langAdding])) echo $cat['short_content'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['short_content'];  ?></textarea>
                    <script>
                        $(document).ready(function () {
                            if ( typeof CKEDITOR !== 'undefined' ) {
                                CKEDITOR.addCss( 'img {max-width:100%; height: auto;}' );
                                var editor = CKEDITOR.replace( 'inp_short_content<?=$langAdding?>', {
                                    extraPlugins: 'uploadimage,image2,codemirror',
                                    removePlugins: 'image',
                                    height:350
                                } );
                                CKFinder.setupCKEditor( editor );
                            } else {
                                document.getElementById( 'editor1' ).innerHTML = '<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor from CDN.</div>'
                            }
                    </script>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Title:
                </label>
                <div class="col-sm-8">
                    <?php
                    //                                                $symbCount = 0;
                    //                                                if(isset($cat['title'.$langAdding])) $symbCount = mb_strlen($cat['title'.$langAdding]);
                    ?>
                    <input class="form-control title" type="text" id="inp_title<?=$langAdding?>" name="title<?=$langAdding?>"
                           value="<?php if (isset($cat['title'.$langAdding])) echo $cat['title'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['title'];  ?>" />

                    Кол-во символов: <span id="msg_title<?=$langAdding?>">0</span>
                </div>
                <div class="col-sm-1"><img src="<?=GENERAL_DOMAIN?>/img/admin/info.png" title="Рекомендуемый размер: от <?=$title_min?> до <?=$title_max?> символов" class="edit-info" /></div>
                <script>
                    $(document).ready(function () {
                        var count = $("#inp_title<?=$langAdding?>").val().length;
                        $("#msg_title<?=$langAdding?>").html(count);
                        if (count < <?=$title_min?> || count > <?=$title_max?>) $("#inp_title<?=$langAdding?>").addClass('worning');
                        else $("#inp_title<?=$langAdding?>").removeClass('worning');

                        $(".title").keyup(function () {
                            var count = $(this).val().length;
                            $("#msg_title<?=$langAdding?>").html(count);
                            if (count < <?=$title_min?> || count > <?=$title_max?>) $(this).addClass('worning');
                            else $(this).removeClass('worning');
                        });
                    });
                </script>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Keywords:
                </label>
                <div class="col-sm-8">
                    <input class="form-control keywords" type="text" id="inp_keywords<?=$langAdding?>" name="keywords<?=$langAdding?>"
                           value=" <?php if (isset($cat['keywords'.$langAdding])) echo $cat['keywords'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['keywords']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <?php
                //                                            $symbCount = 0;
                //                                            if(isset($cat['title'.$langAdding])) $symbCount = mb_strlen($cat['title'.$langAdding]);
                ?>
                <label class="col-sm-2 control-label">
                    Description:
                </label>
                <div class="col-sm-8">
                    <input class="form-control description" type="text" id="inp_description<?=$langAdding?>" name="description<?=$langAdding?>"
                           value="<?php if (isset($cat['description'.$langAdding])) echo $cat['description'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['description']; ?>" />
                    Кол-во символов: <span id="msg_description<?=$langAdding?>">0</span>
                </div>
                <div class="col-sm-1"><img src="<?=GENERAL_DOMAIN?>/img/admin/info.png" title="Рекомендуемый размер: от <?=$description_min?> до <?=$description_max?> символов" class="edit-info" /></div>
                <script>
                    $(document).ready(function () {
                        var count = $("#inp_description<?=$langAdding?>").val().length;
                        $("#msg_description<?=$langAdding?>").html(count);
                        if (count < <?=$description_min?> || count > <?=$description_max?>) $("#inp_description<?=$langAdding?>").addClass('worning');
                        else $("#inp_description<?=$langAdding?>").removeClass('worning');

                        $(".description").keyup(function () {
                            var count = $(this).val().length;
                            $("#msg_description<?=$langAdding?>").html(count);
                            if (count < <?=$description_min?> || count > <?=$description_max?>) $(this).addClass('worning');
                            else $(this).removeClass('worning');
                        });
                    });
                </script>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">
                    SEO-текст:
                </label>
                <div class="col-sm-8">
                    <textarea class="form-control ckeditor" type="text" id="inp_seo<?=$langAdding?>" name="seo<?=$langAdding?>"><?php if (isset($cat['seo'.$langAdding])) echo $cat['seo'.$langAdding]; elseif(isset($cat) && $language == $defaultLanguage) echo $cat['seo']; ?></textarea>
                </div>
            </div>

            <?php
            //$settings = $multiLang;
            //include('application/views/admin/articles/partical.inc.php');
            ?>
            <div class="form-group fixed-buttons">
                <input class="form-submit save" type="submit"
                       name="<?= $action ?>"
                       title="Сохранить" value=""/>&nbsp;
                <input class="form-submit save_and_close"
                       type="submit"
                       name="<?= $action ?>_and_close"
                       title="Сохранить и закрыть"
                       value=""/>
            </div>
       