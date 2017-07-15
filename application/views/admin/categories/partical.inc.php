<?php
if ($settings) {
    foreach ($settings as $s) {
        $name = $s['name'];
        $nameInDb = $name;
        if($s['multilanguage'] == 1/* && ($otherLanguage)*/) {
            $name = $name . '_' . $language['code'];
            if ($otherLanguage) {
                $nameInDb = $s['name'] . '_' . $language['code'];
            }
        }
        $type = $s['type'];
        $params = false;
        if ($s['params'] != NULL) $params = $s['params'];
        $fieldtype = getFieldtypeByName($type);
        $default_value = false;
        if ($s['default_value'] != NULL) $default_value = $s['default_value'];

        $not_edited = false;
        if ($s['not_edited'] == 1) $not_edited = true;
        if ($default_value != '') {
            $default_value = str_replace('[date]', $date, $default_value);
            $default_value = str_replace('[time]', $time, $default_value);
        }
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                <?= $s['rus'] ?>

                <?php if ($s['required'] == 1)
                    echo ' *'; ?>:
            </label>

            <div class="col-sm-8">
                <?php if ($s['info'] != NULL) echo '<span class="info" style="float: right;position: absolute;right: 0;"><img src="/img/admin/info.png" title="' . $s['info'] . '" /></span>'; ?>
                <?php
                if ($fieldtype['view'] == 'checkbox') {                                                                     // CHECKBOX
                    echo '<input id="inp_' . $name . '" type="checkbox" name="' . $name . '"';
                    if (isset($article[$nameInDb]) && $article[$nameInDb] == 1) echo ' checked="checked"';
                    elseif (!isset($article[$nameInDb]) && $default_value == 1) echo ' checked="checked"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" />';
                } elseif ($fieldtype['view'] == 'number') {                                                                 // NUMBER
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' />';
                    echo '<script>
                                $(document).ready(function () {
                                $("input#inp_' . $name . '").TouchSpin({
                                      verticalbuttons: true,
                                      max: 99999999999999,
                                      min: -99999999999999
                                    });
                                });
                         </script>';
                } elseif ($fieldtype['view'] == 'double-number') {                                                          // DOUBLE-NUMBER
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' />';
                    echo '<script>
                                $(document).ready(function () {
                                $("input#inp_' . $name . '").TouchSpin({
                                      verticalbuttons: true,
                                      max: 99999999999999,
                                      min: -99999999999999,
                                      step: 0.1,
                                      decimals: 2,
                                      boostat: 5,
                                      maxboostedstep: 10,
                                    });
                                });
                         </script>';
                } elseif ($fieldtype['view'] == 'text') {                                                                   // TEXT
//                    vd($name);
//                    vd($article[$nameInDb]);
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="form-control" />';
                } elseif ($fieldtype['view'] == 'youtube') {                                                                // YOUTUBE
                    if (isset($article[$nameInDb]) && $article[$nameInDb] != '') {
                        $y = $article[$nameInDb];

                        $pos = strpos($y, 'v=');
                        if ($pos) {
                            $pos = $pos + 2;
                            $end = strpos($y, '&', $pos);
                            $y = substr($y, $pos, $end - $pos);
                        } else {
                            $y = str_replace('http://youtu.be/', '', $article['youtube']);
                            $y = str_replace('https://youtu.be/', '', $article['youtube']);
                        }
                        $article[$nameInDb] = $y;
                        if ($article[$nameInDb] != '')
                            echo '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $article[$nameInDb] . '" frameborder="0" allowfullscreen></iframe><br />';
                    }
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="form-control" />';
                }
//                elseif ($fieldtype['view'] == 'textarea') {                                                               // TEXTAREA
//                    echo '<textarea id="inp_' . $name . '" name="' . $name . '" class="form-control"';
//                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
//                    echo '>';
//                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
//                    elseif ($default_value != NULL) echo $default_value;
//                    echo '</textarea>';
//                }
                elseif ($fieldtype['view'] == 'color') {                                                                    // COLOR
                    $color = "#fff";
                    if (isset($article[$nameInDb])) $color = $article[$nameInDb];
                    echo '
                        <div class="input-group cpicker color" data-color="' . $color . '" data-color-format="hex">
                            <input name="' . $name . '" type="text" readonly class="form-control form-color" value="' . $color . '">
                            <span class="input-group-addon"><i style="background-color: ' . $color . '; margin-left: 8px;"></i></span>
                        </div>
                        <script>
                        $(document).ready(function () {
                        //Color Picker
                                $(\'.cpicker\').colorpicker();
                                
                                $("#inp_' . $name . '").change(function(){
                                    $("#smpl_' . $name . '").css("background-color",$("#inp_' . $name . '").val());
                                });
                        });
                        </script>';
                } elseif ($fieldtype['view'] == 'file') {                                                                   // FILE
                    if(isset($article[$name])) {
                        echo '<input type="text" class="form-control" name="'.$name.'" value="http://'.$_SERVER['SERVER_NAME'].$article[$name].'" />';
                    }
                    echo '
                    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="input-group">
								<div class="form-control uneditable-input" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
								</div>
								<span class="input-group-btn">
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a>
									<span class="btn btn-default btn-file">
										<span class="fileinput-new">Выбрать ';
                    if(isset($article[$name]) && $article[$name] != '') echo 'другой ';
                    echo 'файл</span>
										<span class="fileinput-exists">Изменить</span>
										<input type="file" name="'.$name.'">
									</span>
									
								</span>
							</div>
						</div>
                    ';
                } elseif ($fieldtype['view'] == 'image') {                                                                  // IMAGE
                    if(isset($article[$name])) {
                        echo '<img src="' . $article[$name] . '" alt="'.$name.'" class="img-responsive" id="crop-' . $name . '" style="max-width: 50%">';
                        echo '<input type="text" class="form-control" name="'.$name.'" value="http://'.$_SERVER['SERVER_NAME'].$article[$name].'" />';
                    }
                    echo '
                    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="input-group">
								<div class="form-control uneditable-input" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
								</div>
								<span class="input-group-btn">
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a>
									<span class="btn btn-default btn-file">
										<span class="fileinput-new">Выбрать ';
                    if(isset($article[$name]) && $article[$name] != '') echo 'другой ';
                    echo 'файл</span>
										<span class="fileinput-exists">Изменить</span>										
										<input type="file" name="'.$name.'">
									</span>
									
								</span>
							</div>
						</div>
                    ';
                } elseif ($fieldtype['view'] == 'categories') {                                                             // CATEGORIES
                    if ($name == 'category_id') {     // Выводим список категорий
                        $multiple_categories = getOption('multiple_categories');

                        $cat_ids = false;
                        if (isset($article['category_id'])) {
                            $cat_ids = explode('|', $article['category_id']);
                            if (is_array($cat_ids)) {
                                $count = count($cat_ids);
                                for ($i = 0; $i < $count; $i++) {
                                    //echo (int) $cat_ids[$i].'<hr/>';
                                    $cat_ids[$i] = str_replace('*', '', $cat_ids[$i]);
                                }
                            }
                        }
                        //vdd($cat_ids);
                        echo '<SELECT name="' . $name . '[]"';
                        if ($multiple_categories == 1) echo ' multiple="multiple"';   // Если включена опция нескольких разделов, добавляем multiple
                        echo 'id="select-' . $name . '">';
                        if ($categories) {
                            $optionsTree = new AdminElementsTree('category');
                            $optionsTree->setSelectedOptions($cat_ids);
                            echo $optionsTree->createOptionsTreeForSelect($categories, 0);
                        }
                        echo '</SELECT>';
                        if ($multiple_categories == 1) {
                            echo '<script>
                                    $(document).ready(function () {
                                        $(\'#select-' . $name . '\').multiSelect({
                                            selectableHeader: "<input type=\'text\' class=\'form-control\' style=\'margin-bottom: 10px;\'  autocomplete=\'off\' placeholder=\'Начните вводить...\'>",
                                            selectionHeader: "<input type=\'text\' class=\'form-control\' style=\'margin-bottom: 10px;\' autocomplete=\'off\' placeholder=\'Начните вводить...\'>",
                                            afterInit: function(ms){
                                                var that = this,
                                                $selectableSearch = that.$selectableUl.prev(),
                                                $selectionSearch = that.$selectionUl.prev(),
                                                selectableSearchString = \'#\'+that.$container.attr(\'id\')+\' .ms-elem-selectable:not(.ms-selected)\',
                                                selectionSearchString = \'#\'+that.$container.attr(\'id\')+\' .ms-elem-selection.ms-selected\';
                                    
                                                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                                                .on(\'keydown\', function(e){
                                                    if (e.which === 40){
                                                        that.$selectableUl.focus();
                                                        return false;
                                                    }
                                                });
                                    
                                                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                                                .on(\'keydown\', function(e){
                                                    if (e.which == 40){
                                                        that.$selectionUl.focus();
                                                        return false;
                                                    }
                                                });
                                            },
                                            afterSelect: function(){
                                                this.qs1.cache();
                                                this.qs2.cache();
                                            },
                                            afterDeselect: function(){
                                                this.qs1.cache();
                                                this.qs2.cache();
                                            }
                                        });
                                    });
                             </script>';
                        }
                    }
                } elseif ($fieldtype['view'] == 'select') {                                                                 // SELECT
                    echo '<SELECT name="' . $name . '" class="form-control">';
                    echo '<option></option>';
                    if ($params) {
                        $values = explode('|', $params);
                        if (is_array($values)) {
                            foreach ($values as $value) {
                                echo '<option';
                                if (isset($article[$nameInDb]) && $article[$nameInDb] == $value) echo ' selected';
                                elseif (!isset($article[$nameInDb]) && $default_value != false && $default_value == $value) echo ' selected';
                                echo ' value="' . $value . '">' . $value . '</option>';
                            }
                        }
                    }
                    echo '</SELECT>';
                } elseif ($fieldtype['view'] == 'multiple-select') {                                                        // MULTIPLE-SELECT
                    echo '<SELECT name="' . $name . '[]"  multiple="multiple" id="select-' . $name . '">';
                    echo '<option></option>';
                    if ($params) {
                        $values = explode('|', $params);
                        if (is_array($values)) {
                            $selectedValues = array();
                            if (isset($article[$nameInDb])) $selectedValues = json_decode($article[$nameInDb], true);
                            foreach ($values as $value) {
                                echo '<option';
                                if (in_array($value, $selectedValues)) echo ' selected';
                                //elseif(!isset($article[$nameInDb]) && $default_value != false && $default_value == $value) echo ' selected';
                                echo ' value="' . $value . '">' . $value . '</option>';
                            }
                        }
                    }
                    echo '</SELECT>';
                    echo '<script>
                            $(document).ready(function () {
                                $(\'#select-' . $name . '\').multiSelect({
                                    selectableHeader: "<input type=\'text\' class=\'form-control\' style=\'margin-bottom: 10px;\'  autocomplete=\'off\' placeholder=\'Начните вводить...\'>",
                                    selectionHeader: "<input type=\'text\' class=\'form-control\' style=\'margin-bottom: 10px;\' autocomplete=\'off\' placeholder=\'Начните вводить...\'>",
                                    afterInit: function(ms){
                                        var that = this,
                                        $selectableSearch = that.$selectableUl.prev(),
                                        $selectionSearch = that.$selectionUl.prev(),
                                        selectableSearchString = \'#\'+that.$container.attr(\'id\')+\' .ms-elem-selectable:not(.ms-selected)\',
                                        selectionSearchString = \'#\'+that.$container.attr(\'id\')+\' .ms-elem-selection.ms-selected\';
                            
                                        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                                        .on(\'keydown\', function(e){
                                            if (e.which === 40){
                                                that.$selectableUl.focus();
                                                return false;
                                            }
                                        });
                            
                                        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                                        .on(\'keydown\', function(e){
                                            if (e.which == 40){
                                                that.$selectionUl.focus();
                                                return false;
                                            }
                                        });
                                    },
                                    afterSelect: function(){
                                        this.qs1.cache();
                                        this.qs2.cache();
                                    },
                                    afterDeselect: function(){
                                        this.qs1.cache();
                                        this.qs2.cache();
                                    }
                                });
                            });
                     </script>';
                } elseif ($fieldtype['view'] == 'editor') {                                                                 // EDITOR
                    $class = "";
                    $class = ' ckeditor';
                    echo '<textarea id="inp_' . $name . '" name="' . $name . '" class="form-control' . $class . '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo '>';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '</textarea>
<script>
                            $(document).ready(function () {
                                if ( typeof CKEDITOR !== \'undefined\' ) {
                                    CKEDITOR.addCss( \'img {max-width:100%; height: auto;}\' );
                                    var editor = CKEDITOR.replace( \'inp_'.$name.'\', {
                                        extraPlugins: \'uploadimage,image2,codemirror\',
                                        removePlugins: \'image\',
                                        height:350
                                    } );
                                    CKFinder.setupCKEditor( editor );
                                } else {
                                    document.getElementById( \'editor1\' ).innerHTML = \'<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor from CDN.</div>\'
                                }
                            });
                        </script>
';
                } elseif ($fieldtype['view'] == 'textarea') {                                                               // TEXTAREA
                    echo '<textarea id="inp_' . $name . '" name="' . $name . '" class="form-control"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo '>';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '</textarea>';
                } elseif ($fieldtype['view'] == 'datetime') {                                                               // DATETIME
                    echo '<div class="input-group date" id="dtp-' . $name . '">';
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="form-control" />';
                    echo '<span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <span class="input-group-addon">
                            <i class="fa fa-times"></i>
                        </span>';
                    echo '</div>';
                    echo '<script>
                        $(document).ready(function () {
                            $(\'#dtp-' . $name . '\').datetimepicker({
                                format: \'yyyy-mm-dd HH:ii\',
                                autoclose: 1,
                                todayHighlight: true
                            });
                        });
                    </script>';
                } elseif ($fieldtype['view'] == 'date') {                                                                   // DATE
                    echo '<div class="input-group date" id="dtp-' . $name . '">';
                    echo '<input id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="form-control" />';
                    echo '<span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <span class="input-group-addon">
                            <i class="fa fa-times"></i>
                        </span>';
                    echo '</div>';
                    echo '<script>
                        $(document).ready(function () {
                            $(\'#dtp-' . $name . '\').datepicker({
                                format: \'yyyy-mm-dd\',
                                autoclose: 1,
                                todayHighlight: true
                            });
                        });
                    </script>';
                } elseif ($fieldtype['view'] == 'time') {                                                                   // TIME
                    //echo '<div class="input-group" id="dtp-'.$name.'">';
                    echo '<input data-format="H:mm" id="inp_' . $name . '" type="text" name="' . $name . '" value="';
                    if (isset($article[$nameInDb])) echo $article[$nameInDb];
                    elseif ($default_value != NULL) echo $default_value;
                    echo '"';
                    if (strpos($s['access'], '*' . $myType . '*') === false) echo ' disabled';
                    echo ' class="form-control" />';

                    //echo '</div>';
                    echo '<script>
                        $(document).ready(function () {
                            //Clockface
                            $(\'#inp_' . $name . '\').clockface({
                                format: \'H:mm\'
                            });                            
                        });
                    </script>';
                }
                ?>

            </div>
        </div>
        <?php
    }
}